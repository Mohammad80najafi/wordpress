<?php

/**
 * Plugin Name: webino post like
 * Plugin URI: https://webinodesign.ir
 * Author: mohammad najafi
 * Author URI: https://webinodesign.ir
 * Description: this plugin for like postes
 * Text Domain: webino
 * Domain Path: /lanquages
 */

defined('ABSPATH') || exit;

define('WEBINO_POST_LIKE_VERSION', '1.0.0');
define('WEBINO_POST_LIKE_INC_PATH', plugin_dir_path(__FILE__) . 'inc/');
define('WEBINO_POST_LIKE_JS_URL', plugin_dir_url(__FILE__) . 'assets/js/');
define('WEBINO_POST_LIKE_CSS_URL', plugin_dir_url(__FILE__) . 'assets/css/');

add_action('plugins_loaded', function () {
    load_plugin_textdomain('webino', false, dirname(plugin_basename(__FILE__)) . '/lanquages');
});



global $wpdb;

$wpdb->wpl_post_likes = $wpdb->prefix . 'wpl_post_likes';

require_once(WEBINO_POST_LIKE_INC_PATH . 'functions-like.php');
require_once(WEBINO_POST_LIKE_INC_PATH . 'functions.php');

register_activation_hook(__FILE__, 'webino_post_like_install');

add_action('wp_enqueue_scripts', 'webino_post_like_script');
add_action('wp_head', 'webino_post_like_style');
add_filter('the_content', 'webino_post_like_button');
add_action('wp_ajax_wpl_like', 'webino_post_like_ajax_callback');
add_action('wp_ajax_nopriv_wpl_like', 'webino_post_like_ajax_callback');
