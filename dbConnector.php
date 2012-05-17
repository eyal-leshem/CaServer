<?php

function db_Open_conn(){
	return mysql_connect("localhost","root","a10097"); 
}

function db_close_conn($con){
	mysql_close($con); 
} 

function dbChekInstallerPassword($name,$password,$con){
	mysql_select_db("server",$con);
	$name= mysql_real_escape_string($name); 
	$password= mysql_real_escape_string($password); 
	$str="SELECT * FROM permission WHERE username='".$name."'";
	$result=mysql_query($str);
	$row=mysql_fetch_array($result);
	if(strcmp($row[password],$password)==0){
		return true;
	}
	return false; 
}

function dbAddNewAgent($agentName,$imps){
	mysql_select_db("new",$con); 
	$str="INSERT INTO agents  VALUES ('".$agentName."',NOW(),NOW())";
	mysql_query($str); 
	$arr=split(",", $imps);
	foreach ($arr as &$imp) {
    	$str="INSERT INTO implementors  VALUES ('".$agentName."','".$imp."')";
    	mysql_query($str);
	}
	$str="INSERT INTO serverlog VALUES ('new Agenet regesiter',NOW(),'".$agentName."','',FALSE)";
	 mysql_query($str);
}







?> 