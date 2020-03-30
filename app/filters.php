<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'coop-library') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

/**
 * Show twenty resources per page.
 */
add_filter('pre_get_posts', function ($query) {
    if (!is_admin()) {
        if ((is_post_type_archive('lc_resource') || is_tax()) && $query->is_main_query()) {
            if (isset($_GET['order_by'])) {
                switch ($_GET['order_by']) {
                    case 'published':
                        $query->set('meta_key', 'lc_resource_publication_date');
                        $query->set('orderby', 'meta_value');
                        break;
                    case 'favorited':
                        $query->set('meta_key', 'lc_resource_favorites');
                        $query->set('orderby', ['meta_value_num', 'date']);
                        break;
                    case 'viewed':
                        global $wpdb;
                        $args = [
                            'post_type' => 'lc_resource',
                            'show_date' => false,
                            'days'    => 30,
                        ];
                        $start_date = gmdate('Y-m-d', strtotime("-{$args['days']} days"));
                        $end_date   = gmdate('Y-m-d', strtotime('tomorrow midnight'));
                        $sql        = $wpdb->prepare("SELECT p.id, SUM(visitors) As visitors, SUM(pageviews) AS pageviews FROM {$wpdb->prefix}koko_analytics_post_stats s JOIN {$wpdb->posts} p ON s.id = p.id WHERE s.date >= %s AND s.date <= %s AND p.post_type = %s AND p.post_status = 'publish' GROUP BY s.id ORDER BY pageviews DESC", [$start_date, $end_date, $args['post_type']]); // @codingStandardsIgnoreLine
                        $results    = $wpdb->get_results($sql);
                        $viewed_ids = ( ! empty($results) ) ? wp_list_pluck($results, 'id') : [];
                        $unviewed_ids = get_posts([
                            'orderby' => 'date',
                            'order' => 'desc',
                            'post_type' => 'lc_resource',
                            'post__not_in' => $viewed_ids,
                            'posts_per_page' => -1,
                            'fields' => 'ids'
                        ]);
                        $ids = array_merge($viewed_ids + $unviewed_ids);
                        $query->set('post__in', $ids);
                        $query->set('orderby', 'post__in');
                        break;
                    case 'added':
                    default:
                        $query->set('orderby', 'date');
                        break;
                }
            }
            if (isset($_GET['resource_language'])) {
                $meta_query = [
                    'relation' => 'OR'
                ];
                foreach ($_GET['resource_language'] as $lang) {
                    $meta_query[] = [
                        'key' => 'language',
                        'value' => $lang,
                    ];
                }
                $query->set('meta_query', $meta_query);
            }
            $query->set('posts_per_page', 12);
            $query->set('order', 'desc');
        }
    }
});

/**
 * Show sidebar on archive and search pages.
 */
add_filter('sage/display_sidebar', function () {
    if (is_archive()) {
        return true;
    }
});


add_filter('bladesvg', function () {
    return [
        'svg_path' => 'dist/images',
        'inline' => true,
        'class' => 'icon'
    ];
});

add_filter('wp_nav_menu_items', function ($items, $args) {
    if ($args->theme_location === 'primary_navigation') {
        $items .= template('partials.language-switcher');
    }
    return $items;
}, 10, 2);

add_filter('koko_analytics_load_tracking_script', function () {
    if (isset($_COOKIE['track_viewed_resources']) && $_COOKIE['track_viewed_resources'] === 'on') {
        return true;
    }
    return false;
});
