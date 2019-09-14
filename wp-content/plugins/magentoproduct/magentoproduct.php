<?php
/**
 * Plugin Name: Magento product
 * Plugin URI: https://bluethink.in/
 * Description: This plugin used to get magento product in wordpress post and pages show.this plugin give short code and used post and pages.
 * Version: 1.0
 * Author: Mukesh singh rajpoot
 * Author URI: https://bluethink.in/
 */
function magentoproduct_api_install()
{
    global $wpdb;
    global $magentoproduct_db_version;
    $table_name      = $wpdb->prefix . 'magentoproduct_authenticat';
    $charset_collate = $wpdb->get_charset_collate();
    $sql             = "CREATE TABLE $table_name (
			            id mediumint(9) NOT NULL AUTO_INCREMENT,
			            magento_rest_api_url varchar(50) NOT NULL,
			            last_update datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			            PRIMARY KEY  (id)
			           )$charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('magentoproduct_db_version', $magentoproduct_db_version);
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'magentoproduct_api_install');
/*close code*/
/*Start Deactivate Code*/
register_deactivation_hook(__FILE__, 'magentoproduct_plugin_remove_database');
function magentoproduct_plugin_remove_database()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'magentoproduct_authenticat';
    $sql        = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}
/*Close Deactivate Code*/
//include Files
include(plugin_dir_path(__FILE__) . 'admin/magentoproduct_active.php');
global $wpdb;
$table_name = $wpdb->prefix . 'magentoproduct_authenticat';
$mylink     = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1", ARRAY_A);
$magento_rest_api_url=$mylink['magento_rest_api_url'];
global $magento_rest_api_url;
if ($magento_rest_api_url != "") {
    include(plugin_dir_path(__FILE__) . 'frontend/magentoproductpost.php');
    include(plugin_dir_path(__FILE__) . 'frontend/magentoproductpostcurlresponce.php');
}