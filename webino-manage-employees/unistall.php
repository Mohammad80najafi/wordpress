<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

global $wpdb;

$total_employees = $wpdb->prefix . 'wme_employees';

$wpdb->query("DROP TABLE IF EXISTS $total_employees");
