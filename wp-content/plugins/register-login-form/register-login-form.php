<?php 
/*
Plugin Name:  Custom register Login 
Description: Creates an custom register form and login form.it is used in custom form and registration.
Version:     1.0.0
Author:      Pramod Gupta (mukesh singh)
Author URI:  http://bluethink.in 
*/
global $jal_db_version;
$jal_db_version = '1.0';
// run the install scripts upon plugin activation
function register_login_form() {
   global $wpdb;
   global $jal_db_version;

   $table_name = $wpdb->prefix . 'register_login';
   
   $charset_collate = $wpdb->get_charset_collate();

   $sql = "CREATE TABLE $table_name (
      u_id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(600) NOT NULL,
      email varchar(600) NOT NULL,
      u_password varchar(600) NOT NULL,
      u_type varchar(150) NOT NULL,
      mobile_no varchar(150) NOT NULL,
      status ENUM('active', 'deactive') DEFAULT 'deactive' NOT NULL,
      last_update datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY  (u_id)
   ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );

   add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'register_login_form' );


// run the deactivation scripts upon plugin deactivation
register_deactivation_hook(__FILE__, 'register_login_form_remove_database');
function register_login_form_remove_database()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'register_login';
    $sql        = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}
include(plugin_dir_path(__FILE__) . 'admin/admin_menu.php');
include(plugin_dir_path(__FILE__) . 'frontend/signup.php');
