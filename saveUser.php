<?php 

include "dbConnector.php"; 
include  "hashPass.php" ;

$con=db_Open_conn(); 

//get username and password
$userName=$argv[1];
$password=$argv[2]; 

//hashed password
$hashedPassword=generateHash($password);

$query="INSERT INTO permission VALUES('$userName','$hashedPassword')";
mysql_query($query); 

db_close_conn($con); 
 





 




?> 