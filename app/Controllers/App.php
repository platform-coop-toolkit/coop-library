<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return pll__('Latest Posts');
        }
        if (is_post_type_archive('lc_resource')) {
            return pll__('Resources');
        }
        if (is_search()) {
            return sprintf(pll__('Search Results for %s'), get_search_query());
        }
        if (is_404()) {
            return pll__('Not Found');
        }
        return get_the_title();
    }
}
