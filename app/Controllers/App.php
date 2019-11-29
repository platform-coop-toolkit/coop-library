<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public function queriedResourceTerms()
    {
        $terms = [
            'language' => [],
            'lc_format' => [],
            'lc_goal' => [],
            'lc_region' => [],
            'lc_topic' => [],
        ];
        global $wp_query;
        if ($wp_query->tax_query) {
            foreach ($wp_query->tax_query->queries as $value) {
                foreach ($value['terms'] as $t) {
                    $terms[$value['taxonomy']][] = $t;
                }
            }
        }
        return $terms;
    }

    public static function title()
    {
        if (is_front_page()) {
            return __('Platform Co-op Resource Library', 'learning-commons');
        }
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'learning-commons');
        }
        if (is_post_type_archive('lc_resource')) {
            return __('Resources', 'learning-commons');
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'learning-commons'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'learning-commons');
        }
        return get_the_title();
    }
}
