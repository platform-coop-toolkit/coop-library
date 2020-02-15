<?php

namespace App;

/**
 * AJAX hook which can be used to increment or decrement a resource's favorite count.
 */
function update_favorites()
{
    if (!check_ajax_referer('coop-library-framework-nonce', 'coop_library_nonce')) {
        wp_send_json_error('Invalid security token.');
        wp_die();
    }

    $ids = explode(',', $_POST['post_id']);

    foreach ($ids as $id) {
        $post_id   = absint($id);
        $favorites = get_post_meta($post_id, 'lc_resource_favorites', true);
        switch ($_POST['operation']) {
            case 'increment':
                $favorites++;
                break;
            case 'decrement':
                $favorites--;
                break;
        }
        update_post_meta($post_id, 'lc_resource_favorites', $favorites);
    }
    die(0);
}
