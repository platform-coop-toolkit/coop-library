<?php namespace App\Controllers\Partials;

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

    public function getPermanentLink()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_permanent_link', true);
        }

        return false;
    }

    public function getPermaCcLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_perma_cc_links', true);
        }

        return false;
    }

    public function getWaybackMachineLinks()
    {
        global $post;

        if ($post->post_type == 'lc_resource') {
            return get_post_meta($post->ID, 'lc_resource_wayback_machine_links', true);
        }

        return false;
    }

    public function getPublicationDate()
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

    public function getPublicationIsoDate()
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

    public function getPublisher()
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
}
