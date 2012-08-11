<?php

//include the php file of the server cofiguration 
chdir("..");  
include 'ServerConf.php';
chdir ("trusted");

 
/*
	open connection to database 
	get the database properties from 
	configurtion file
*/
function db_Open_conn(){
	
	//to the dir of configuration file 
	chdir("..");
	
	//load the data of username and database name
	$dbAdd = loadConf("dbAddress");
	$dbUserName = loadConf("dbUserName");
	$dbPassword = loadConf("password"); 
	
	//open the conection and select the database 
	$con=mysql_connect($dbAdd, $dbUserName, $dbPassword);
	mysql_select_db(loadConf("dbName"),$con);
	
	//go back to our dir
	chdir ("trusted");
	
	//return the connection 
	return $con; 
}

/*
	close the connection to the database 
*/
function db_close_conn($con){
	mysql_close($con); 
} 

/*
	add a message to the table of 
	the server log
*/
function addToserverLog($msg,$agentId,$impId,$error){

	//while to string for false is""
	//and to string  for true is "1"
	if($error==false)
		$error="0";
	
	//insert the data ito the table of serverlog 
	$str= "INSERT INTO serverlog VALUES ('$msg',NOW(),'$agentId','$impId',$error)";
	echo "$str \n"; 
	mysql_query($str); 
	
	
}

/*
	update the last connection time
	to be now 
*/ 
function updateLastConn($agentName){
	
	$query="UPDATE agents SET lastConn=NOW() WHERE agentId='$agentName'"; 
	mysql_query($query); 
	
}










?> 