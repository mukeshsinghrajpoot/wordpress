<?php

/*
Plugin Name: Jamatto Micropayments
Description: Used by thousands of bloggers around the world, accept micropayments with a single click for your premium content or for donations on your blog.
Version:     1.7
Author:      Jamatto Ltd.
Author URI:        https://jamatto.com/
License:     GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.txt
*/

defined( 'ABSPATH' ) or die( 'This Jamatto plug-in can not be run independently...' );

/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
/* --- INSTALL ---------------------------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

register_activation_hook( __FILE__, 'JAMATTO_DONATIONS_activate' );

function JAMATTO_DONATIONS_activate() {

  if (!get_option("FIELD_bid")) { update_option( "FIELD_bid", "Wordpress" ); }
  if (!get_option("FIELD_ccy")) { update_option( "FIELD_ccy", "USD" ); }
  if (!get_option("FIELD_autodonate")) { update_option( "FIELD_autodonate", "FIELD_autodonate__always" ); }
  if (!get_option("FIELD_premium_amount")) { update_option( "FIELD_premium_amount", "0.10" ); }
  if (!get_option("FIELD_premium_caption")) { update_option( "FIELD_premium_caption", "Pay" ); }
  if (!get_option("FIELD_premium_prompt")) { update_option( "FIELD_premium_prompt", "Read on for just" ); }
  if (!get_option("FIELD_premium_color_background")) { update_option( "FIELD_premium_color_background", "rgba(250,250,250,0.98)" ); }
  if (!get_option("FIELD_premium_color_edge")) { update_option( "FIELD_premium_color_edge", "#2070f0" ); }
  if (!get_option("FIELD_premium_sticky_purchase")) { update_option( "FIELD_premium_sticky_purchase", "" ); }  
  if (!get_option("FIELD_premium_category_amount")) { update_option( "FIELD_premium_category_amount", "" ); }
  if (!get_option("FIELD_premium_role_exempt")) { update_option( "FIELD_premium_role_exempt", "" ); }
  if (!get_option("FIELD_donation_amount")) { update_option( "FIELD_donation_amount", "0.20" ); }
  if (!get_option("FIELD_donation_caption")) { update_option( "FIELD_donation_caption", "Donate" ); }
  if (!get_option("FIELD_donation_prompt")) { update_option( "FIELD_donation_prompt", "Support my blog with" ); }
  if (!get_option("FIELD_donation_thanks")) { update_option( "FIELD_donation_thanks", "Thanks for your support!" ); }

}

/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
/* --- CONTENT ---------------------------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

function JAMATTO_load_scripts() {
  wp_enqueue_script( 'jamatto', '//cdn.jamatto.com/api/js/jamatto.min.js', array(), null, true );
}

add_action( 'wp_enqueue_scripts', 'JAMATTO_load_scripts' );

add_filter('the_content', 'JAMATTO_process_default_donate');

function JAMATTO_process_default_donate($content) {

  // Don't show the default buttons when there are multiple articles...
  if (!is_singular()) return $content;

  // Should we be displaying the default buttons?
  if ("FIELD_autodonate__never" == get_option("FIELD_autodonate")) return $content;
  if ("FIELD_autodonate__unique" == get_option("FIELD_autodonate") && strpos($content, '[jamatto')) return $content;

  $bid = esc_attr(get_option("FIELD_bid"));
  $ccy = esc_attr(get_option("FIELD_ccy"));
  $caption = esc_attr(get_option("FIELD_donation_caption"));
  $prompt = esc_attr(get_option("FIELD_donation_prompt"));
  $thanks = esc_attr(get_option("FIELD_donation_thanks"));
  $item = esc_attr(get_permalink());
  $title = esc_attr(get_the_title());

  $buttons_id = "ID" . rand() . "-" . rand();
  $thank_you_id = "ID" . rand() . "-" . rand();
  $content = 
    $content 
    . '<div id="' . $buttons_id . '">' 
    . '<i class="jamatto-purchase" jamatto-bid="' . $bid . '" jamatto-prompt="' . $prompt . '" jamatto-caption="' . $caption . '" jamatto-amount="0.10" jamatto-ccy="' . $ccy . '" jamatto-item="' . $item . '" jamatto-title="' . $title . '" jamatto-description="' . $item . '" jamatto-make-visible-id="' . $thank_you_id . '" jamatto-make-invisible-id="' . $buttons_id . '"></i>'
    . '&nbsp;'
    . '<i class="jamatto-purchase" jamatto-bid="' . $bid . '" jamatto-prompt="' . $prompt . '" jamatto-caption=" " jamatto-amount="0.20" jamatto-ccy="' . $ccy . '" jamatto-item="' . $item . '" jamatto-title="' . $title . '" jamatto-description="' . $item . '" jamatto-make-visible-id="' . $thank_you_id . '" jamatto-make-invisible-id="' . $buttons_id . '"></i>'
    . '&nbsp;'
    . '<i class="jamatto-purchase" jamatto-bid="' . $bid . '" jamatto-prompt="' . $prompt . '" jamatto-caption=" " jamatto-amount="0.50" jamatto-ccy="' . $ccy . '" jamatto-item="' . $item . '" jamatto-title="' . $title . '" jamatto-description="' . $item . '" jamatto-make-visible-id="' . $thank_you_id . '" jamatto-make-invisible-id="' . $buttons_id . '"></i>'
    . '</div>'
    . '<div id="' . $thank_you_id . '" style="display:none;">' 
    . $thanks
    . '</div>'
  ;

	return $content;
}


/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
/* --- SHORTCODE - jamatto-donate ---------------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

function shortcode_jamatto_donate( $atts, $content = null ) {

  $a = shortcode_atts( array(
    'jamatto-bid' => esc_attr(get_option("FIELD_bid")),
    'jamatto-ccy' => esc_attr(get_option("FIELD_ccy")),
    'jamatto-amount' => esc_attr(get_option("FIELD_donation_amount")),
    'jamatto-caption' => esc_attr(get_option("FIELD_donation_caption")),
    'jamatto-prompt' => esc_attr(get_option("FIELD_donation_prompt")),
    'jamatto-thanks' => esc_attr(get_option("FIELD_donation_thanks")),
    'jamatto-item' => esc_attr(get_permalink()),
    'jamatto-title' => esc_attr(get_the_title()),
    'jamatto-description' => esc_attr(get_permalink()),
  ), $atts );

  $thank_you_id = "ID" . rand() . "-" . rand();

  return ''
    . do_shortcode($content)
    . '<div>' 
    . '<i class="jamatto-purchase" '
    . '  jamatto-make-visible-id="' . $thank_you_id . '" '
    . '  jamatto-bid="' . $a['jamatto-bid'] . '" '
    . '  jamatto-prompt="' . $a['jamatto-prompt'] . '" '
    . '  jamatto-caption="' . $a['jamatto-caption'] . '" '
    . '  jamatto-amount="' . $a['jamatto-amount'] . '" '
    . '  jamatto-ccy="' . $a['jamatto-ccy'] . '" '
    . '  jamatto-item="' . $a['jamatto-item'] . '" '
    . '  jamatto-title="' . $a['jamatto-title'] . '" '
    . '  jamatto-description="' . $a['jamatto-description'] . '" '
    . '  jamatto-tags="' . $a['jamatto-tags'] . '" '
    . '></i>'
    . '<span id="' . $thank_you_id . '" style="display:none;">' . $a['jamatto-thanks'] . '</span>'
    . '</div>'
  ;
}

add_shortcode( 'jamatto-donate', 'shortcode_jamatto_donate' );


/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
/* --- SHORTCODE - jamatto-debug ---------------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

function shortcode_jamatto_debug( $atts, $content = null ) {
  
  $user = wp_get_current_user();
  var_dump($user);
  
  return '';
}

add_shortcode( 'jamatto-debug', 'shortcode_jamatto_debug' );

/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
/* --- SHORTCODE - jamatto-premium ---------------------------------------------------------------------------------------------------------------------------------- */
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */

function shortcode_jamatto_premium( $atts, $content = null ) {

  // Check if this is a user in an exempt role
  $FIELD_premium_role_exempt = esc_attr(get_option("FIELD_premium_role_exempt"));
  if (!empty($FIELD_premium_role_exempt)) {
    $FIELD_premium_role_exempt_split = explode(";", $FIELD_premium_role_exempt);
    $user = wp_get_current_user();
    $roles = $user->roles;
    for ($i = 0; $i < count($FIELD_premium_role_exempt_split); ++$i) {
      for ($j = 0; $j < count($roles); ++$j) {
        if ($roles[$j] == $FIELD_premium_role_exempt_split[$i]) {
          return $content;
        }
      }
    }
  }

  // Work out the default pricing for this article
  $default_price = "";
  {
    // First check the categories    
    $FIELD_premium_category_amount = esc_attr(get_option("FIELD_premium_category_amount"));
    if (!empty($FIELD_premium_category_amount)) {
      $categories = get_the_category();
      $FIELD_premium_category_amount_split = explode(";", $FIELD_premium_category_amount);
      for ($i = 0; $i < count($FIELD_premium_category_amount_split); ++$i) {
        $FIELD_premium_category_amount_splits = explode(":", $FIELD_premium_category_amount_split[$i]);
        if (2 == count($FIELD_premium_category_amount_splits)) {
          for ($j = 0; $j < count($categories); ++$j) {
            if ($categories[$j]->name == $FIELD_premium_category_amount_splits[0]) {
              $default_price = $FIELD_premium_category_amount_splits[1];
            }
          }
        }
      }
    } 
    
    // Fall back onto the default
    if (empty($default_price)) {
      $default_price = esc_attr(get_option("FIELD_premium_amount"));
    }
  }

  if (empty($content)) {
    return '<span style="color:red;">You are missing a closing <code>[/jamatto-premium]</code> shortcode. You need to wrap your premium content as follows:<br/><br/><code>[jamatto-premium]</code><br/>Premium lines here...<br/>Premium lines here...<br/>Premium lines here...<br/><code>[/jamatto-premium]</code></span><p/>';
  }
  
  $a = shortcode_atts( array(
    'jamatto-bid' => esc_attr(get_option("FIELD_bid")),
    'jamatto-ccy' => esc_attr(get_option("FIELD_ccy")),
    'jamatto-amount' => $default_price,
    'jamatto-caption' => esc_attr(get_option("FIELD_premium_caption")),
    'jamatto-prompt' => esc_attr(get_option("FIELD_premium_prompt")),
    'jamatto-sticky-purchase' => esc_attr(get_option("FIELD_premium_sticky_purchase")),
    'jamatto-item' => esc_attr(get_permalink()),
    'jamatto-title' => esc_attr(get_the_title()),
    'jamatto-description' => esc_attr(get_permalink()),
  ), $atts );

  $premium_cover_id = "ID" . rand() . "-" . rand();
  $PREAMBLE = ''
    . '<div style="position:relative;">'
    . '<div style="z-index:998;background-color:' . (get_option("FIELD_premium_color_background")) . ';position:absolute;left:0px;width:100%;top:0px;height:100%" id="' . $premium_cover_id . '">'
    .   '<div style="background-color:' . (get_option("FIELD_premium_color_edge")) . ';position:absolute;left:0px;width:5px;top:0px;height:100%" ></div>'
    . '</div>'
    . '<div style="z-index:999;position:absolute;left:10px;top:2px;">'
    . '<i class="jamatto-purchase" '
    . '  jamatto-make-invisible-id="' . $premium_cover_id . '" '
    . '  jamatto-bid="' . $a['jamatto-bid'] . '" '
    . '  jamatto-prompt="' . $a['jamatto-prompt'] . '" '
    . '  jamatto-caption="' . $a['jamatto-caption'] . '" '
    . '  jamatto-amount="' . $a['jamatto-amount'] . '" '
    . '  jamatto-ccy="' . $a['jamatto-ccy'] . '" '
    . '  jamatto-item="' . $a['jamatto-item'] . '" '
    . '  jamatto-title="' . $a['jamatto-title'] . '" '
    . '  jamatto-description="' . $a['jamatto-description'] . '" '
    . '  jamatto-tags="' . $a['jamatto-tags'] . '" '
    . '  jamatto-sticky-purchase="' . $a['jamatto-sticky-purchase'] . '" '
    . '></i>'
    . '</div>'
  ;
  $POSTAMBLE = '</div>';

  if (!$content || "" == $content) {
    $content = '<br/>';
  }
  
  return ''
    . $PREAMBLE
    . do_shortcode($content)
    . $POSTAMBLE
  ;
}

add_shortcode( 'jamatto-premium', 'shortcode_jamatto_premium' );

/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
/* --- ADMIN ------------------------------------------------------------------------------------------------------------------------------------------------ */
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
 
add_action('admin_menu', 'JAMATTO_DONATIONS_config_setup_menu');

function JAMATTO_DONATIONS_config_setup_menu() {
  add_menu_page( 'Jamatto Micropayments', 'Jamatto Micropayments', 'manage_options', 'jamatto_donations_config', 'JAMATTO_DONATIONS_config_init' );
  add_submenu_page( 'options-general.php', 'Jamatto Micropayments', 'Jamatto Micropayments', 'manage_options', 'jamatto_donations_config', 'JAMATTO_DONATIONS_config_init' );
}

function _JAMATTO_DONATIONS_safe_update_option($option_key) {
  if (isset($_POST[$option_key])) {
    $value = $_POST[$option_key];
    if ( strlen( $value ) > 256 ) {
      $value = substr( $value, 0, 256 );
    }

    update_option( $option_key, sanitize_text_field($value) );
  }
}

function JAMATTO_DONATIONS_config_init(){
  if (!current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  
  // Check if this is a post update
  _JAMATTO_DONATIONS_safe_update_option("FIELD_bid");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_ccy");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_autodonate");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_amount");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_caption");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_prompt");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_color_background");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_color_edge");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_sticky_purchase");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_category_amount");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_premium_role_exempt");  
  _JAMATTO_DONATIONS_safe_update_option("FIELD_donation_amount");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_donation_caption");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_donation_prompt");
  _JAMATTO_DONATIONS_safe_update_option("FIELD_donation_thanks");
?>

<div class="wrap">
<h2>Jamatto Micropayments Settings</h2>
<hr/>
For instructions on how to use your Jamatto micropayments plugin, check out the screenshots on the <a href="https://wordpress.org/plugins/jamatto-micropayments/" target="_blank">Jamatto Wordpress plugin page</a>.
<br />
<br />
  
<form method="post" action="">
<table>

<tr>
<td colspan="2">
<h3>Business Settings</h3>
Once you wish to keep track of what you are earning through the <a href="http://jamatto.com/#/Seller" target="_blank">Jamatto Seller's Dashboard</a>, you need to associate your plugin with your Jamatto Business ID.  You can create one as a Seller in your Jamatto account, and paste it in here.
<p/>
</td>
</tr>

<tr>
<td>
Your Jamatto Business ID (BID):
<br/>
<span class="font-size:xx-small;">Get your own <a href="http://jamatto.com/#/Seller" target="_blank">here</a></span>
</td>
<td>
<input type="text" name="FIELD_bid" value="<?php echo esc_attr(get_option("FIELD_bid")); ?>" />
</td>
</tr>

<tr>
<td colspan="2">
<h3>General Settings</h3>
  These settings affect the general behaviour of your Jamatto plugin.
  <p/>
</td>
</tr>  

<tr>
<td valign="top">
Currency:
</td>
<td>
  <input type="radio" name="FIELD_ccy" value="USD" <?php checked( 'USD', get_option( 'FIELD_ccy' ) ); ?>>USD</input>
  <br />
  <input type="radio" name="FIELD_ccy" value="EUR" <?php checked( 'EUR', get_option( 'FIELD_ccy' ) ); ?>>EUR</input>
  <br />
  <input type="radio" name="FIELD_ccy" value="GBP" <?php checked( 'GBP', get_option( 'FIELD_ccy' ) ); ?>>GBP</input>
  <br />
  <input type="radio" name="FIELD_ccy" value="ZAR" <?php checked( 'ZAR', get_option( 'FIELD_ccy' ) ); ?>>ZAR</input>
</td>
</tr>

<tr>
<td valign="top">
Automatically show
<br/>
donations buttons:
</td>
<td>
  <input type="radio" name="FIELD_autodonate" value="FIELD_autodonate__always" <?php checked( 'FIELD_autodonate__always', get_option( 'FIELD_autodonate' ) ); ?>>Always</input>
  <br />
  <input type="radio" name="FIELD_autodonate" value="FIELD_autodonate__never" <?php checked( 'FIELD_autodonate__never', get_option( 'FIELD_autodonate' ) ); ?>>Never</input>
  <br />
  <input type="radio" name="FIELD_autodonate" value="FIELD_autodonate__unique" <?php checked( 'FIELD_autodonate__unique', get_option( 'FIELD_autodonate' ) ); ?>>Only if other Jamatto buttons are not present</input>
</td>
</tr>


<tr>
<td colspan="2">
<h3>Donations Settings</h3>
These settings affect the behaviour of any <code>[jamatto-donate]</code> shortcodes you embed in your blog posts.
<p/>
</td>
</tr>

<tr>
<td>
Amount:
</td>
<td>
<input type="text" name="FIELD_donation_amount" value=""<?php echo esc_attr(get_option("FIELD_donation_amount")); ?>" />
</td>
</tr>

<tr>
<td>
Caption:
</td>
<td>
<input type="text" name="FIELD_donation_caption" value=""<?php echo esc_attr(get_option("FIELD_donation_caption")); ?>" />
</td>
</tr>

<tr>
<td>
Prompt:
</td>
<td>
<input type="text" name="FIELD_donation_prompt" value=""<?php echo esc_attr(get_option("FIELD_donation_prompt")); ?>" />
</td>
</tr>

<tr>
<td>
Thanks:
</td>
<td>
<input type="text" name="FIELD_donation_thanks" value=""<?php echo esc_attr(get_option("FIELD_donation_thanks")); ?>" />
</td>
</tr>

  
<tr>
<td colspan="2">
<h3>Premium Content Settings</h3>
These settings affect the behaviour of any <code>[jamatto-premium]</code> shortcodes you embed in your blog posts.
<p/>
</td>
</tr>
  
<tr>
<td>
Amount:
</td>
<td>
<input type="text" name="FIELD_premium_amount" value=""<?php echo esc_attr(get_option("FIELD_premium_amount")); ?>" />
</td>
</tr>

<tr>
<td>
Caption:
</td>
<td>
<input type="text" name="FIELD_premium_caption" value=""<?php echo esc_attr(get_option("FIELD_premium_caption")); ?>" />
</td>
</tr>

<tr>
<td>
Prompt:
</td>
<td>
<input type="text" name="FIELD_premium_prompt" value="<?php echo esc_attr(get_option("FIELD_premium_prompt")); ?>" />
</td>
</tr>

<tr>
<td>
Background colour (e.g. white, #ffddee, or rgba(255,255,255,0.95):
</td>
<td>
<input type="text" name="FIELD_premium_color_background" value="<?php echo esc_attr(get_option("FIELD_premium_color_background")); ?>" />
</td>
</tr>

<tr>
<td>
Edge colour (e.g. white, #ffddee, or rgba(255,255,255,0.95):
</td>
<td>
<input type="text" name="FIELD_premium_color_edge" value="<?php echo esc_attr(get_option("FIELD_premium_color_edge")); ?>" />
</td>
</tr>

<tr>
<td colspan="2">
<h3>Premium Content Settings (Advanced)</h3>
These settings affect the advanced behaviour of any <code>[jamatto-premium]</code> shortcodes you embed in your blog posts.
<p/>
</td>
</tr>
  
<tr>
<td valign="top">
Are purchases sticky (i.e. kept forever after purchase)?
</td>
<td>
<input type="radio" name="FIELD_premium_sticky_purchase" value=""
<?php checked( '', get_option( 'FIELD_premium_sticky_purchase' ) ); ?>>No
</input>
<input type="radio" name="FIELD_premium_sticky_purchase" value="true"
<?php checked( 'true', get_option( 'FIELD_premium_sticky_purchase' ) ); ?>>Yes
</input>
</td>
</tr>

<tr>
<td>
<br/>
<b>Category Specific Default Amounts:</b>
If you wish to charge different default amounts for each cateogry of article, enter the category names and prices as follows, e.g.:
<code>category1:0.01;category2:0.05;category3:0.10</code>
</td>
<td>
<input type="text" name="FIELD_premium_category_amount" value="<?php echo esc_attr(get_option("FIELD_premium_category_amount")); ?>" />
</td>
</tr>

<tr>
<td>
<br/>
<b>Micropay Exempt Roles:</b>
If you have subscribers assigned to particular roles who should be exempt from having to micropay, enter the role names as follows, e.g.:
<code>role1;role2;role3</code>
</td>
<td>
<input type="text" name="FIELD_premium_role_exempt" value="<?php echo esc_attr(get_option("FIELD_premium_role_exempt")); ?>" />
</td>
</tr>

<tr>
<td colspan="2">
  <br/>
  <br/>
<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
</td>
</tr>



</table>

</form>
</div>

<?php
}
?>