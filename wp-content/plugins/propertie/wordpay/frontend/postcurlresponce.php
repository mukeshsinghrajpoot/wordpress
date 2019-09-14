<?php
/*postid send curl data*/
function login_curl_responce()
{
$data=$_POST['data'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'login' );
curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data);
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_login_curl_responce', 'login_curl_responce');
add_action('wp_ajax_nopriv_login_curl_responce', 'login_curl_responce');

/*getcoin send curl url*/
function getcoin_curl_responce()
{
$token=$_POST['token'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'user/coins');
$header = array(
    'Accept: application/json',
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Bearer '. $token
);
// pass header variable in curl method
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_getcoin_curl_responce', 'getcoin_curl_responce');
add_action('wp_ajax_nopriv_getcoin_curl_responce', 'getcoin_curl_responce');

/*get article curl url*/
function articles_curl_responce()
{
$token1=$_POST['token1'];
$data_articles=$_POST['data_articles'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'articles');
$header = array(
    'Accept: */*',
    'Authorization: Bearer '. $token1
);
// pass header variable in curl method
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data_articles);
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_articles_curl_responce', 'articles_curl_responce');
add_action('wp_ajax_nopriv_articles_curl_responce', 'articles_curl_responce');

/*get data signup url*/
function signup_curl_responce()
{
$data=$_POST['data'];
global $apiurl;
$rurl=$apiurl;
$curl = curl_init( $rurl.'register');
curl_setopt( $curl, CURLOPT_POST, true );
curl_setopt( $curl, CURLOPT_POSTFIELDS, $data);
curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
echo $response = curl_exec( $curl );
curl_close( $curl );
wp_die();
}
add_action('wp_ajax_signup_curl_responce', 'signup_curl_responce');
add_action('wp_ajax_nopriv_signup_curl_responce', 'signup_curl_responce');

/*post responce url*/
function post_curl_responce()
{
if ( isset( $_POST["post_id1"] ) ) {
    $postid12 = $_POST["post_id1"];
    global $post;
    echo do_shortcode(get_post_field('post_content', $postid12));
  }
wp_die();
}
add_action('wp_ajax_post_curl_responce', 'post_curl_responce');
add_action('wp_ajax_nopriv_post_curl_responce', 'post_curl_responce');