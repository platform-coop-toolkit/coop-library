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
