<?php

// Importing DBConfig.php file.
require 'Backend/admin/config.php';
 
// Creating connection.
$con = mysqli_connect($database['host'],$database['user'], $database['pass'], $database['db']) 
or die("An unexpected error has occurred in the database connection");
 
 // Getting the received JSON into $json variable.
 $json = file_get_contents('php://input');
 
 // decoding the received JSON and store into $obj variable.
 $obj = json_decode($json,true);
 
// Populate column from JSON $obj array and store into $coulmn.
$mobileno = $obj['mobileno'];

$memberpin = rand(1000,9999);

$msg = urlencode("Fitness5 : Your FIT Pin is ".$memberpin);
 
$url = 'http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6';

$api = 'http://vsms.vr4creativity.com/api/mt/SendSMS?user=feetness5b&password=five@feetb&senderid=FITFIV&channel=Trans&DCS=0&flashsms=0&number='.$mobileno.'&text='.$msg.'&route=6';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
curl_setopt($ch, CURLOPT_URL,$api);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

		$Sql_Query1 = "UPDATE member SET memberpin = '$memberpin' WHERE mobileno = '$mobileno' "; 
		if(mysqli_query($con,$Sql_Query1))
		{
			echo json_encode("Sent");
		}
		else
		{
			echo json_encode("Something Went Wrong");
		}
 
mysqli_close($con);
?>