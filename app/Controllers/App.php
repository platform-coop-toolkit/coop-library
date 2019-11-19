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

    public function resourceFormat()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $format = get_the_terms($post, 'lc_format');
            if ($format) {
                return $format[0]->name;
            }
        }

        return false;
    }

    public function resourceRegions()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $regions = get_the_terms($post, 'lc_region');
            if ($regions) {
                $result = [];
                foreach ($regions as $region) {
                    $result[] = [
                        'name' => $region->name,
                        'url' => get_term_link($region),
                    ];
                }
                return $result;
            }
        }

        return false;
    }

    public function resourceGoals()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $goals = get_the_terms($post, 'lc_goal');
            if ($goals) {
                $result = [];
                foreach ($goals as $goal) {
                    $result[] = [
                        'name' => $goal->name,
                        'url' => get_term_link($goal),
                    ];
                }
                return $result;
            }
        }

        return false;
    }

    public function resourceTopics()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $topics = get_the_terms($post, 'lc_topic');
            if ($topics) {
                $result = [];
                foreach ($topics as $topic) {
                    $result[] = [
                        'name' => $topic->name,
                        'url' => get_term_link($topic),
                    ];
                }
                return $result;
            }
        }

        return false;
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
