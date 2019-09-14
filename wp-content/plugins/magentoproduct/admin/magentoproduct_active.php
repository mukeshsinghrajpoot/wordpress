<?php 
/*load js */
function add_custom_magentocss() 
{
wp_enqueue_style( 'custom1', plugins_url( '/bootstrap/css/custom1.css', __FILE__ ) );
}
add_action('admin_print_styles', 'add_custom_magentocss');

function magento_ajax_load_scripts() {
wp_enqueue_script( "magentogeneralsetting", plugin_dir_url( __FILE__ ) . '/bootstrap/js/magentogeneralsetting.js', 'jQuery','1.0.0', true ); 
wp_localize_script( 'magentogeneralsetting', 'magentogeneralsetting_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('admin_enqueue_scripts', 'magento_ajax_load_scripts');
/*closo js*/
add_action('admin_menu', 'my_magento_product_menu');
function my_magento_product_menu(){
      wp_enqueue_style( 'custom1', plugins_url( '/bootstrap/css/custom1.css', __FILE__ ) );
    add_menu_page(
      'magento',  /*Url name show*/
      'magento product',   /*name*/
      'manage_options',  /*manage*/
      'magento-menu',        /*page name*/
      'magento_setting_tab',  /*function name*/
      plugins_url('/img/m.png', __FILE__),6
      );
      add_submenu_page('magento-menu', 'setting load', 'Settings', 'manage_options', 'settingmagento' , 'magento_setting_tab');
}
function magento_setting_tab()
{
      wp_enqueue_style( 'bootstrap333', plugins_url( '/bootstrap/css/bootstrap.min.css', __FILE__ ) );
      wp_enqueue_style( 'custom2', plugins_url( '/bootstrap/css/custom2.css', __FILE__ ) );
      wp_enqueue_script( 'ava-test-js333', plugins_url( '/bootstrap/js/bootstrap.min.js', __FILE__ ));
      wp_enqueue_script( 'ava-test-js333', plugins_url( '/bootstrap/js/jquery.min.js', __FILE__ ));
      global $wpdb;
          $table_name = $wpdb->prefix . 'magentoproduct_authenticat';
          $mylink = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1", ARRAY_A );
          $magento_rest_api_url=$mylink['magento_rest_api_url']; // prints "10"
      echo'
      <div class="wordpayoverviewb">
        <div class="row">
          <div class="col-md-12">
          <h1 class="wordpaytext">Magento Product Api Setting</h1>
          </div>
          </div>
      </div> 
      <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Setting</a></li>
           </ul>
    <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
    </br>
      <form class="form-horizontal" id="Apiform">
      <div id="result"></div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="restapi">Magento REST API URL:</label>
      <div class="col-sm-6">';
      if($magento_rest_api_url)
      {
      echo '<input type="text" class="form-control" id="restapi1" value="'.$magento_rest_api_url.'" 
      name="restapi">
        <span>Do not forget to put the trailing slash. Ex: http://yourmagentostore.com/</span>';
      }else
      {
        echo '<input type="text" class="form-control" id="restapi" placeholder="Enter Your Store Url" name="restapi">
        <span>Do not forget to put the trailing slash. Ex: http://yourmagentostore.com/</span>';    
      }
        
      echo'</div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-primary btnmargin">Submit</button>
      </div>
    </div>
  </form>
    </div>
  </div>
';
}
/*function magento_tab1()
{
      echo "<h1>Welcome Admin</h1>";
}*/
include(plugin_dir_path(__FILE__) . 'postfieldsku.php');

function magento_api_key_responce()
{    
$data=$_POST['data'];
$test=explode('=', $data);
$magento_rest_api_url=urldecode($test[1]);
if (filter_var($magento_rest_api_url, FILTER_VALIDATE_URL))
{
   global $wpdb;
   $blogtime = current_time( 'mysql' );
   $table_name1 = $wpdb->prefix . 'magentoproduct_authenticat';
    $data = array(
            'magento_rest_api_url'   => $magento_rest_api_url,
            'last_update' => $blogtime,  
);
$mylink = $wpdb->get_row( "SELECT * FROM $table_name1 WHERE id = 1", ARRAY_A );
$id=$mylink['id']; // prints "10"
if($id==1)
{
  $result = $wpdb->update
  ($wpdb->prefix .'magentoproduct_authenticat', 
    array( 
    'magento_rest_api_url' => $magento_rest_api_url,
    'last_update' => $blogtime
    ), 
    array("id" => $id) 
  );
  if($result==1)
  {
    echo "<div class='alert alert-success alert-dismissible'>
  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Update!</strong> Your data successfully.
  </div>";
  }
}
else{
  $insert = $wpdb->insert($table_name1, $data);
 if( $insert==1) {
 echo "<div class='alert alert-info alert-dismissible'>
  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Insert!</strong> Your data successfully.
  </div>";
      } 
 } 
}else
{
echo "<div class='alert alert-danger alert-dismissible'>
  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Your rest!</strong>  api not valide.
  </div>";
} 
wp_die();
}
add_action('wp_ajax_magento_api_key_responce', 'magento_api_key_responce');
add_action('wp_ajax_nopriv_magento_api_key_responce', 'magento_api_key_responce');