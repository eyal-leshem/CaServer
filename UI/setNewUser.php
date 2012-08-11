<?php

	 /*
		save new yser that have permission to use this data vase 
	 */

	//chek permission 
	include "chekSession.php"; 
	
	if(!chekSession())
		exit("permission denied");
		
	//include the function dail with the hash
    //and the connector  to the database file 
	chdir(".."); 
	include "hashPass.php"; 
	include_once "dbConnector.php";  
	
	$userName=$_POST["userName"]; 
	$pass=$_POST["password"]; 

	//open conection to the database 
	$con=db_Open_conn(); 

	//hashed password
	$hashedPassword=generateHash($pass);

	//save this new user 
	$query="INSERT INTO permission VALUES('$userName','$hashedPassword')";
	mysql_query($query); 

	//close connection to data base 
	db_close_conn($con); 


 
?>