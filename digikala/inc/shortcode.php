<?php

defined('ABSPATH') || exit;

add_shortcode('digikala', 'render_digikala');

function render_digikala($atts = [], $content = null)
{
    ob_start();

    $atts = shortcode_atts([
        'id' => 0
    ], $atts);

    if (!$atts['id']) {
        return;
    }

    $product_id = $atts['id'];


    return sprintf(
        '<img src="%sPreloader.png" data-dk="%d" alt="preloader" class=" " loading="lazy" width="1032" height="360" />',
        DIGIKALA_IMAGES_URL,
        $product_id

    );
}
