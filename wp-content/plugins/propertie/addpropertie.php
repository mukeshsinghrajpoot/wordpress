<?php 
 function add_propertie()
{

 global $wpdb;
 $blogtime = current_time( 'mysql' );
 $table_name = $wpdb->prefix . 'xml_data';
 $permit_number        = $_POST['permit_number'];
 $reference_number     = $_POST['reference_number'];
 $offering_type        = $_POST['offering_type'];
 $property_type        = $_POST['property_type'];
 $price_on_application = $_POST['price_on_application'];
 $price                = $_POST['price'];
 $city                 = $_POST['city'];
 $community            = $_POST['community'];
 $sub_community        = $_POST['sub_community'];
 $title_en             = $_POST['title_en'];
 $amenities            = $_POST['amenities'];
 $size				         = $_POST['size'];
 $bedroom			         = $_POST['bedroom'];
 $bathroom             = $_POST['bathroom'];
 $name                 = $_POST['name'];
 $email                = $_POST['email'];
 $phone                = $_POST['phone'];
 $developer            = $_POST['developer'];
 $parking              = $_POST['parking'];
 $furnished            = $_POST['furnished'];
 $geopoints            = $_POST['geopoints'];
 $photo                = $_POST['photo'];
 $description_en       = $_POST['description_en'];
 $data = array(
 				'permit_number' => $permit_number,
		        'last_update' => $blogtime,
		        'reference_number' => $reference_number,
		        'offering_type' => $offering_type,
		        'property_type' => $property_type,
		        'price_on_application' => $price_on_application,
		        'price' => $price,
		        'city' => $city,
		        'community' => $community,
		        'sub_community' => $sub_community,
		        'title_en' => $title_en,
		        'description_en' => $description_en,
		        'amenities' => $amenities,
		        'size' => $size,
		        'bedroom' => $bedroom,
		        'bathroom' => $bathroom,
		        'name' => $name,
		        'email' => $email,
		        'phone' => $phone,
		        'developer' => $developer,
		        'parking' => $parking,
		        'furnished' => $furnished,
		        'geopoints' => $geopoints,
		        'photo' => $photo,
   
);

 $insert = $wpdb->insert($table_name, $data);
 
 if( $insert==1) {
 echo  '<div class="containe"><div class="row"><div class="col-sm-8"><div style="margin-top:20px" class="alert alert-success"><strong>Inserted!</strong>  successfully.</div></div></div></div>';
      } 
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/propertie/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<br>
<div class="container" style="border-color: red;">
  <h2>ADD PROPERTIE</h2>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">	
<div class="row">
	<div class="col-sm-4">permit_number:<input type="text" class="form-control" name="permit_number"></div>	
	<div class="col-sm-4">reference_number:<input type="text" class="form-control" name="reference_number"></div>
</div>
<div class="row">
	<div class="col-sm-4">offering_type:<input type="text" class="form-control" name="offering_type"></div>	
	<div class="col-sm-4">property_type:<input type="text" class="form-control" name="property_type"></div>
</div>
<div class="row">
	<div class="col-sm-4">price_on_application:<input type="text" class="form-control" name="price_on_application"></div>	
	<div class="col-sm-4">	price:<input type="text" class="form-control" name="price"></div>
</div>
<div class="row">
	<div class="col-sm-4">city:<input type="text" class="form-control" name="city"></div>	
	<div class="col-sm-4">community:<input type="text" class="form-control" name="community"></div>
</div>
<div class="row">
	<div class="col-sm-4">sub_community:<input type="text" class="form-control" name="sub_community"></div>	
	<div class="col-sm-4">title_en:<input type="text" class="form-control" name="title_en"></div>
</div>
<div class="row">
	<div class="col-sm-4">amenities:<input type="text" class="form-control" 
		name="amenities"></div>	
	<div class="col-sm-4">size:<input type="text" class="form-control" name="size"></div>
</div>
<div class="row">
	<div class="col-sm-4">bedroom:<input type="text" class="form-control" 
		name="bedroom"></div>	
	<div class="col-sm-4">bathroom:<input type="text" class="form-control" name="bathroom"></div>
</div>
<div class="row">
	<div class="col-sm-4">name:<input type="text" class="form-control" 
		name="name"></div>	
	<div class="col-sm-4">email:<input type="text" class="form-control" name="email"></div>
</div>
<div class="row">
	<div class="col-sm-4">phone:<input type="text" class="form-control" name="phone"></div>	
	<div class="col-sm-4">developer:<input type="text" class="form-control" name="developer"></div>
</div>
<div class="row">
	<div class="col-sm-4">parking:<input type="text" class="form-control" 
		name="parking"></div>	
	<div class="col-sm-4">furnished:<input type="text" class="form-control" name="furnished"></div>
</div>
<div class="row">
	<div class="col-sm-4">geopoints:<input type="text" class="form-control" 
		name="geopoints"></div>	
	<div class="col-sm-4">photo:<input type="text" class="form-control" name="photo"></div>
</div>
<div class="row">
	<div class="col-sm-8">description_en:<textarea name="description_en" rows="4" cols="103"></textarea></div>	
</div>
<br>
<br>
<div class="row">
	<div class="col-sm-8">
		<button type="submit" class="btn btn-primary" name="submit">ADD PROPERTIES</button>
	</div>	
</div>
</form>		
</div>	
<?php 	
}
?>
<?php 
function viewpropertie()
{
global $wpdb;
$id=$_GET['id'];
$chk1=$_POST['checked_id'];

if (is_array($chk1) || is_object($chk1))
{
	$table_name = $wpdb->prefix . 'xml_data';
    foreach ($chk1 as $id2)
    {
        $del=$wpdb->query(
                "DELETE FROM $table_name
                WHERE id = $id2"
        );
    }
    if( $del==1) {
 	echo  '<br><br><div class="containe"><div class="row"><div class="col-sm-8"><div class="alert alert-success"><strong>Delete data!</strong>  successfully.</div></div></div></div>';
      }
}

if($id!=="")
{
$table_name = $wpdb->prefix . 'xml_data';
$del=$wpdb->query(
                "DELETE FROM $table_name
                WHERE id = $id"
        );
if( $del==1) {
 echo  '<div class="containe"><div class="row"><div class="alert alert-success"><strong>Delete data!</strong>  successfully.</div></div></div>';
      }
}
 
?>

<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/propertie/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<script type='text/javascript' src='<?php echo WP_PLUGIN_URL; ?>/propertie/bootstrap/js/myjs.js'></script>
<div class="container">
  <h2>View Properties</h2>
  <form  action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post"/>
  <button type="submit" class="btn btn-danger" name="submit">DELETE SELECT PROPERTIES</button>
  <br>
  <br>       
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th><input type="checkbox" id="select_all" value=""/></th>
        <th>Name</th>
		    <th>Email</th>
        <th>Permit Number</th>
        <th>Property Type</th>
		    <th>price</th>
		    <th>Action</th> 
      </tr>
    </thead>
    <tbody>
    		<?php global $wpdb;
    		$table_name = $wpdb->prefix . 'xml_data';
			$result = $wpdb->get_results("SELECT * FROM $table_name");
    		foreach ($result as $page) {
    		$id=   $page->id;
            $permit_number= $page->permit_number;
            $last_update= $page->last_update;
            $reference_number= $page->reference_number;
            $offering_type= $page->offering_type;
            $property_type= $page->property_type;
            $price_on_application= $page->price_on_application;
            $price= $page->price;
            $city= $page->city;
            $community= $page->community;
            $sub_community= $page->sub_community;
            $title_en= $page->title_en;
            $description_en= $page->description_en;
            $amenities= $page->amenities;
            $size= $page->size;
            $bedroom= $page->bedroom;
            $bathroom= $page->bathroom;
            $name= $page->name;
            $email= $page->email;
            $phone= $page->phone;
            $developer= $page->developer;
            $parking= $page->parking;
            $furnished= $page->furnished;
            $photo= $page->photo;
            $photo1=explode(",",$photo);
            $geopoints= $page->geopoints;
            $geopoints1=explode(",",$geopoints);
			?>
      <tr>
      	<td><input type="checkbox" name="checked_id[]" class="checkbox" value="<?php  echo $id; ?>"></td>
      	<td><?php echo $name; ?></td>
      	<td><?php echo $email; ?></td>
      	<td><?php echo $permit_number; ?></td>
      	<td><?php echo $property_type; ?></td>
      	<td><?php echo $price; ?></td>
      	<td><a href="<?php echo admin_url('admin.php?page=propertie-view&id=' . $id); ?>" class="btn btn-danger">Delete</a></td>
      </tr>
  <?php } ?>
    </tbody>
  </table>
  <button type="submit" class="btn btn-danger" name="submit">DELETE SELECT PROPERTIES</button>
</form>
</div>
<?php
}
?>
<?php 
function loadscript()
{
?>
<link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/propertie/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<div class="container">
	<br>
	<br>
 <div class="row">
 	<div class="col-sm-4">
 		<a href="<?php echo get_site_url();  ?>/newinsert.php" class="btn btn-success">Script Run propertie</a> 
 	</div>	
 </div>	
</div>	
<?php
}
?>