<?php
/*
Plugin Name: Simple Newsletter Plugin
Description: Ein einfaches Newsletter-Plugin für WordPress.
Version: 1.0
Author: Onur Zengin
*/

// Aktiviere das Plugin
register_activation_hook(__FILE__, 'sn_activate');

function sn_activate() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(50) NOT NULL,
        email varchar(50) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deaktiviere das Plugin
register_deactivation_hook(__FILE__, 'sn_deactivate');

function sn_deactivate() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $sql = "DROP TABLE IF EXISTS $table_name;";

    $wpdb->query($sql);
}

// Inkludiere die anderen Dateien
include(plugin_dir_path(__FILE__) . 'shortcodes/subscribe_form.php');
include(plugin_dir_path(__FILE__) . 'admin_dashboard/menu.php');
include(plugin_dir_path(__FILE__) . 'admin_dashboard/listall.php');
include(plugin_dir_path(__FILE__) . 'admin_dashboard/sendmessages.php');

?>
