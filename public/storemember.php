
<?php 
 include 'global.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gms_new";
// echo $_POST["code"];
// echo $GLOBALS["addmember"];exit;

// print_r($_SESSION);
// exit;
// if(isset($_SESSION['addmember'])){
// echo yes;
// exit;
// }
// exit;
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());
}
$today=date('Y-m-d');
 $mpin=rand(1000, 9999);
 $workinghourfrom = date("Y-m-d H:i:s", strtotime($_POST["working_hour_from_1"]));
 $workinghourto = date("Y-m-d H:i:s", strtotime($_POST["working_hour_to_1"]));


 if ($_FILES['profileimage']['name'] != "") {
 	$photo=$_FILES['profileimage']['name'];
 	}
 $countfiles = count($_FILES['attachments']['name']);
 
 // Looping all files

 for($i=0;$i<$countfiles;$i++){

   $filename = $_FILES['attachments']['name'][$i];
   $data[] = $filename;
   
   // Upload file
  
    
 }
$files = implode(',', $data); 
$username=$_POST["username"];
$sql = "INSERT INTO `memberdata` (`memberid`, `userid`, `firstname`, `lastname`, `username`,`address`, `city`, `gender`, `email`, `createddate`, `hearabout`, `bloodgroup`, `other`, `formno`, `mobileno`, `homephonenumber`, `officephonenumber`, `profession`, `birthday`, `anniversary`, `emergancyname`, `emergancyrelation`, `emergancyaddress`, `emergancyphonenumber`, `workinghourfrom`, `workinghourto`, `amount`, `companyid`, `photo`, `files`, `memberpin`, `extra1`, `extra2`, `status`, `created_at`, `updated_at`) VALUES (NULL,NULL, '".$_POST["firstname"]."','".$_POST["lastname"]."','".$_POST["username"]."', '".$_POST["Address"]."', '".$_POST["City"]."', '".$_POST["gender"]."', '".$_POST["email"]."', '".$today."', '".$_POST["HearAbout"]."', '".$_POST["bloodgroup"]."', 'NULL', 'NULL', '".$_POST["CellPhoneNumber"]."', '".$_POST["HomePhoneNumber"]."', '".$_POST["OfficePhoneNumber"]."', '".$_POST["profession"]."', '".$_POST["birthday"]."', '".$_POST["anniversary"]."', '".$_POST["emergancyname"]."', '".$_POST["emergancyrelation"]."', '".$_POST["emergancyaddress"]."', '".$_POST["EmergancyPhoneNumber"]."', '".$workinghourfrom."', '". $workinghourto."', NULL, '".$_POST["bycompany"]."', '".$photo."','".$files."', '".$mpin."', NULL, NULL, '1', '".$today."', NULL)";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    $sql2 = "UPDATE `short_links` SET `status` = '0' WHERE  code='".$_POST["code"]."'";
		if (mysqli_query($conn, $sql2)) {

			  header("Location: success.php");
		}
		else{
				  header("Location: failer.php");
		}
		

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}



 if ($_FILES['profileimage']['name'] != "") {
	$name=$_FILES['profileimage']['name'];
	$name=$name.$username;
	$target_path = "images/"; 
	$target_path = $target_path.basename($name); 
	echo $target_path;

	if(move_uploaded_file($_FILES['profileimage']['tmp_name'], $target_path)) { 
		echo "File uploaded successfully!"; 
	} else{ 
		echo "Sorry, file not uploaded, please try again!"; 
	} 


   }
	for($i=0;$i<$countfiles;$i++){

	$filename = $_FILES['attachments']['name'][$i];
	$filename=$filename.$username;

	// Upload file


	move_uploaded_file($_FILES['attachments']['tmp_name'][$i],'files/'.$filename);
	}


   $_POST='';
mysqli_close($conn);
?>
