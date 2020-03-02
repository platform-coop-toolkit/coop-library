<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class PageFavorites extends Controller
{
    public function favorites()
    {
        return new \WP_Query([
            'post_type' => 'lc_resource',
            'post__in' => explode(',', $_COOKIE['favorites']),
            'orderby' => 'title',
            'posts_per_page' => 12,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            'order' => 'asc',
            'lang' => '',
        ]);
    }
}
