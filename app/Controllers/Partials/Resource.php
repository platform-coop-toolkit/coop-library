<?php namespace App\Controllers\Partials;

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

    public static function getPublisher($show_link = false)
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $publisher_name = get_post_meta($post->ID, 'lc_resource_publisher_name', true);
            $publisher_link = get_post_meta($post->ID, 'lc_resource_publisher_link', true);
            if ($publisher_name && $publisher_link && $show_link) {
                return "<a rel='external publisher' href='{$publisher_link}'>{$publisher_name}</a>";
            } elseif ($publisher_name) {
                return $publisher_name;
            }
        }

        return false;
    }

    public static function getAuthors()
    {
        global $post;
        if ($post->post_type == 'lc_resource') {
            $authors = get_post_meta($post->ID, 'lc_resource_authors', true);
            if ($authors) {
                return $authors;
            }
        }
        return false;
    }

    public static function getLanguage($format = 'slug')
    {
        global $post;

        if (function_exists('pll_get_post_language')) {
            return pll_get_post_language($post->ID, $format);
        }

        return 'en';
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

    public static function getFormatSlug()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $formats = wp_get_object_terms($post->ID, 'lc_format', ['order' => 'DESC', 'orderby' => 'count']);
            if ($formats) {
                $format = maybe_swap_term($formats[0], 'en');
                switch ($format->slug) {
                    case 'academic-paper':
                    case 'thesis':
                        return 'academic-paper';
                        break;
                    case 'article':
                    case 'document':
                    case 'blog-post':
                    case 'journal-article':
                    case 'magazine-article':
                    case 'newspaper-article':
                    case 'web-article':
                        return 'article';
                        break;
                    case 'audio':
                    case 'podcast':
                    case 'radio-broadcast':
                        return 'audio';
                        break;
                    case 'book':
                        return 'book';
                        break;
                    case 'case-study':
                        return 'case-study';
                        break;
                    case 'curriculum':
                        return 'educational-curriculum';
                        break;
                    case 'film':
                    case 'interview':
                    case 'video':
                        return 'video';
                        break;
                    case 'online-training-webinar':
                        return 'online-training';
                        break;
                    case 'presentation-slides':
                        return 'presentation';
                        break;
                    case 'report':
                        return 'report';
                        break;
                    case 'software':
                    case 'toolkit':
                    case 'template':
                        return 'toolkit';
                        break;
                    default:
                        return 'article';
                }
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
                        'name' => $goal->name,
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
                        'name' => $topic->name,
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

    public static function isFavorited()
    {
        global $post;
        $favorites = explode(',', $_COOKIE['favorites']);
        if (in_array($post->ID, $favorites)) {
            return true;
        }
        return false;
    }
}
