<?php

include 'dbConnector.php';
include 'MyKeyTool.php';

/**
*this function ask the if we have that usert name and password in our db - with this password 
*/
function dbChekInstallerPassword($name,$password){
	
	$name= mysql_real_escape_string($name); 
	$password= mysql_real_escape_string($password); 
	$str="SELECT * FROM permission WHERE username='".$name."'";
	$result=mysql_query($str);
	$row=mysql_fetch_array($result);
	if(strcmp($row["password"],$password)==0){
		return true;
	}
	return false; 
}

/**
* insert new agent into the database 
*/
function dbAddNewAgent($agentName,$imps){

	//prevent sql injection 
	$agentName= mysql_real_escape_string($agentName); 
		
	//query for update the agents table  
	$str="INSERT INTO agents  VALUES ('".$agentName."',NOW(),NOW())";
	if(mysql_query($str)==false){
		return false; 
	} 
	
	//query for update the implemtors table with the implemtors
	//of this agent 
	$arr=split(",", $imps);
	foreach ($arr as &$imp) {
		//prevent sql injection 
		$imp= mysql_real_escape_string($imp);
    	
		$str="INSERT INTO implementors  VALUES ('".$agentName."','".$imp."')";
    	mysql_query($str);
	}
	 return true; 
}

//---------------------------------------///
//----- script of install new agent----///
//-------------------------------------///

$con=db_Open_conn(); 


//chek the username and password of the installer
if (dbChekInstallerPassword($_POST["instName"], $_POST["instPassword"], $con)) {
	//sign the certificate request 
	$certout=sign_csr($_POST["csr"]);
	
	//proglem while singing will cause to the "certout" var to be false 
	if ($certout) {
		//try to add the agent to db 
		if(dbAddNewAgent($_POST["name"],$_POST["implementors"])==false){
			//problem occur - in High probability the agentID isn't free 
			echo "agent name is not free"; 
			$msg = "anoher agent with name ".$_POST["name"]." try to register"; 
			addToserverLog($msg,$_POST["name"],$_POST["name"],true); 
				
		}
		//evething work well  
		else{
			addToserverLog("new agent register",$_POST["name"],$_POST["name"],false);
			//the answer
			echo $certout;
		}
	} 
	
}
//no Suitable username and password 
else {
	$msg="installer with name ".$_POST["instName"]." type worng password"; 
	addToserverLog($msg,$_POST["name"],$_POST["name"],true); 
}

db_close_conn($con); 







?>