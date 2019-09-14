<?php
/*error_reporting();*/
/**
 * Register meta boxes.
 */
function magentoto_register_meta_boxes() {
add_meta_box( 'magento-1', __( 'Magento Options', 'magento' ), 'magento_display', 'post' );
}
add_action( 'add_meta_boxes', 'magentoto_register_meta_boxes' );
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function magento_display( $post ) {
wp_enqueue_style( 'bootstrap', plugins_url( '/bootstrap/css/bootstrap.min.css', __FILE__ ) );
 global $post;
  $custom = get_post_custom($post->ID);
  $magento_sku1 = (isset($custom["magento_sku"][0])) ? $custom["magento_sku"][0]:'';
?>   
    <div class="row">
      <div class="col-md-3">
            <h6>Magento SKU</h6>
        </div>
        <div class="col-md-9">
            <input class="form-control" id="magento_sku1" type="text"  name="magento_sku"
            value="<?php echo $magento_sku1; ?>" placeholder="enter your sku">
            <span>for example multiple sku "sku1,sku2,sku3" and single sku "sku1"</span>
        </div>
    </div>
<?php
}
add_action('save_post', 'magento_save_post_details');
function magento_save_post_details(){
  global $post;
   update_post_meta($post->ID, "magento_sku", $_POST["magento_sku"]);
}




