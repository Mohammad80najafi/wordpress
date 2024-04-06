<?php

defined('ABSPATH') || exit;

add_action('wp_enqueue_scripts', function () {

    global $post;

    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'digikala')) {
        wp_enqueue_style(
            'digikala_style',
            DIGIKALA_CSS_URL . 'style.css',
            [],
            WP_DEBUG ? time() : DIGIKALA_VERSION,
            'all'
        );

        wp_enqueue_script(
            'digikala_script',
            DIGIKALA_JS_URL . 'script.js',
            ['jquery'],
            WP_DEBUG ? time() : DIGIKALA_VERSION,
            true
        );

        wp_localize_script(
            'digikala_script',
            'digikala_dk',
            [
                'ajax_url' => admin_url('admin-ajax.php')
            ]
        );
    }
});
