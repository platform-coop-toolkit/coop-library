<?php

namespace App;

class Walker extends \Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) /* @codingStandardsIgnoreLine */
    {
        $item_output = '';

        $classes = $item->classes;

        if ($args->walker->has_children) {
            $classes[] = 'menu__submenu-wrapper';
        }

        apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth);

        $classes_str  = implode(' ', $classes);

        $before = $args->before;

        $before = sprintf($before, $classes_str);

        $item_output .= $before;

        $atts = [];
        $atts['title'] = esc_attr($item->attr_title);
        $atts['target'] = esc_attr($item->target);
        $atts['rel'] = esc_attr($item->xfn);
        $atts['href'] = esc_url($item->url);
        $atts['aria-current'] = $item->current ? 'page' : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $atts_str = '';
        foreach ($atts as $k => $v) {
            if (empty($v)) {
                continue;
            }
            $atts_str .= " $k='$v' ";
        }

        $label = apply_filters('the_title', $item->title, $item->ID);

        $item_output .= "<a $atts_str class='menu__item'>$label</a>";

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function end_el(&$output, $item, $depth = 0, $args = []) /* @codingStandardsIgnoreLine */
    {

        $after = $args->after;

        $output .= $after;
    }

    public function start_lvl(&$output, $depth = 0, $args = array()) /* @codingStandardsIgnoreLine */
    {
        $submenu_classes = 'menu__submenu';

        $before_submenu = $args->before_submenu;

        $before = sprintf($before_submenu, $submenu_classes);

        $output .= $before;
    }

    public function end_lvl(&$output, $depth = 0, $args = array()) /* @codingStandardsIgnoreLine */
    {

        $after = $args->after_submenu;

        $output .= $after;
    }
}
