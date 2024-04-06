<?php
add_action('wp_ajax_dk_get_product', 'load_digikala');
add_action('wp_ajax_nopriv_dk_get_product', 'load_digikala');

function load_digikala()
{
    $result = [
        'success' => false,
        'message' => 'خطایی رخ داد'
    ];

    if (!isset($_GET['id'])) {
        $result['message'] = 'شناسه محصول ارسال نشده است';

        wp_send_json_error($result, 400);
    }


    $product_id = absint($_GET['id']);

    $html = digikala_product_render($product_id);

    $result['html'] = $html;
    $result['success'] = 1;

    wp_send_json_success($result, 200);
}
