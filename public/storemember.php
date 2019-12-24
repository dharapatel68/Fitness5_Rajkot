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



$sql = "INSERT INTO `memberdata` (`memberid`, `userid`, `firstname`, `lastname`, `address`, `city`, `gender`, `email`, `createddate`, `hearabout`, `bloodgroup`, `other`, `formno`, `mobileno`, `homephonenumber`, `officephonenumber`, `profession`, `birthday`, `anniversary`, `emergancyname`, `emergancyrelation`, `emergancyaddress`, `emergancyphonenumber`, `workinghourfrom`, `workinghourto`, `amount`, `companyid`, `photo`, `memberpin`, `extra1`, `extra2`, `status`, `created_at`, `updated_at`) VALUES (NULL,NULL, '".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["Address"]."', '".$_POST["City"]."', '".$_POST["gender"]."', '".$_POST["email"]."', '".$today."', '".$_POST["HearAbout"]."', '".$_POST["bloodgroup"]."', 'NULL', 'NULL', '".$_POST["CellPhoneNumber"]."', '".$_POST["HomePhoneNumber"]."', '".$_POST["OfficePhoneNumber"]."', '".$_POST["profession"]."', '".$_POST["birthday"]."', '".$_POST["anniversary"]."', '".$_POST["emergancyname"]."', '".$_POST["emergancyrelation"]."', '".$_POST["emergancyaddress"]."', '".$_POST["EmergancyPhoneNumber"]."', '".$workinghourfrom."', '". $workinghourto."', NULL, '".$_POST["bycompany"]."', 'NULL', '".$mpin."', NULL, NULL, '1', '".$today."', NULL)";

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
$_POST='';

mysqli_close($conn);
?>
