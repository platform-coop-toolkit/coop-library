<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Single extends Controller
{
    public function resourcePermanentLink()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_permanent_link', true);
        }

        return false;
    }

    public function resourcePermaCcLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_perma_cc_links', true);
        }

        return false;
    }

    public function resourceWaybackMachineLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_wayback_machine_links', true);
        }

        return false;
    }

    public function resourcePublicationDate()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return date_i18n(
                get_option('date_format'),
                strtotime(get_post_meta($post->ID, 'lc_resource_publication_date', true))
            );
        }

        return false;
    }

    public function resourcePublicationIsoDate()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_publication_date', true);
        }

        return false;
    }

    public function resourcePublisher()
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
}
