<?php namespace App\Controllers\Partials;

use function App\maybe_swap_term;
use function App\natural_language_join;

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
            $links = [];
            if (have_rows('lc_resource_perma_cc_links')) :
                while (have_rows('lc_resource_perma_cc_links')) :
                    the_row();
                    $links[] = get_sub_field('perma_cc_link');
                endwhile;
            endif;
            return $links;
        }

        return false;
    }

    public static function getWaybackMachineLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $links = [];
            if (have_rows('lc_resource_wayback_machine_links')) :
                while (have_rows('lc_resource_wayback_machine_links')) :
                    the_row();
                    $links[] = get_sub_field('wayback_machine_link');
                endwhile;
            endif;
            return $links;
        }

        return false;
    }

    public static function getPublicationDate($format = false)
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            if (!$format) {
                $format = get_option('date_format');
            }
            $date = get_post_meta($post->ID, 'lc_resource_publication_date', true);

            if ($date !== 'ongoing') {
                return date_i18n($format, strtotime($date));
            }
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
            $authors = [];
            if (have_rows('lc_resource_author')) :
                while (have_rows('lc_resource_author')) :
                    the_row();
                    $authors[] = get_sub_field('author');
                endwhile;
            endif;
            return natural_language_join($authors);
        }
        return false;
    }

    public static function getLanguage($format = 'slug')
    {
        global $post;

        if ($format === 'slug') {
            return get_post_meta($post->ID, 'language', true);
        }
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

    public static function getFormatIcon()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            $formats = wp_get_object_terms($post->ID, 'lc_format', ['order' => 'DESC', 'orderby' => 'count']);
            if ($formats) {
                $format = maybe_swap_term($formats[0], 'en');
                switch ($format->slug) {
                    case 'academic-paper':
                    case 'thesis':
                        return 'academic';
                        break;
                    case 'blog-post':
                        return 'blog';
                        break;
                    case 'article':
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
                        return 'curriculum';
                        break;
                    case 'film':
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
                        return 'toolkit';
                        break;
                    case 'template':
                        return 'template';
                        break;
                    case 'document':
                    default:
                        return 'document';
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
        if (isset($_COOKIE['favorites'])) {
            $favorites = explode(',', $_COOKIE['favorites']);
            if (in_array($post->ID, $favorites)) {
                return true;
            }
        }
        return false;
    }

    public static function requiresSubscription()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return (get_post_meta($post->ID, 'lc_resource_has_paywall', true) === 'on');
        }

        return false;
    }
}
