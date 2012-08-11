<?php
include 'ServerConf.php';

function db_Open_conn(){
	

	
	//load the data of username and database name
	$dbAdd = loadConf("dbAddress");
	$dbUserName = loadConf("dbUserName");
	$dbPassword = loadConf("password"); 
	

	
	//open the conection and select the database 
	$con=mysql_connect($dbAdd, $dbUserName, $dbPassword);
	mysql_select_db(loadConf("dbName"),$con);
	
	
	//return the connection 
	return $con; 
}

//close the connection 
function db_close_conn($con){
	mysql_close($con); 
} 

//add messge to the serverlog 
function addToserverLog($msg,$agentId,$impId,$error){
	

	$str= "INSERT INTO serverlog VALUES ('$msg',NOW(),'$agentId','$impId',$error)";
	echo "$str \n"; 
	mysql_query($str); 
	
	
}

//open the connection 
function updateLastConn($agentName){
	
	$query="UPDATE agents SET lastConn=NOW() WHERE agentId='$agentName'"; 
	mysql_query($query); 
	
}

function delTimeLimtSession(){

	$timeLimit=loadConf("timeLimit");
	$border=time()-$timeLimit;
	$query="DELETE FROM sessions WHERE contime < $border"; 
	mysql_query($query); 
	
	

}








?> 