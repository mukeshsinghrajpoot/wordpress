<?php
error_reporting(0);
add_action( 'admin_print_scripts-post-new.php', 'wordpay_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'wordpay_admin_script', 11 );
function wordpay_admin_script() 
{
    global $post_type;
    if( 'price-range' == $post_type )
    wp_enqueue_script( "princerange", plugin_dir_url( __FILE__ ) . '/bootstrap/js/princerange.js', 'jQuery','1.0.0', true );
}
function add_custom_stylesheet() 
{
wp_enqueue_style( 'custom1', plugins_url( '/bootstrap/css/custom1.css', __FILE__ ) );
}
add_action('admin_print_styles', 'add_custom_stylesheet');

function test_ajax_load_scripts() {
// load our jquery file that sends the $.post request
wp_enqueue_script( "variable12", plugin_dir_url( __FILE__ ) . '/bootstrap/js/variable.js', 'jQuery','1.0.0', true );
wp_enqueue_script( "ajax-script", plugin_dir_url( __FILE__ ) . '/bootstrap/js/ajax-test.js', 'jQuery','1.0.0', true );
// make the ajaxurl var available to the above script
wp_localize_script( 'ajax-script', 'js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
wp_localize_script( 'ajax-script', 'ajax_script_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
wp_enqueue_script( "wordpaygeneralsetting", plugin_dir_url( __FILE__ ) . '/bootstrap/js/wordpaygeneralsetting.js', 'jQuery','1.0.0', true ); 
wp_localize_script( 'wordpaygeneralsetting', 'wordpaygeneralsetiong_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('admin_enqueue_scripts', 'test_ajax_load_scripts');

add_action('admin_menu', 'my_menu_wordpay');
function my_menu_wordpay(){
    add_menu_page(
      'Wordpay',  /*Url name show*/
      'Wordpay',   /*name*/
      'manage_options',  /*manage*/
      'wordpay-menu',        /*page name*/
      'wordpay_tab1',  /*function name*/
      plugins_url('/img/wordpay.png', __FILE__),6
      );
      add_submenu_page('wordpay-menu', 'Reports view', 'Reports', 'manage_options', 'wordpay-menu' );
      add_submenu_page('wordpay-menu', 'setting load', 'Settings', 'manage_options', 'setting' , 'wordpay_tab');
      add_submenu_page( 'wordpay-menu', 'price range', 'Price Range','manage_options', 'edit.php?post_type=price-range');
}
function wordpay_tab()
{
    wp_enqueue_style( 'bootstrap', plugins_url( '/bootstrap/css/bootstrap.min.css', __FILE__ ) );
    wp_enqueue_style( 'custom2', plugins_url( '/bootstrap/css/custom2.css', __FILE__ ) );
    wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/bootstrap.min.js', __FILE__ ));
    wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/jquery.min.js', __FILE__ ));
    wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/popper.min.js', __FILE__ ));
    global $wpdb;
    $table_name = $wpdb->prefix . 'wordpay_authenticat';
    $mylink = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1", ARRAY_A );
    $id=$mylink['id']; // prints "10"
    $production=$mylink['production'];
    $apikey=$mylink['apikey'];
    $secretkey=$mylink['secretkey'];
    $domain=$mylink['domain'];
    $selected=$mylink['selected']; ?>
<div class="wordpayoverviewb">
  <div class="row">
    <div class="col-md-12">
    <h1 class="wordpaytext">Wordpay</h1>
    </div>
    </div>
</div> 
  <div class="mt-3" >
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">General</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <br>
  <div id="result"></div>
  <div class="tab-content">
    <div id="home" class="container tab-pane active"><br>  
  <div class="row">
        <div class="col-md-3">
            <h6 class="wordpayh6">Production (Live)</h6>
        </div>
        <div class="col-md-3">
          <form id="myForm45">
            <div class="btn-group" id="status" data-toggle="buttons">
              <label class="btn btn-default btn-on <?php if($production=='1'){echo 'active';} ?>">
              <input  type="radio" value="1" class="radioBtnClass" name="production"  >ON</label>
              <label class="btn btn-default btn-off <?php if($production!='1'){echo 'active';} ?>">
              <input type="radio" value="0" class="radioBtnClass" checked="checked" name="production" >OFF</label>
            </div>
          </form>
        </div>
    </div>
    <br>
    <form action="#" method="post" id="post-form"> 
    <div class="row">
        <div class="col-md-3">
            <h6 class="wordpayh6">Wordpay Authentication</h6>
        </div>
        <div class="col-md-5">
          <?php
          $domain1=site_url();
            if($secretkey!="" && $apikey!="" && $domain1==$domain){
          ?>
          <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="insert your key here" id="key" name="key" value="<?php echo $apikey; ?>" readonly>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="insert your secret key here" id="secret-key" name="secret_key" value="<?php echo $secretkey; ?>" readonly>
              <input class="form-control" type="hidden" value="<?php echo site_url(); ?>" id="domain" name="domain"/>
              <input class="form-control" type="hidden" value="<?php echo $production; ?>" id="production" name="wpmode"/>
            </div>
        <?php }else {?>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="insert your key here" id="key" name="key" value="<?php //echo $apikey; ?>" required>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="insert your secret key here" id="secret-key" name="secret_key" value="<?php //echo $secretkey; ?>" required>
              <input class="form-control" type="hidden" value="<?php echo site_url(); ?>" id="domain" name="domain"/>
              <input class="form-control" type="hidden" value="<?php echo $production; ?>" id="production" name="wpmode"/>
            </div>
            <?php }?>
        </div>
        <div class="col-md-4 authenticat">
        <button type="submit" name="submit" class="btn btn-primary btnmargin">Authenticat with you wordpay account</button>
        </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <h6>Insert your api key from Wordpay and click authenticate.<a href="#" target="_blank"><u>Find your API Key here</u></a></h6>
        </div>
    </div> 
  </form> 
</div>
</div>
<hr>
<br>
<div class="row">
  <div class="col-sm-3">
    <h6 class="wordpayh6">Payment Options</h6>
  </div>
  <div class="col-sm-3">
    <select class="form-control" name="selected" id="exampleFormControlSelect1">
      <option value="Coins"<?php selected( $selected, Coins ); ?>>Coins</option>
    </select>
  </div> 
</div>
</div>
<?php
}
 function text_ajax_process_request() {
  global $wpdb;
   $blogtime = current_time( 'mysql' );
   $table_name1 = $wpdb->prefix . 'wordpay_authenticat';
   $test=$_POST['test'];
   $userdetalis=$_POST['userdetalis'];
   $cpd_id=$userdetalis['cpd_id'];
   $company_id=$userdetalis['company_id'];
   $name=$userdetalis['name'];
   $domain=$userdetalis['domain'];
    parse_str($test);
    $data = array(
            'cpd_id'      => $cpd_id,
            'company_id'  => $company_id,
            'uname'       => $name,
            'apikey'      => $key,
            'secretkey'   => $secret_key,
            'domain'      => $domain,
            'last_update' => $blogtime,  
);
$mylink = $wpdb->get_row( "SELECT * FROM $table_name1 WHERE id = 1", ARRAY_A );
$id=$mylink['id']; // prints "10"
if($id==1)
{
  $result = $wpdb->update
  ($wpdb->prefix .'wordpay_authenticat', 
    array( 
    'cpd_id'      => $cpd_id,
    'company_id'  => $company_id,
    'uname'       => $name,
    'apikey' => $key,
    'secretkey' => $secret_key,
    'domain'      => $domain,
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
wp_die();
}
add_action('wp_ajax_text_ajax_process_request', 'text_ajax_process_request');
add_action('wp_ajax_nopriv_text_ajax_process_request', 'text_ajax_process_request');
/*wordpaygeneralsetiong*/
function wordpaygeneralsetiong_ajax_process_request() {
  global $wpdb;
   $blogtime = current_time( 'mysql' );
   $table_name1 = $wpdb->prefix . 'wordpay_authenticat';
   $production1=$_POST['production1'];
   $production=$production1['production'];
   $selected=$production1['selected'];
    $data = array(
            'production'  => $production,
            'selected'    => $selected,
            'last_update' => $blogtime,  
);
$mylink = $wpdb->get_row( "SELECT * FROM $table_name1 WHERE id = 1", ARRAY_A );
$id=$mylink['id']; // prints "10"
if($id==1)
{
  $result = $wpdb->update
  ($wpdb->prefix .'wordpay_authenticat', 
    array( 
    'production' => $production,
    'selected' => $selected,
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
wp_die();
}
add_action('wp_ajax_wordpaygeneralsetiong_ajax_process_request', 'wordpaygeneralsetiong_ajax_process_request');
add_action('wp_ajax_nopriv_wordpaygeneralsetiong_ajax_process_request', 'wordpaygeneralsetiong_ajax_process_request');
/*close general seting*/
    global $wpdb;
    $table_name = $wpdb->prefix . 'wordpay_authenticat';
    $mylink = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1", ARRAY_A );
    $apikey=$mylink['apikey'];
    $secretkey=$mylink['secretkey'];
    $domain=$mylink['domain'];
    $domain1=site_url();
    if($secretkey!="" && $apikey!="" && $domain1==$domain){
    include(plugin_dir_path(__FILE__) . 'wordpay_tab.php');
    include(plugin_dir_path(__FILE__) . 'price-range/price_range.php');
    }

/*reports code*/
function wordpay_tab1()
{
    wp_enqueue_style( 'bootstrap', plugins_url( '/bootstrap/css/bootstrap.min.css', __FILE__ ) );
    wp_enqueue_style( 'custom2', plugins_url( '/bootstrap/css/custom2.css', __FILE__ ) );
    wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/bootstrap.min.js', __FILE__ ));
    wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/jquery.min.js', __FILE__ ));
    wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/popper.min.js', __FILE__ ));
    wp_enqueue_script( "revenue", plugin_dir_url( __FILE__ ) . '/bootstrap/js/revenue.js', 'jQuery','1.0.0', true);
    wp_localize_script( 'revenue', 'revenue_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'wordpay_authenticat';
    $table_name_wordpay = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1", ARRAY_A );
    $company_id12=$table_name_wordpay['company_id'];
    $production=$table_name_wordpay['production'];
?>
<input type="hidden" name="cpt_id" id="cpd_id" value="<?php echo $company_id12;  ?>">
<input type="hidden" name="wpmode" id="wpmode1" value="<?php echo $production;  ?>">
<!-- revanue start  -->
<div class="container-fluid wordpayoverviewb">
  <div class="row">
    <div class="col-md-12">
    <h1 class="wordpaytext">Wordpay</h1>
    </div>
    </div>
</div> 
 <div class=" mt-3">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#overview">Overview</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="overview" class="container tab-pane active"><br>
      <h3 class="revfont">Revenue per content  <img class="img_right" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'admin/img/icon2.png'; ?>">
      <img class="img_right1" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'admin/img/icon.png'; ?>"></h3>
  
  <div class="row">
  <div class="col-md-12 table-responsive">
 <table class="table">
  <div id="result"></div>
    <thead>
      <tr class="fontpublic" id="fontpublic">
        <td><input type="checkbox" value=""></td>
        <td>Published Date</td>
        <td>Content title</td>
        <td>Viewers</td>
        <td>Purchages</td>
        <td>Conversion</td>
        <td>Low Price</td>
        <td>Max Price</td>
        <td>Avg. Price</td>
        <td>Revenue</td>
      </tr>
    </thead>
    <tbody class="fonttoday" id="myTable">
    </tbody>
  </table>
</div>
<div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
      </div>
</div>
    </div>
  </div>
</div>
<?php 
}
/*reports close*/
function revenue_responce()
{ 
$company_id123=$_POST['cpdid'];
$wpmode=$_POST['wpmode'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'wordpress/revenue' );
curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, array( 'company_id' => $company_id123,'wpmode' => $wpmode) );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_revenue_responce', 'revenue_responce');
add_action('wp_ajax_nopriv_revenue_responce', 'revenue_responce');

function wordpay_api_key_responce()
{
$data=$_POST['data'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'apikey/validate' );
curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data);
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_wordpay_api_key_responce', 'wordpay_api_key_responce');
add_action('wp_ajax_nopriv_wordpay_api_key_responce', 'wordpay_api_key_responce');

