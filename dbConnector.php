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


function getTasks($agentId)
{
	$database = "server";
	//select the DB
	@mysql_select_db($database) or die( "Unable to select database");
	$agentId = mysql_real_escape_string($agentId);
	$req = "SELECT * FROM tasks WHERE AgentId = '$agentId'";
	$result = mysql_query($req);
	
	$tasksNum=mysql_numrows($result);
	$tasksAr = array();
	//get the messages (array of arrays)
	for ($index = 0; $index < $tasksNum; $index++)
	{
		//array with values for current message
		$msgData = array();
		$msgData["taskId"] = mysql_result($result, $index,"taskId");
		$msgData["dependOn"] = mysql_result($result, $index,"dependOn");
		$msgData["kind"] = mysql_result($result, $index,"kind");
		$msgData["implementorId"] = mysql_result($result, $index,"ImplementorId");
		$msgData["commandDate"] = mysql_result($result, $index,"commandDate");
		
		//check - if we have a task that it's task depends on - check if this task was done
		if($msgData["dependOn"] != 0)
		{
			//check if the task we depend on not done yet
			if(checkTaskDone($msgData["dependOn"]) == false)
			{
				//if not done - skip to the next message
				continue;
			}
		}
		$tasksAr[$index] = $msgData;
	}
	return $tasksAr;
}


//checks if the taskId done
function checkTaskDone($taskId)
{
	$database = "server";
	//select the DB
	@mysql_select_db($database) or die( "Unable to select database");
	$req = "SELECT * FROM doneTasks WHERE taskId = '$taskId'";
	$result = mysql_query($req);
	//if the task with required id not been done yet - return false
	if(mysql_numrows($result) == 0)
	{
		return false;
	}
	return true;
	
}







?> 