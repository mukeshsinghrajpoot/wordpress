<?php 
/*postid send curl data*/
function magento_project_curl_responce()
{
$data=$_POST['data'];
$str = implode(',', $data);
global $magento_rest_api_url;
$rurl=$magento_rest_api_url;
$response = wp_remote_get( $rurl.'/galantes/index/index?sku='.$str);
$api_response = json_decode( wp_remote_retrieve_body( $response ), true );
/*print_r($api_response);*/
echo '<section class="details-card">
    <div class="container">
        <div class="row scroll">';
foreach ($api_response as $key => $value) {
	foreach ($value as $keys) {
		$productname=$keys['name'];
		$producturl=$keys['product_url'];
		$productprice=$keys['price'];
		$productimage=$keys['image'];
        $productcurrency=$keys['currency'];
        echo '<div class="col-sm-4">
                <div class="card-content">
                    <div class="card-img">
                        <a href="'.$producturl.'">
                        <img src="'.$productimage.'" alt="">
                        </a>
                    </div>
                    <div class="card-desc">
                        <h3><a href="'.$producturl.'">'.$productname.'</a></h3>
                        <p>'.$productcurrency.number_format($productprice,2).'</p>
                            <a href="'.$producturl.'" class="btn-card">View product</a>   
                    </div>
                </div>
            </div>';                            
    }
    
}
echo '   </div>
    </div>
</section>';
wp_die();
}
add_action('wp_ajax_magento_project_curl_responce', 'magento_project_curl_responce');
add_action('wp_ajax_nopriv_magento_project_curl_responce', 'magento_project_curl_responce');