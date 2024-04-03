<?php

/**
 * Plugin Name: مدیریت کارمندان
 * Plugin URI: https://daneshjooyar.com
 * Description: This plugins is for manage employees
 * Author: محمد نجفی
 * Author URI: https://daneshjooyar.com/teacher/h_m_mood
 * Text Domain: webinp
 * Domain Path: /languages
 */

defined('ABSPATH') || exit;

define('WEBINO_MANAGE_EMPLOYEES_ADMIN_PATH', plugin_dir_path(__FILE__) . 'admin/');
define('WEBINO_MANAGE_EMPLOYEES_VIEW', plugin_dir_path(__FILE__) . 'view/');
define('WEBINO_MANAGE_EMPLOYEES_IMAGE', plugin_dir_url(__FILE__) . 'assets/images/');

add_action('plugins_loaded', function () {
  load_plugin_textdomain(
    'webino',
    false,
    dirname(plugin_basename(__FILE__)) . '/languages'
  );
});

global $wpdb;
$wpdb->wme_employees = 'wp_wme_employees';

if (is_admin()) {
  include(WEBINO_MANAGE_EMPLOYEES_ADMIN_PATH . 'menus.php');
}

function wme_add_employee_stat($result_format)
{
  $GLOBALS['wme_result_format'] = $result_format;
  add_action('login_form', 'wme_add_employee_stat_view');
}

function wme_add_employee_stat_view()
{

  global $wpdb;
  global $wme_result_format;
  $count = $wpdb->get_var("SELECT * FROM {$wpdb->wme_employees}");

  printf(
    translate_nooped_plural($wme_result_format, $count, 'webino'),
    $count
  );
}

register_activation_hook(__FILE__, 'wme_install');
function wme_install()
{

  global $wpdb;


  $sql = "
    CREATE TABLE `wp_wme_employees` (
        `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `first_name` varchar(50) NOT NULL,
        `last_name` varchar(50) NOT NULL,
        `birthdate` date DEFAULT NULL,
        `avatar` varchar(250) NOT NULL,
        `weight` float NOT NULL,
        `mission` smallint(5) unsigned NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`ID`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}
