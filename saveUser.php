<?php 

/*
	script file that save user with permission to the data base 
*/

include "dbConnector.php"; 
include  "hashPass.php" ;

$con=db_Open_conn(); 


if($con==false) exit(1); 

//get username and password
$userName=$argv[1];
$password=$argv[2]; 

if( (!isset($argv[1]) )|| (!isset($argv[2]))  )
  exit(1); 

//hashed password
$hashedPassword=generateHash($password);

$query="INSERT INTO permission VALUES('$userName','$hashedPassword')";
if(mysql_query($query)==false)
	exit(1); 

db_close_conn($con); 
 





 




?> 