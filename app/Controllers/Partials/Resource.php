<?php namespace App\Controllers\Partials;

use Illuminate\Support\Str;
use function App\maybe_swap_term;

trait Resource
{

    public static function getShortTitle()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $short_title = get_post_meta($post->ID, 'lc_resource_short_title', true);
            if ($short_title) {
                return $short_title;
            } else {
                return get_the_title($post->ID);
            }
        }

        return false;
    }

    public static function getPermanentLink()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_permanent_link', true);
        }

        return false;
    }

    public static function getPermaCcLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_perma_cc_links', true);
        }

        return false;
    }

    public static function getWaybackMachineLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_wayback_machine_links', true);
        }

        return false;
    }

    public static function getPublicationDate()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $y = get_post_meta($post->ID, 'lc_resource_publication_year', true);
            $m = get_post_meta($post->ID, 'lc_resource_publication_month', true);
            $d = get_post_meta($post->ID, 'lc_resource_publication_day', true);
            return date_i18n(
                get_option('date_format'),
                strtotime(implode('-', [$y, $m, $d]))
            );
        }

        return false;
    }

    public static function getPublicationIsoDate()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $y = get_post_meta($post->ID, 'lc_resource_publication_year', true);
            $m = get_post_meta($post->ID, 'lc_resource_publication_month', true);
            $d = get_post_meta($post->ID, 'lc_resource_publication_day', true);
            return implode('-', [$y, $m, $d]);
        }

        return false;
    }

    public static function getPublisher()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $publisher_name = get_post_meta($post->ID, 'lc_resource_publisher_name', true);
            $publisher_link = get_post_meta($post->ID, 'lc_resource_publisher_link', true);
            if ($publisher_name && $publisher_link) {
                return "<a rel='publisher' href='{$publisher_link}'>{$publisher_name}</a>";
            } elseif ($publisher_name) {
                return $publisher_name;
            }
        }

        return false;
    }

    public static function getLanguage($format = 'slug')
    {
        global $post;

        return pll_get_post_language($post->ID, $format);
    }

    public static function getFormat()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $formats = wp_get_object_terms($post->ID, 'lc_format', ['order' => 'DESC', 'orderby' => 'count']);
            if ($formats) {
                $format = maybe_swap_term($formats[0]);
                return $format->name;
            }
        }

        return false;
    }

    public static function getRegion()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $regions = wp_get_object_terms($post->ID, 'lc_region', ['order' => 'DESC', 'orderby' => 'count']);
            if ($regions) {
                $region = maybe_swap_term($regions[0]);
                return $region->name;
            }
        }

        return false;
    }

    public static function getGoals($limit = 0)
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $goals = wp_get_object_terms(
                $post->ID,
                'lc_goal',
                ['order' => 'DESC', 'orderby' => 'count', 'number' => $limit]
            );
            if ($goals) {
                $result = [];
                foreach ($goals as $goal) {
                    $goal = maybe_swap_term($goal);
                    $result[] = [
                        'name' => Str::title($goal->name),
                        'url' => get_term_link($goal),
                    ];
                }
                return $result;
            }
        }

        return false;
    }

    public static function getTopics($limit = 0)
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $topics = wp_get_object_terms(
                $post->ID,
                'lc_topic',
                ['order' => 'DESC', 'orderby' => 'count', 'number' => $limit]
            );
            if ($topics) {
                $result = [];
                foreach ($topics as $topic) {
                    $topic = maybe_swap_term($topic);
                    $result[] = [
                        'name' => Str::title($topic->name),
                        'url' => get_term_link($topic),
                    ];
                }
                return $result;
            }
        }

        return false;
    }

    public static function getOverflowTopics()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $topics = wp_get_object_terms($post->ID, 'lc_topic', ['order' => 'DESC', 'orderby' => 'count']);
            if ($topics) {
                if (count($topics) < 3) {
                    return false;
                } else {
                    return count($topics) - 2;
                }
            }
        }

        return false;
    }
}
