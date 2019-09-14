<?php
/*menu code*/
add_action('admin_menu', 'my_menu_pages');
function my_menu_pages(){
   echo '<link type="text/css" href="'. WP_PLUGIN_URL .'/videouploade/admin/bootstrap/css/videocustom.css" rel="stylesheet" />';
    add_menu_page(
      'videouploade',  /*Url name show*/
      'video',   /*name*/
      'manage_options',  /*manage*/
      'videouploade-menu',        /*page name*/
      'videouploade_add',  /*function name*/
      plugins_url('/img/bluethink_icon.ico', __FILE__),8
      );
      add_submenu_page('videouploade-menu', 'video add', 'video add csv', 'manage_options', 'videouploade-menu' );
      add_submenu_page('videouploade-menu', 'video load', 'video view', 'manage_options', 'video_view' , 'video_view');
      add_submenu_page('videouploade-menu', 'video shortcode', 'short code used', 'manage_options', 'short-codes' , 'short_codes');
}
function  videouploade_add()
{
//echo '<link type="text/css" href="'. WP_PLUGIN_URL .'/videouploade/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" />';
wp_enqueue_style( 'stylecustom', plugins_url( '/bootstrap/css/stylecustom.css', __FILE__ ) );
wp_enqueue_style( 'bootstrap', plugins_url( '/bootstrap/css/bootstrap.css', __FILE__ ) );
wp_enqueue_script( 'custom-test-js', plugins_url( '/bootstrap/js/custom.js', __FILE__ ));
wp_enqueue_script( 'custom-test-js', plugins_url( '/bootstrap/js/bootstrap.js', __FILE__ ));
wp_enqueue_script( "customjs-js", plugin_dir_url( __FILE__ ) . '/bootstrap/js/customjs.js', 'jQuery','1.0.0', true );
global $wpdb;
$curenttime = current_time( 'mysql' );
$table_name = $wpdb->prefix . 'video_uploade';
if(isset($_POST['importSubmit'])){
    
    // Allowed mime types
    // $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
   $allowed_filType= array('csv','xml');
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($ext, $allowed_filType)){
        
        if($_FILES['file']['size'] >= 1000000000000000){
         //die('file size error ');
         $result='<div class="alert alert-danger">file size error</div>';
        }else{

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
             $data = [
                  'video_name' => $line[0],
                  'video_description'=> $line[1],
                  'video_url' => $line[2],
                  'video_img_url'=>$line[3],
                  'last_update' => $curenttime,
               ];

            $insert = $wpdb->insert($table_name, $data);
            }
            if($insert){
              $result='<div class="alert alert-success">Thank You!</div>';
            }else
            {
              $result='<div class="alert alert-danger">Sorry there was an error. Please try again later</div>';
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            
        }
      }
}else
{
  $result='<div class="alert alert-danger">Error file type not allowed</div>';
}
}
?>

<!-- Display status message -->
<div class="form-group" id="tgroup">
        <div class="col-sm-10" style="margin-top: 35px;">
            <?php echo $result; ?>    
        </div>
    </div>
<!-- Display status message -->
<div class="row">
    <!-- Import link -->
    <div class="col-md-12 head">
        <div class="float-right">
            <a href="javascript:void(0);" class="btn btn-success mrginbtntab" onclick="formToggle('importFrm');"><i class="plus"></i> Import csv</a>
        </div>
    </div>
    <!-- CSV file upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="file" />
            <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
        </form>
    </div>
</div>

<?php
}

function  video_view(){
   wp_enqueue_style( 'bootstrap-min488', plugins_url( '/bootstrap/css/videolist/css/bootstrap.min.css', __FILE__ ) );
   wp_enqueue_style( 'stylecustom', plugins_url( '/bootstrap/css/jquery.dataTables.min.css', __FILE__ ) );
   wp_enqueue_script( 'jquery-js', plugins_url( '/bootstrap/js/jquery-3.3.1.js', __FILE__ ));
   wp_enqueue_script( 'jquery-dataTables', plugins_url( '/bootstrap/js/jquery.dataTables.min.js
', __FILE__ ));
    wp_enqueue_script( "datatable-js", plugin_dir_url( __FILE__ ) . '/bootstrap/js/datatable.js', 'jQuery','1.0.0', true );
    wp_localize_script( 'datatable-js', 'datatable_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

   echo "</br>";
   echo "<div class='container'>";
   echo '<table id="example" class="display table-responsive" width="100%"></table>';
   echo '</div>';
}

function data_responce()
{
 global $wpdb;
$table_name = $wpdb->prefix . 'video_uploade';  
     
        $test = $_REQUEST['data'];
        // Let's take the data that was sent and do something with it
        if ( $test == 'test' ) {
            
            $result = $wpdb->get_results("SELECT * FROM $table_name");
          $data = [];
         foreach ($result as $key => $value) {

            $data[] = [ $value->video_name, $value->video_description, $value->video_url,$value->video_img_url, $value->last_update ];
           }
          echo json_encode($data); 
         }
wp_die();
}
add_action('wp_ajax_data_responce', 'data_responce');
add_action('wp_ajax_nopriv_data_responce', 'data_responce');

//list page shortcode 
function shortcode_listpage() {
wp_enqueue_style( 'bootstrap-min4', plugins_url( '/bootstrap/css/videolist/css/bootstrap.min.css', __FILE__ ) );
wp_enqueue_style( 'videocustom1', plugins_url( '/bootstrap/css/videolist/css/videocustom.css', __FILE__ ) );
wp_enqueue_script( 'bootstrap-min3-js', plugins_url( '/bootstrap/css/videolist/js/bootstrap.min.js', __FILE__ ));
wp_enqueue_script( 'jquery-min1-js', plugins_url( '/bootstrap/css/videolist/js/jquery.min.js', __FILE__ ));
global $wpdb;
$table_name = $wpdb->prefix . 'video_uploade';
/*$result = $wpdb->get_results("SELECT * FROM $table_name");*/
$items_per_page = 3;
$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
$offset = ( $page * $items_per_page ) - $items_per_page;
$query = 'SELECT * FROM '.$table_name;
$total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
$total = $wpdb->get_var( $total_query );
$results = $wpdb->get_results( $query.' ORDER BY video_id DESC LIMIT '. $offset.', '. $items_per_page, OBJECT );
echo '<section class="details-card">
      <div class="container">
      <div class="row">';
foreach ($results as $resulted) {
	$video_id1=$resulted->video_id;
  $video_id=base64_encode($video_id1);
	$video_name=$resulted->video_name;
  $video_name1=substr($video_name,0,20);
	$video_description=$resulted->video_description;
  $video_description1=substr($video_description,0,35);
	$video_url=$resulted->video_url;
	$video_img_url=$resulted->video_img_url;
  echo '<div class="col-md-4 pad5">
                <div class="card-content">
                    <div class="card-img">
                        <a href="'.home_url().'/detail?test='.$video_id.'"><img src="'.$video_img_url.'" alt=""></a>
                        <span><h4>'.$video_name.'</h4></span>
                    </div>
                    <div class="card-desc">
                        <h3>'.$video_name1.'</h3>
                        <p>'.$video_description1.'</p>
                            <a href="'.home_url().'/detail?test='.$video_id.'" class="btn-card">Read More</a>   
                    </div>
                </div>
            </div>';
}
echo '</div></div></section>';
echo paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_text' => __('&laquo;'),
                        'next_text' => __('&raquo;'),
                        'total' => ceil($total / $items_per_page),
                        'current' => $page
                    ));

}
add_shortcode('List_page', 'shortcode_listpage');

//details page shortcode
function shortcode_detailpage() {
  //return '<p>Hello World!</p>';
 wp_enqueue_style( 'bootstrap-min44', plugins_url( '/bootstrap/css/videolist/css/bootstrap.min.css', __FILE__ ) );	
  $ids=$_GET['test'];
  $videoid=base64_decode($ids);
  global $wpdb;
  $table_name = $wpdb->prefix . "video_uploade";
  $user = $wpdb->get_results( "SELECT * FROM $table_name where video_id=$videoid" );
  foreach ($user as $row){
    $video_name=$row->video_name;
    $video_description=$row->video_description;
    $video_url=$row->video_url;
    $video_img_url=$row->video_img_url;
  }
  echo "<div class='container'>";
   echo '<div class="row">';
  echo  '<h1>'.$video_name.'</h1>';
  echo '</div>';
  echo '<div class="row">';
  //echo '<iframe width="420" height="345" src="https://www.youtube.com/embed/oKStYmMgNRA" frameborder="0" allowfullscreen>
      //  </iframe>';
  echo ' <video width="100%" height="240" controls controlsList="nodownload">
                        <source src="'.$video_url.'" type="video/mp4">
                  </video>';
  echo '</div>';
  echo '<div class="row">';
  echo  '<p>'.$video_description.'</p>';
  echo '</div>';
  echo '</div>';
  comments_template( '/short-comments.php' );
}
add_shortcode('detail_page', 'shortcode_detailpage');

function short_codes()
{
  echo "<h1 style='color:skyblue;'>List page any name but detail page must be detail name </h1>";
	echo "<h1 style='color:red;'>Short code used in page<h1>";
	echo "<h2>List page shortcode used</h2>";
	echo "<h5>[List_page]</h5>";
	echo "<h2>deatil page shortcode used</h2>";
	echo "<h5>[detail_page]</h5>";

	echo "<h1 style='color:red;'>Short code used in template<h1>";
	echo "<h2>List page shortcode used</h2>";
	echo "<h5>do_shortcode('[List_page]')</h5>";
	echo "<h2>deatil page shortcode used</h2>";
	echo "<h5>  do_shortcode('[detail_page]')</h5>";
}
