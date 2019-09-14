<?php 
error_reporting(0);
/* Custom Post Type Start */
add_action('init', 'wordpay_pricerange_register');
function wordpay_pricerange_register() {
	$labels = array(
		'name' => _x('Groups & Pricing Ranges', 'post type general name'),
		'singular_name' => _x('Price range', 'post type singular name'),
		'add_new' => _x('Add New', 'Price range'),
		'add_new_item' => __('Add New Price range'),
		'edit_item' => __('Edit Price range'),
		'new_item' => __('New Price range'),
		'view_item' => __('View Price range'),
		'search_items' => __('Search Price range'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		/*'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',*/
		'rewrite' => true,
        'has_archive' =>  false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title'/*,'editor','thumbnail'*/)
	  ); 

	register_post_type( 'price-range' , $args );
}
/*-------------------------------------------custom field add-----------------------------------*/
add_action("admin_init", "admin_init");

function admin_init(){
  add_meta_box("credits_meta", "Groups & Pricing Ranges", "credits_meta", "price-range", "normal", "low");
}

function credits_meta() {
wp_enqueue_style( 'bootstrap', plugins_url( '../bootstrap/css/bootstrap.min.css', __FILE__ ) );
wp_enqueue_script( 'ava-test-js', plugins_url( '../bootstrap/js/bootstrap.min.js', __FILE__ ));
wp_enqueue_script( 'ava-test-js', plugins_url( '../bootstrap/js/jquery.min.js', __FILE__ ));
wp_enqueue_script( 'ava-test-js', plugins_url( '../bootstrap/js/popper.min.js', __FILE__ ));
  global $post;
  $custom = get_post_custom($post->ID);
  $minprice = (isset($custom["minprice"][0])) ? $custom["minprice"][0]:'';
  $maxprice = (isset($custom["maxprice"][0])) ? $custom["maxprice"][0]:'';
  $cashprice = (isset($custom["cashprice"][0])) ? $custom["cashprice"][0]:'';
  ?>
  <style type="text/css">
    div#titlewrap label#title-prompt-text {
    padding: 2px 10px !important;
}
  </style>
  <div class="row">
      <div class="col-md-4">
      	<h6>Min Price (coins)</h6>
        </div>
        <div class="col-md-8">
           <input type="number" step="0.01" min="0"  max="999999" class="form-control" id="minprice" name="minprice" value="<?php echo $minprice; ?>" placeholder="0.09" required>
           <span class="error-validation" id="min_error"></span>
        </div>
    </div>
    <br> 
    <div class="row">
      <div class="col-md-4">
      	<h6>Max Price (coins)</h6>
        </div>
        <div class="col-md-8">
          <input type="number" placeholder="4.99" step="0.01" min="0"  max="999999" class="form-control" id="maxprice" name="maxprice" value="<?php echo $maxprice; ?>" required>
          <span class="error-validation" id="max_error"></span>
        </div>
    </div>
    <br>  
    <div class="row">
      <div class="col-md-4">
      	<h6>Fixed Price (coins)</h6>
        </div>
        <div class="col-md-8">
           <input type="number" placeholder="0.79" step="0.01"  min="0" max="999999" class="form-control" id="cashprice" name="cashprice" value="<?php echo $cashprice; ?>" required>
           <span class="error-validation" id="fixed_error"></span>
        </div>
    </div>  
    <br> 	
  <?php
}
/*-----------------------------------Close code custom field---------------------------------*/

/*save code*/
add_action('save_post', 'save_details');
function save_details(){

  global $post;
  update_post_meta($post->ID, "minprice", $_POST["minprice"]);
  update_post_meta($post->ID, "maxprice", $_POST["maxprice"]);
  update_post_meta($post->ID, "cashprice", $_POST["cashprice"]);
}
/*close save code*/

/*view code*/
add_action("manage_posts_custom_column",  "portfolio_custom_columns");
add_filter("manage_edit-price-range_columns", "portfolio_edit_columns");

function portfolio_edit_columns($columns){
  $columns = array(
    "cb" => "<input type='checkbox' />",
    "title" =>    "Title",
    "minprice" => "Min Price (coins)",
    "maxprice" => "Max Price (coins)",
    "cashprice" => "Fixed Price (coins)",
    "date"  =>      "Date",
  );

  return $columns;
}
function portfolio_custom_columns($column){
  global $post;

  switch ($column) {
    case "minprice":
      $custom = get_post_custom();
      echo $custom["minprice"][0];
      break;
    case "maxprice":
      $custom = get_post_custom();
      echo $custom["maxprice"][0];
      break;
    case "cashprice":
      $custom = get_post_custom();
      echo $custom["cashprice"][0];
      break;
  }
}
/*close view code*/

/*menu hide*/
function wpse28782_remove_menu_items() {
   
        remove_menu_page( 'edit.php?post_type=price-range' );
  
}
add_action( 'admin_menu', 'wpse28782_remove_menu_items' );
/*menu hide code close*/