<?php
chdir("..");  
include 'ServerConf.php';
chdir ("trusted"); 

function db_Open_conn(){
	
	chdir("..");
	//load the data of username and database name
	$dbAdd = loadConf("dbAddress");
	$dbUserName = loadConf("dbUserName");
	
	$con=mysql_connect($dbAdd, $dbUserName, "a10097");
	
	mysql_select_db(loadConf("dbName"),$con);
	chdir ("trusted"); 
	return $con; 
}

//close the connection 
function db_close_conn($con){
	mysql_close($con); 
} 

//add messge to the serverlog 
function addToserverLog($msg,$agentId,$impId,$error){
	
	
	$str= "INSERT INTO serverlog VALUES ('$msg',NOW(),'$agentId','$impId',$error)";
	mysql_query($str); 
	
	
}

//open the connection 
function updateLastConn($agentName){
	
	$query="UPDATE agents SET lastConn=NOW() WHERE agentId='$agentName'"; 
	mysql_query($query); 
	
}

function delTimeLimtSession(){
	chdir("..");
	$timeLimit=loadConf("timeLimit");
	chdir ("trusted"); 
	
	$border=time()-$timeLimit;
	$query="DELETE FROM sessions WHERE contime < $border"; 
	mysql_query($query); 
	
	

}








?> 