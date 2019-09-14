<?php
   /*
   Plugin Name: Video Uploade csv
   Plugin URI: http://bluethink.in
   description: a plugin to create our video and other url store database.only used csv file
   Version: 1.2
   Author: Mr. Mukesh singh
   Author URI: http://bluethink.in
   License: GPL2
   */
global $jal_db_version;
$jal_db_version = '1.0';
// run the install scripts upon plugin activation
function uploade_video_install() {
   global $wpdb;
   global $jal_db_version;

   $table_name = $wpdb->prefix . 'video_uploade';
   
   $charset_collate = $wpdb->get_charset_collate();

   $sql = "CREATE TABLE $table_name (
      video_id int(11) NOT NULL AUTO_INCREMENT,
      video_name varchar(600) NOT NULL,
      video_description varchar(600) NOT NULL,
      video_url varchar(600) NOT NULL,
      video_img_url varchar(600) NOT NULL,
      last_update datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      PRIMARY KEY  (video_id)
   ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );

   add_option( 'jal_db_version', $jal_db_version );
}
register_activation_hook( __FILE__, 'uploade_video_install' );

// run the deactivation scripts upon plugin deactivation
register_deactivation_hook(__FILE__, 'uploade_video_remove_database');
function uploade_video_remove_database()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_uploade';
    $sql        = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}
include(plugin_dir_path(__FILE__) . 'admin/videomenu.php');
?>