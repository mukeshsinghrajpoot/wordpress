<?php 
$key=$_POST['key'];
$secretkey=$_POST['secret_key'];
$key1="e3af7143";
$secretkey1="e3af7143-6c77-4f86-b062-5b4618c3d532";
if($key==$key1 && $secretkey==$secretkey1)
{
	echo "Success! Your api key and Secret Key Valid.";

}
else
{
echo "<div class='alert alert-danger alert-dismissible'>
<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
<strong>Fail!</strong> Your api key and Secret Key Not Valid.
</div>";
}

?>