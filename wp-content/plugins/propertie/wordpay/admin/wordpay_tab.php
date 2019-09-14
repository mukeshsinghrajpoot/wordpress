<?php
error_reporting(0);
/**
 * Register meta boxes.
 */
function wordpay_register_meta_boxes() {
add_meta_box( 'wordpay-1', __( 'Wordpay Options', 'wordpay' ), 'wordpay_display', 'post' );
}
add_action( 'add_meta_boxes', 'wordpay_register_meta_boxes' );
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function wordpay_display( $post ) {
wp_enqueue_style( 'bootstrap', plugins_url( '/bootstrap/css/bootstrap.min.css', __FILE__ ) );
wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/bootstrap.min.js', __FILE__ ));
wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/jquery.min.js', __FILE__ ));
wp_enqueue_script( 'ava-test-js', plugins_url( '/bootstrap/js/popper.min.js', __FILE__ ));
wp_enqueue_script( "postid", plugin_dir_url( __FILE__ ) . '/bootstrap/js/postid.js', 'jQuery','1.0.0', true );
wp_localize_script( 'postid', 'post_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
wp_localize_script( 'postid', 'postid12_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
wp_enqueue_script( "variable1", plugin_dir_url( __FILE__ ) . '/bootstrap/js/variable.js', 'jQuery','1.0.0', true );
  global $post;
  $custom = get_post_custom($post->ID);
  $wordpayonoff = (isset($custom["wordpayonoff"][0])) ? $custom["wordpayonoff"][0]:'';
  $wordpay_words = (isset($custom["wordpay_words"][0])) ? $custom["wordpay_words"][0]:'';
  $minprice = (isset($custom["minprice"][0])) ? $custom["minprice"][0]:'';
  $maxprice = (isset($custom["maxprice"][0])) ? $custom["maxprice"][0]:'';
  $fixedprice = (isset($custom["fixedprice"][0])) ? $custom["fixedprice"][0]:'';
  $priceid = (isset($custom["priceid"][0])) ? $custom["priceid"][0]:'';
?>
<br>
<div class="row">
        <div class="col-md-3">
            <h6>Wordpay</h6>
        </div>
        <div class="col-md-3">
            <div class="btn-group" id="status" data-toggle="buttons">
              <label class="btn btn-default btn-on  <?php if($wordpayonoff=='1'){echo 'active';} ?>">
              <input type="radio" value="1" name="wordpayonoff" checked="<?php if($wordpayonoff=='1'){echo 'checked';} ?>">ON</label>
              <label class="btn btn-default btn-off <?php if($wordpayonoff!='1'){echo 'active';} ?>">
              <input type="radio" value="0" name="wordpayonoff">OFF</label>
            </div>
        </div>
    </div>
    <hr>  
    <div class="row">
        <div class="col-md-3">
            <h6>Pricing</h6>
        </div>
        <div class="col-md-3">
            <?php global $post; 
               $query = new WP_Query(array(
                /* 'p'         => 42,*/
               'post_type' => 'price-range',
                'post_status' => 'publish',
                'orderby'=>'title','order'=>'ASC'
                ));
              ?>  
            <select name="priceid" id="custom_element_grid_class" class="form-control form-control-sm">
              <option value="" selected>Select Price</option>
              <?php 
              while ($query->have_posts()) {
                $query->the_post();
                $postid = get_the_ID();
                /*$post_id= $post_id;*/
                $minprice1=  get_post_meta($post->ID, 'minprice', true);
                $maxprice1=  get_post_meta($post->ID, 'maxprice', true);
                $fixedprice1 = get_post_meta($post->ID, 'cashprice', true);
              ?>
              <option value="<?php echo $postid; ?>"<?php selected( $priceid, $postid ); ?> ><?php echo the_title(); ?>(<?php echo $minprice1; ?>-<?php echo $maxprice1; ?>)</option>
            <?php } ?>
            </select>
        </div>
    </div>
    <!-- response jquery -->
     <hr>
    <div class="row">
        <div class="col-md-3">
            <input class="form-control" id="minprice" type="hidden"name="minprice"
            value="<?php echo $minprice;?>" readonly>
        </div>
    </div> 
    <!--  <hr> -->
    <div class="row">
        <div class="col-md-3">
            <input class="form-control" id="maxprice" type="hidden"name="maxprice"
            value="<?php echo $maxprice;?>" readonly>
        </div>
    </div> 
     <!-- <hr> -->
    <div class="row">
        <div class="col-md-3">
            <h6>Fixed Price  (excl. VAT)</h6>
        </div>
        <div class="col-md-3">
            <input class="form-control" id="fixedpricenew" type="text"name="fixedprice"
            value="<?php echo $fixedprice;?>" readonly>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <h6>Fixed Price  (incl. VAT) help!</h6>
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'wordpay_authenticat';
        $table_name_wordpay = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = 1", ARRAY_A );
        $cpid=$table_name_wordpay['cpd_id'];
        $production=$table_name_wordpay['production'];
        ?>
        <input type="hidden" name="cpid" id="cpid" value="<?php echo $cpid;  ?>">
        <input type="hidden" name="wpmode12" id="wpmode12" value="<?php echo $production;  ?>">
        <div class="col-md-3">
            <select class="form-control" id="exampleFormControlSelect1">
              <option>select country</option>
		    </select>
        </div>
        <div class="col-md-3">
            <input class="form-control" id="fixedpricenewibclval" type="text"name="val"
            value="<?php echo '0';?>" readonly>
        </div>
    </div>  
    <!-- close response jquery --> 
    <hr> 
    <div class="row">
        <div class="col-md-3">
            <h6>Words Before Wordpay</h6>
        </div>
        <div class="col-md-3">
            <input class="form-control" id="wordpay_words" type="number"  min="1" name="wordpay_words"
            value="<?php echo $wordpay_words; ?>" placeholder="Default 30 words Show">
        </div>
    </div>
<?php
}
add_action('save_post', 'save_post_details');
function save_post_details(){

  global $post;

  update_post_meta($post->ID, "wordpayonoff", $_POST["wordpayonoff"]);
  update_post_meta($post->ID, "minprice", $_POST["minprice"]);
  update_post_meta($post->ID, "maxprice", $_POST["maxprice"]);
  update_post_meta($post->ID, "fixedprice", $_POST["fixedprice"]);
  update_post_meta($post->ID, "priceid", $_POST["priceid"]);
  update_post_meta($post->ID, "wordpay_words", $_POST["wordpay_words"]);
}

/*----------------------------------------------------------------------------------*/   
   function post_ajax_process_request() {
   if ( isset( $_POST["postid"] ) ) {
    // now set our response var equal to that of the POST var (this will need to be sanitized based on what you're doing with with it)
    $postid12 = $_POST["postid"];
    global $post; 
               $query = new WP_Query(array(
                 'p'         => $postid12,
               'post_type' => 'price-range',
                'post_status' => 'publish'
                ));
    while ($query->have_posts()) {
                $query->the_post();
                $postid = get_the_ID();
    $minprice12=  get_post_meta($post->ID, 'minprice', true);
    $maxprice12=  get_post_meta($post->ID, 'maxprice', true);
    $fixedprice12 = get_post_meta($post->ID, 'cashprice', true);
    }
    $data = array('minprice13' => $minprice12,'maxprice13' => $maxprice12,'fixedprice13' => $fixedprice12,
      'postid' => $postid);
    $postJSON = json_encode($data);
    echo $postJSON;
    wp_die();
  }
}
add_action('wp_ajax_post_ajax_process_request', 'post_ajax_process_request');
add_action('wp_ajax_nopriv_post_ajax_process_request', 'post_ajax_process_request');

/*postid send curl data*/
function postid_curl_responce()
{
$cpdid=$_POST['cpdid'];
$wpmode=$_POST['wpmode'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'country/wordpress' );
curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, array( 'cpd_id' => $cpdid,'wpmode' => $wpmode) );
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_postid_curl_responce', 'postid_curl_responce');
add_action('wp_ajax_nopriv_postid_curl_responce', 'postid_curl_responce');


