<?php 
add_filter( 'the_content', 'magentoproductpost_frontend_post' );
function magentoproductpost_frontend_post( $content ) {
    global $post;
    $postid = get_the_ID();
    $sku=get_post_meta($post->ID, 'magento_sku', true); 
    $ad_code = '<form id="formoid" method="post">
            <div>
                <input type="hidden" id="sku2" name="name2"  value='.$sku.'>
           </div>
       </form>
       <div id="products11"></div>';
 
    if ( is_single() && ! is_admin() ) {
      wp_enqueue_style( 'bootstrap4.min',plugins_url( '/bootstrap/css/bootstrap4.min.css', __FILE__ ) );
      wp_enqueue_style( 'styles',plugins_url( '/bootstrap/css/custom1.css', __FILE__ ) );
      wp_enqueue_script( "magentoproductcurl", plugin_dir_url( __FILE__ ) . '/bootstrap/js/magentoproductcurl.js', 'jQuery','1.0.0', true );
      wp_localize_script( 'magentoproductcurl', 'magentoproductcurl_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        return prefix_insert_after_paragraph_magentoproductpost( $ad_code, 2, $content );
    }
     
    return $content;
}
  
// Parent Function that makes the magic happen
  
function prefix_insert_after_paragraph_magentoproductpost( $insertion, $paragraph_id, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
 
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
 
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
     
    return implode( '', $paragraphs );
}
