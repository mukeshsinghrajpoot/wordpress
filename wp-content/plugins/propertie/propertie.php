<?php
   /*
   Plugin Name: propertie
   description: Add our propertie 
   Version: 1.2
   Author: Mr. Mukesh singh
   Author URI: http://www.bluethink.in/
   License: GPL22
   */
?>
<?php 					
global $jal_db_version;
$jal_db_version = '1.0';

function xml_data_install() {
	global $wpdb;
	global $jal_db_version;

	$table_name = $wpdb->prefix . 'xml_data';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		permit_number int(100) NOT NULL,
		last_update datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		reference_number varchar(200),
		offering_type varchar(200),
		property_type varchar(200),
		price_on_application	varchar(50),
		price	int(50),	 
		city	varchar(50), 
		community	varchar(100),	 
		sub_community	varchar(200),	 
		title_en	varchar(200), 
		description_en	varchar(1500),
		amenities	text ,	 
		size	int(40) , 
		bedroom	int(20) , 
		bathroom	int(20) ,	 
		name	varchar(30) , 
		email	varchar(50) ,	 
		phone	varchar(50) ,	 
		developer	varchar(50) ,	 
		parking	varchar(255) , 
		furnished	varchar(255) , 
		photo	longtext ,	 
		geopoints	varchar(200) ,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'jal_db_version', $jal_db_version );
}

// run the install scripts upon plugin activation
register_activation_hook( __FILE__, 'xml_data_install' );
/*menu code*/
add_action('admin_menu', 'my_menu_pages1');
function my_menu_pages1(){?>
	<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/propertie/bootstrap/css/custom1.css" rel="stylesheet" />
	<?php 
    add_menu_page('My Page Title', 'propertie add', 'manage_options', 'propertie', 'add_propertie',plugins_url('/img/bluethink_icon.ico', __FILE__));
    add_submenu_page('propertie', 'propertie view', 'View propertie', 'manage_options', 'propertie-view' , 'viewpropertie');
    add_submenu_page('propertie', 'script load', 'Propertie Script', 'manage_options', 'propertie-script' , 'loadscript');
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'addpropertie.php');
?>
