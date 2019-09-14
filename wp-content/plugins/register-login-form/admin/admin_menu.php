<?php 

add_action('admin_menu', 'my_menu_register');
function my_menu_register(){
    add_menu_page(
      'register',  /*Url name show*/
      'register view',   /*name*/
      'manage_options',  /*manage*/
      'register-menu',        /*page name*/
      'register_tab1',  /*function name*/
      plugins_url('/img/bluethink_icon.ico', __FILE__),6
      );
      add_submenu_page('register-menu', 'register view', 'register', 'manage_options', 'register-menu' );
      /*add_submenu_page('wordpay-menu', 'setting load', 'Settings', 'manage_options', 'setting' , 'wordpay_tab');
      add_submenu_page( 'wordpay-menu', 'price range', 'Price Range','manage_options', 'edit.php?post_type=price-range');*/
}

function register_tab1()
{
      echo "test";
}