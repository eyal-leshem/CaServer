<?php

	//chek permission 
	include "chekSession.php"; 
	if(!chekSession())
		exit("permission denied");
		
	//include the function dail with the hash
    //and the connector  to the database file 
	chdir(".."); 
	include "hashPass.php"; 
	
	$userName=$_POST["userName"]; 
	$pass=$_POST["password"]; 

	$con=db_Open_conn(); 

	//hashed password
	$hashedPassword=generateHash($pass);

	$query="INSERT INTO permission VALUES('$userName','$hashedPassword')";
	mysql_query($query); 

	db_close_conn($con); 


 
?>