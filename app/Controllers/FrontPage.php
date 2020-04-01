<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{
    public function mostViewed()
    {
        global $wpdb;
        $args = [
            'number'    => 4,
            'post_type' => 'lc_resource',
            'show_date' => false,
            'days'    => 30,
        ];
        $start_date = gmdate('Y-m-d', strtotime("-{$args['days']} days"));
        $end_date   = gmdate('Y-m-d', strtotime('tomorrow midnight'));
        $sql        = $wpdb->prepare("SELECT p.id, SUM(visitors) As visitors, SUM(pageviews) AS pageviews FROM {$wpdb->prefix}koko_analytics_post_stats s JOIN {$wpdb->posts} p ON s.id = p.id WHERE s.date >= %s AND s.date <= %s AND p.post_type = %s AND p.post_status = 'publish' GROUP BY s.id ORDER BY pageviews DESC LIMIT 0, %d", [$start_date, $end_date, $args['post_type'], $args['number']]); // @codingStandardsIgnoreLine
        $results    = $wpdb->get_results($sql);
        $viewed_ids = ( ! empty($results) ) ? wp_list_pluck($results, 'id') : [];
        $unviewed_ids = get_posts([
            'orderby' => 'date',
            'order' => 'desc',
            'post_type' => 'lc_resource',
            'post__not_in' => $viewed_ids,
            'posts_per_page' => 4,
            'fields' => 'ids',
        ]);
        $ids = array_merge($viewed_ids + $unviewed_ids);

        return new \WP_Query([
            'post_type' => 'lc_resource',
            'post__in' => $ids,
            'orderby' => 'post__in',
            'posts_per_page' => 4,
        ]);
    }

    public function recentlyPublished()
    {
        return new \WP_Query([
            'post_type' => 'lc_resource',
            'meta_key' => 'lc_resource_publication_date',
            'orderby' => 'meta_value',
            'posts_per_page' => 4,
            'order' => 'desc',
        ]);
    }
}
