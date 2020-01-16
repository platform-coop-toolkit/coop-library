<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class Page extends Controller
{
    public function taxonomy()
    {
        global $post;

        if (function_exists('pll_get_post_language') && function_exists('pll_get_post_translations')) {
            if (pll_get_post_language($post->ID) !== 'en') {
                $translations = pll_get_post_translations($post->ID);
                $slug = get_post_field('post_name', $translations['en']);
                return 'lc_' . rtrim(str_replace('-', '_', $slug), 's');
            }
        }

        return 'lc_' . rtrim(str_replace('-', '_', $post->post_name), 's');
    }
}
