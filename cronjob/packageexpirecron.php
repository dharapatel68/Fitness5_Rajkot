<?php

  //$conn= mysqli_connect("localhost", "admin_fitness5", "fitness5@123", "admin_fitness5"); 
  $query='select * from memberpackages';
  $result=mysqli_query($conn,$query);

     $today = date("Y-m-d"); 
       $enddate= "select * from memberpackages where status=1";
     $result=mysqli_query($conn,$enddate);
     $data=array();
     while($row=mysqli_fetch_assoc($result)){
       $data[]=$row;
     }
    
    for($i=0;$i<count($data);$i++)
    {
      if($data[$i]['expiredate'] < $today){
         
        $sql= "UPDATE memberpackages SET status='0' where expiredate ='".$data[$i]['expiredate']."'";
            mysqli_query($conn,$sql);
     
           }
    }
       
    
  echo "Package Expire Successfull";


  $query='SELECT *,MAX(expiredate) as maxdate FROM memberpackages where status = 1 GROUP BY userid';
  $result=mysqli_query($conn,$query);

     $today = date("Y-m-d"); 
       $enddate= "SELECT *,MAX(expiredate) as maxdate FROM memberpackages where status = 1 GROUP BY userid";
     $result=mysqli_query($conn,$enddate);
     $data=array();
     while($row=mysqli_fetch_assoc($result)){
       $data[]=$row;
     }
    
    for($i=0;$i<count($data);$i++)
    {
      if($data[$i]['maxdate'] < $today){
         
        $sql= "UPDATE member SET status='0' where userid ='".$data[$i]['userid']."'";
            mysqli_query($conn,$sql);
     
           }
    }
  
    echo "Member Expire Successfull";



    /************************************************* */
    $query='SELECT * FROM memberpackages where status = 1 GROUP BY userid';
    $result=mysqli_query($conn,$query);
  
        
       $data=array();
       while($row=mysqli_fetch_assoc($result)){
         $data[]=$row;
       }
      
      for($i=0;$i<count($data);$i++)
      {
        
           
          $sql= "UPDATE member SET status='1' where userid ='".$data[$i]['userid']."'";
              mysqli_query($conn,$sql);
       
             
      }
    
      echo "Member Activeted Successfull";

?>