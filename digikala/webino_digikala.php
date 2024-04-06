<?php

/**
 * Plugin Name: محصولات دیجی کالا
 * Plugin URI: https://webinodesign.ir
 * Author: mohammad najfi
 * Description: this for show digikala products
 */

defined('ABSPATH') || exit;

define('DIGIKALA_VERSION', '1.0.0');
define('DIGIKALA_URL', plugin_dir_url(__FILE__));
define('DIGIKALA_ASSETS_URL', DIGIKALA_URL . 'assets/');
define('DIGIKALA_CSS_URL', DIGIKALA_ASSETS_URL . 'css/');
define('DIGIKALA_JS_URL', DIGIKALA_ASSETS_URL . 'js/');
define('DIGIKALA_IMAGE_URL', DIGIKALA_ASSETS_URL . 'images/');

define('DIGIKALA_PATH', plugin_dir_path(__FILE__));
define('DIGIKALA_ADMIN_PATH', DIGIKALA_PATH . 'admin/');
define('DIGIKALA_VIEW_PATH', DIGIKALA_PATH . 'view/');
define('DIGIKALA_INC_PATH', DIGIKALA_PATH . 'inc/');

require(DIGIKALA_INC_PATH . 'functions.php');
require(DIGIKALA_INC_PATH . 'shortcode.php');
require(DIGIKALA_INC_PATH . 'enqueue.php');
require(DIGIKALA_INC_PATH . 'ajax.php');
