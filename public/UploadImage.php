<?php

$data = array('status'=>false);
 
// Importing DBConfig.php file.
require 'Backend/admin/config.php';
 
// Creating connection.
$con = mysqli_connect($database['host'],$database['user'], $database['pass'], $database['db']) 
or die("An unexpected error has occurred in the database connection");

 if ($_FILES['file']['name'] != "") 
 {

	$target_path = "files/"; 
	$target_path = $target_path.basename($_FILES['file']['name']); 
	//echo $target_path;
	 
	$mobileno = $_POST['mobileno'];
	$imagename = $_FILES['file']['name'];
	 
	if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) 
	{
		//echo "File uploaded successfully!"; 
		$Sql_Query1 = "UPDATE member SET photo = '$imagename' WHERE mobileno = '$mobileno' "; 
		if(mysqli_query($con,$Sql_Query1))
		{
			$data['status'] = true;
		}
		else
		{
			$data['status'] = false;
		}
		
	} 
	 else{
		$data['status'] = false;
		//echo "Sorry, file not uploaded, please try again!"; 
	} 
}
header('Access-Control-Allow-Origin: *');
header('Content-type:application/json');
echo json_encode($data);
?>