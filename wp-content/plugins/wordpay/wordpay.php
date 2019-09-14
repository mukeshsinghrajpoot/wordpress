<?php
defined('ABSPATH') OR exit;
/*
Plugin Name: Wordpay
description: Wordpay plugin used in contentent pay 
Version: 1.2
*/
/*database API*/
global $wordpay_db_version;
$wordpay_db_version = '1.0';
global $apiurl;
$apiurl = "https://devapi.wordpay.io/api/v1/";
function wordpay_api_install()
{
    global $wpdb;
    global $wordpay_db_version;
    $table_name      = $wpdb->prefix . 'wordpay_authenticat';
    $charset_collate = $wpdb->get_charset_collate();
    $sql             = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            cpd_id mediumint(10) NOT NULL,
            company_id mediumint(11) NOT NULL,
            uname varchar(50) NOT NULL,
            production varchar(50) DEFAULT '0' NOT NULL,
            apikey varchar(50) NOT NULL,
            secretkey varchar(50) NOT NULL,
            domain varchar(50) NOT NULL,
            selected varchar(50) NOT NULL,
            last_update datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
           )$charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('wordpay_db_version', $wordpay_db_version);
    add_option('apiurl', $apiurl);
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'wordpay_api_install');
/*close code*/
/*Start Deactivate Code*/
register_deactivation_hook(__FILE__, 'wordpay_plugin_remove_database');
function wordpay_plugin_remove_database()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wordpay_authenticat';
    $sql        = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}
/*Close Deactivate Code*/
//include Files
include(plugin_dir_path(__FILE__) . 'admin/wordpay_active.php');
global $wpdb;
$table_name = $wpdb->prefix . 'wordpay_authenticat';
$mylink     = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1", ARRAY_A);
$apikey     = $mylink['apikey'];
$secretkey  = $mylink['secretkey'];
$domain     = $mylink['domain'];
$domain1    = site_url();
if ($secretkey != "" && $apikey != "" && $domain1 == $domain) {
    include(plugin_dir_path(__FILE__) . 'frontend/post.php');
    include(plugin_dir_path(__FILE__) . 'frontend/postcurlresponce.php');
}