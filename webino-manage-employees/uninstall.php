<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

global $wpdb;

$table_employees = $wpdb->prefix . 'wme_employees';

$wpdb->query("DROP TABLE IF EXISTS $table_employees");
