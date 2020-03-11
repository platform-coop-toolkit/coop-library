<?php

namespace App\Controllers;

use Sober\Controller\Controller;

use function \CoopLibraryFramework\Internationalization\get_language_list;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public function notifications()
    {
        // TODO: This could be more elegant.
        if (isset($_POST['track_viewed_resources'])) {
            return [
                [
                    'title' => __('Settings saved'),
                    'type' => 'success',
                    'content' => sprintf('<p>%s</p>', __('Your settings have been saved.', 'coop-library'))
                ]
            ];
        }
    }

    public function trackViewedResources()
    {
        if (isset($_POST['track_viewed_resources']) && $_POST['track_viewed_resources'] === 'on') {
            return 'on';
        } elseif (isset($_POST['track_viewed_resources']) && $_POST['track_viewed_resources'] === '') {
            return false;
        }
        if (isset($_COOKIE['track_viewed_resources']) && $_COOKIE['track_viewed_resources'] === 'on') {
            return 'on';
        }
        return false;
    }

    public function queriedResourceTerms()
    {
        $langs = get_language_list(pll_current_language('locale'));
        $terms = [
            'language' => [],
            'lc_format' => [],
            'lc_goal' => [],
            'lc_region' => [],
            'lc_topic' => [],
            'lc_coop_type' => [],
            'lc_sector' => [],
        ];
        global $wp_query;
        if ($wp_query->tax_query) {
            foreach ($wp_query->tax_query->queries as $value) {
                foreach ($value['terms'] as $t) {
                    $terms[$value['taxonomy']][$t] = get_term_by('slug', $t, $value['taxonomy'])->name;
                }
            }
        }
        if (isset($_GET['language'])) {
            foreach ($_GET['language'] as $lang) {
                $terms['language'][ $lang ] = $langs[$lang];
            }
        }
        return $terms;
    }

    public function availableLanguages()
    {
        if (function_exists('pll_the_languages') && function_exists('pll_current_language')) {
            $polylang_languages = pll_the_languages(['raw' => 1, 'hide_if_empty' => 0]);
            $available_languages = [];

            foreach ($polylang_languages as $lang) {
                $available_languages[$lang['slug']] = $lang['name'];
            }

            return $available_languages;
        }

        return ['en' => 'English'];
    }

    public function languages()
    {
        if (function_exists('pll_current_language')) {
            return get_language_list(pll_current_language('locale'));
        }
        return get_language_list('en_US');
    }

    public function currentLanguageName()
    {
        if (function_exists('pll_current_language')) {
            return pll_current_language('name');
        }
        return 'English';
    }

    public function currentLanguageLocale()
    {
        if (function_exists('pll_current_language')) {
            return pll_current_language('locale');
        }
        return 'en_US';
    }

    public function currentLanguage()
    {
        if (function_exists('pll_current_language')) {
            return pll_current_language();
        }
        return 'en';
    }

    public function foundPosts()
    {
        global $wp_query;
        return $wp_query->found_posts;
    }

    public function totalPages()
    {
        global $wp_query;
        return isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
    }

    public function maxPages()
    {
        global $wp_query;
        return $wp_query->max_num_pages;
    }

    public function currentPage()
    {
        global $wp_query;
        return $wp_query->query_vars['paged'] > 1 ? intval($wp_query->query_vars['paged']) : 1;
    }

    public static function paginateLinks($current = false, $total = false, $args = [])
    {
        global $wp_query, $wp_rewrite;

        // Setting up default values based on the current URL.
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $url_parts    = explode('?', $pagenum_link);

        // Get max pages and current page out of the current query, if available.
        if (!$total) {
            $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        }
        if (!$current) {
            $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        }

        // Append the format placeholder to the base URL.
        $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

        // URL base depends on permalink settings.
        $format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ?
            user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') :
            '?paged=%#%';

        $defaults = array(
            'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
            'format' => $format, // ?page=%#% : %#% is replaced by the page number
            'total' => $total,
            'current' => $current,
            'aria_current' => 'page',
            'show_all' => false,
            'prev_next' => true,
            'prev_text' => __('&laquo; Previous'),
            'next_text' => __('Next &raquo;'),
            'end_size' => 1,
            'mid_size' => 2,
            'type' => 'plain',
            'add_args' => array(), // array of query args to add
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number'  => '',
        );

        $args = wp_parse_args($args, $defaults);

        if (! is_array($args['add_args'])) {
            $args['add_args'] = array();
        }

        // Merge additional query vars found in the original URL into 'add_args' array.
        if (isset($url_parts[1])) {
            // Find the format argument.
            $format       = explode('?', str_replace('%_%', $args['format'], $args['base']));
            $format_query = isset($format[1]) ? $format[1] : '';
            wp_parse_str($format_query, $format_args);

            // Find the query args of the requested URL.
            wp_parse_str($url_parts[1], $url_query_args);

            // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
            foreach ($format_args as $format_arg => $format_arg_value) {
                unset($url_query_args[ $format_arg ]);
            }

            $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
        }

        // Who knows what else people pass in $args
        $total = (int) $args['total'];
        if ($total < 2) {
            return;
        }
        $current  = (int) $args['current'];
        $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
        if ($end_size < 1) {
            $end_size = 1;
        }
        $mid_size = (int) $args['mid_size'];
        if ($mid_size < 0) {
            $mid_size = 2;
        }

        $add_args   = $args['add_args'];
        $r          = '';
        $page_links = array();
        $dots       = false;

        if ($args['prev_next'] && $current && 1 < $current) :
            $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
            $link = str_replace('%#%', $current - 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            $page_links[] = sprintf(
                '<a class="link link--pagination prev" href="%s">%s</a>',
                /**
                 * Filters the paginated links for the given archive pages.
                 *
                 * @since 3.0.0
                 *
                 * @param string $link The paginated link URL.
                 */
                esc_url(apply_filters('paginate_links', $link)),
                $args['prev_text']
            );
        endif;

        for ($n = 1; $n <= $total; $n++) :
            if ($n == $current) :
                $page_links[] = sprintf(
                    '<span aria-current="%s" class="page current">%s</span>',
                    esc_attr($args['aria_current']),
                    $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
                );

                $dots = true;
            else :
                if ($args['show_all'] ||
                    ( $n <= $end_size ||
                    ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) ||
                    $n > $total - $end_size
                )) :
                    $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
                    $link = str_replace('%#%', $n, $link);
                    if ($add_args) {
                        $link = add_query_arg($add_args, $link);
                    }
                    $link .= $args['add_fragment'];

                    $page_links[] = sprintf(
                        '<a class="link link--pagination" href="%s">%s</a>',
                        /** This filter is documented in wp-includes/general-template.php */
                        esc_url(apply_filters('paginate_links', $link)),
                        $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
                    );

                    $dots = true;
                elseif ($dots && ! $args['show_all']) :
                    $page_links[] = '<span class="page dots">' . __('&hellip;') . '</span>';

                    $dots = false;
                endif;
            endif;
        endfor;

        if ($args['prev_next'] && $current && $current < $total) :
            $link = str_replace('%_%', $args['format'], $args['base']);
            $link = str_replace('%#%', $current + 1, $link);
            if ($add_args) {
                $link = add_query_arg($add_args, $link);
            }
            $link .= $args['add_fragment'];

            $page_links[] = sprintf(
                '<a class="link link--pagination next" href="%s">%s</a>',
                /** This filter is documented in wp-includes/general-template.php */
                esc_url(apply_filters('paginate_links', $link)),
                $args['next_text']
            );
        endif;

        switch ($args['type']) {
            case 'array':
                return $page_links;

            case 'list':
                $r .= "<ul class='page-numbers'>\n\t<li>";
                $r .= join("</li>\n\t<li>", $page_links);
                $r .= "</li>\n</ul>\n";
                break;

            default:
                $r = join("\n", $page_links);
                break;
        }

        return $r;
    }

    public static function getPagination($args = [])
    {
        $navigation = '';

        if (!isset($args['total'])) {
            $args['total'] = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
        }

        // Don't print empty markup if there's only one page.
        if ($args['total'] > 1) {
            // Make sure the nav element has an aria-label attribute: fallback to the screen reader text.
            if (! empty($args['screen_reader_text']) && empty($args['aria_label'])) {
                $args['aria_label'] = $args['screen_reader_text'];
            }

            $args = wp_parse_args(
                $args,
                array(
                    'mid_size'           => 1,
                    'prev_text'          => sprintf(
                        '&lsaquo; <span class="screen-reader-text">%s</span>',
                        __('previous', 'coop-library')
                    ),
                    'next_text'          => sprintf(
                        ' <span class="screen-reader-text">%s</span> &rsaquo;',
                        __('next', 'coop-library')
                    ),
                    'screen_reader_text' => __('Resources navigation', 'coop-library'),
                    'aria_label'         => __('resources', 'coop-library'),
                )
            );

            // Make sure we get a string back. Plain is the next best thing.
            if (isset($args['type']) && 'array' == $args['type']) {
                $args['type'] = 'plain';
            }

            // Set up paginated links.
            $links = App::paginateLinks($current, $total, $args);
            if ($links) {
                $navigation = _navigation_markup(
                    $links,
                    'pagination',
                    $args['screen_reader_text'],
                    $args['aria_label']
                );
            }
        }

        return $navigation;
    }

    public static function totalPosts($post_type = null)
    {
        if ($post_type) {
            return wp_count_posts($post_type)->publish;
        }

        return 0;
    }

    public static function sortUrl($order_by)
    {
        return add_query_arg('order_by', $order_by);
    }

    public static function getMetaValues($key = '', $type = 'post', $status = 'publish')
    {
        global $wpdb;

        if (empty($key)) {
            return;
        }

        $results = $wpdb->get_col(
            $wpdb->prepare(
                "
            SELECT pm.meta_value FROM {$wpdb->postmeta} pm
            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = %s
            AND p.post_status = %s
            AND p.post_type = %s
        ",
                $key,
                $status,
                $type
            )
        );

        return array_unique($results);
    }

    public static function title()
    {
        if (is_front_page()) {
            return __(
                '<span class="pc-ff--sans pc-fw--normal">Platform Co-op</span><br />Resource Library',
                'coop-library'
            );
        }
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'coop-library');
        }

        if (is_search()) {
            return sprintf(__('Search results', 'coop-library'), get_search_query());
        }

        if (is_post_type_archive('lc_resource') || is_tax()) {
            return __('Browse all', 'coop-library');
        }

        if (is_404()) {
            return __('Not Found', 'coop-library');
        }

        return get_the_title();
    }

    public static function breadcrumb()
    {
        if (is_front_page()) {
            return false;
        }
        return sprintf('<a href="%1$s">%2$s</a>', get_home_url(), __('Home', 'coop-library'));
    }

    public static function termListUrl($taxonomy)
    {
        $slug = str_replace('lc_', '', $taxonomy) . 's';
        $page = get_page_by_path($slug);
        return get_permalink($page->ID);
    }
}
