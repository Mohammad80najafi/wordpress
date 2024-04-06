<?php

function digikala_product_render($product_id)
{
    $html = '';

    $results = wp_remote_get(sprintf('https://api.digikala.com/v1/product/%d/', $product_id));


    if (is_wp_error($results) || wp_remote_retrieve_response_message($results) !== 200) {
        return $html;
    }

    $data = json_decode(wp_remote_retrieve_body($results));
    $product = $data->data->product;
    $price = $product->default_variant->price->rrp_price;
    $sale_price = $product->default_variant->price->selling_price;
    $discount = $price == $sale_price ? 0 : round(($price - $sale_price) / $price * 100);
    ob_start();
    include(DIGIKALA_VIEW_PATH . 'product-view.php');
    return ob_get_clean();
}
