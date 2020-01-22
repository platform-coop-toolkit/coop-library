<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function mostViewed()
    {
        return new \WP_Query([
            'post_type' => 'lc_resource',
            'meta_key' => 'lc_resource_views',
            'orderby' => ['meta_value_num', 'date'],
            'posts_per_page' => 4,
            'order' => 'desc',
            'lang' => '',
        ]);
    }

    public function recentlyPublished()
    {
        return new \WP_Query([
            'post_type' => 'lc_resource',
            'meta_key' => 'lc_resource_publication_date',
            'orderby' => ['meta_value', 'date'],
            'posts_per_page' => 4,
            'order' => 'desc',
            'lang' => '',
        ]);
    }
}
