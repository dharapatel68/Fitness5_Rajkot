<?php

  //$conn= mysqli_connect("localhost", "gym_weybee", "gymweybee@123","gym_weybee");
  $conn= mysqli_connect("localhost", "root", "","gms_new");


  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM hr_deviceevent where eventid='101'";
$result = $conn->query($sql);

while($row=mysqli_fetch_assoc($result)){
       $deviceevents[]=$row;
     }
   
     foreach ($deviceevents as $deviceevent) {
      $dte='"'.$deviceevent['date'].'"';
          $query = "SELECT * from hr_device_emplog WHERE dateid =  '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";
        
          $result1 = $conn->query($query);
          $qq=array();
          while($row=mysqli_fetch_assoc($result1)){
            $qq[]=$row;
          }
          // print_r($qq[0]);
       for ($i=1;$i<=3;$i++){
        if(!empty($qq[0]['timein'.$i])){

        }else{
          $timeinrow='timein'.$i;
          $rty="UPDATE hr_device_emplog set $timeinrow = '".$deviceevent['time']."' WHERE dateid = '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";
      
          $rtyresult = $conn->query($rty);
          break;

        }
        if(!empty($qq[0]['timeout'.$i])){

        }else{
          $timeoutrow='timeout'.$i.'';
          $rty="UPDATE hr_device_emplog set $timeoutrow = '".$deviceevent['time']."' WHERE dateid = '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";
       
          $rtyresult = $conn->query($rty);
          $timeoutrow='';
        break;

        }

       }

        $sumdiff=0;
        /************for time calculate basis on punch***************** */
        $queryfortime = "SELECT * from hr_device_emplog WHERE dateid =  '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";

        $result1 = $conn->query($queryfortime);
        $qq=array();
        while($row=mysqli_fetch_assoc($result1)){
        $qq[]=$row;
        }
        for ($i=1;$i<=3;$i++){
        $ts1 = strtotime(str_replace('/', '-', ''.$qq[0]['timein'.$i].''));
        $ts2 = strtotime(str_replace('/', '-', ''.$qq[0]['timeout'.$i].''));
        $diff = abs($ts1 - $ts2) / 3600;
        $sumdiff=$sumdiff+$diff;
          }
        /*******************************/
        echo $sumdiff;
        $querystoretimediff = "UPDATE hr_device_emplog SET totalworkinghours = '".$sumdiff."' WHERE dateid = '".$deviceevent['date']."' AND empid='".$deviceevent['detail1']."' LIMIT 1";

           
     }


?>