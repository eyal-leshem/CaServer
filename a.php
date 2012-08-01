<?php

include 'dbConnector.php';
include 'MyKeyTool.php';
include 'hashPass.php'; 


//chek if the agnet name is free
function agentNameFreeCheck($agentName){
	
	
	//check for agent with this name 	
	$query="SELECT agentId FROM agents WHERE agentId='$agentName'"; 
	$ans=mysql_query($query);
	
	//already agent with this name
	if(mysql_fetch_array($ans)!=false)
		return false; 
		
	//check for agent with this name in the wating table 	
	$query="SELECT agentId FROM inReg WHERE agentId='$agentName'"; 
	$ans=mysql_query($query);
	
	//already agent with this name
	if(mysql_fetch_array($ans)!=false)
		return false; 
		
	return true; 

}

/**
*this function ask the if we have that usert name and password in our db - with this password 
*/
function dbChekInstallerPassword($name,$password){
	
	$name= mysql_real_escape_string($name); 
	$password= mysql_real_escape_string($password); 
	$str="SELECT * FROM permission WHERE username='".$name."'";
	$result=mysql_query($str);
	$row=mysql_fetch_array($result);
	if(checkEqual($password,$row["password"])){
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

	if(!agentNameFreeCheck($agentName))
		return false; 
		
	//for radical case- when another agent with that name 
	//already resgister but fail to approve the register 
	//so we need to delete the plugins of the old implemtor 
	$str="DELETE FROM plugins  WHERE  agentId='$agentName'";
	mysql_query($str);
	
	$current=time(); 
	
	$str="INSERT INTO inReg VALUES ('$agentName','$current')";
	mysql_query($str);
	
	
	
	//query for update the implemtors table with the implemtors
	//of this agent 
	$arr=split(",", $imps);
	foreach ($arr as &$imp) {
		//prevent sql injection 
		$imp= mysql_real_escape_string($imp);
    	
		if($imp!=""){		
			$str="INSERT INTO plugins  VALUES ('".$agentName."','".$imp."')";
			mysql_query($str);
		}
	}
	 return true; 
}

//add the cofiguration of the agent
function addNewConf($agentName,$conf){

	$query="INSERT INTO agentsconf values('$agentName','$conf')";
	mysql_query($query);
  
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
			addNewConf($_POST["name"], $_POST["jsonConf"]); 
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