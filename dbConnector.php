<?php
include 'ServerConf.php';

function db_Open_conn(){
	
	//load the data of username and database name
	$dbAdd = loadConf("dbAddress");
	$dbUserName = loadConf("dbUserName");
	
	$con=mysql_connect($dbAdd, $dbUserName, "a10097");
	mysql_select_db(loadConf("dbName"),$con);
	return $con; 
}

//close the connection 
function db_close_conn($con){
	mysql_close($con); 
} 

//add messge to the serverlog 
function addToserverLog($msg,$agentId,$impId,$error){
	
	if(!$error){
		$err="false";
	}
	else{
		$err="true"; 
	}
	
	$str= "INSERT INTO serverlog VALUES ('$msg',NOW(),'$agentId','$impId',$err)";
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