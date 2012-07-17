<?php

function db_Open_conn(){
	return mysql_connect("localhost:3306","root","2104ao"); 
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



//get the agent id and the pull bound from configuration file
function getTasks($agentId, $pullNumBound)
{
	
	$database = "serverdb";
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
		if($msgData["dependOn"] != 0 && (checkTaskDone($msgData["dependOn"]) == false))
		{
			//if not done - skip to the next message
			continue;
		}
		
		//get the pull counter
		$pullNum = mysql_result($result, $index,"pullNum");
		
		//increase the pullNum for updating it in the DB in tasks table
		$pullNum++;
		//if pull number > counter from configurations - move the task to failed tasks
		if($pullNum > $pullNumBound)
		{
			$taskId = $msgData["taskId"];
			$imId =  $msgData["implementorId"];
			//add to failedTasks
			$str="INSERT INTO failedTasks VALUES ('$taskId','$agentId','$imId',NOW() )";
			mysql_query($str);
			
			//remove the task from tasks (now it is in the failedTasks so it has not to be in tasks anymore)
			$str = "DELETE FROM tasks WHERE taskId = '$taskId'";
			mysql_query($str);
		}
		else
		{
			$agentCurid = $msgData["taskId"];
			//increase the pull counter in the tasks and update the table
			$updateReq = "UPDATE tasks SET pullNum = '$pullNum' WHERE taskId = '$agentCurid'";
			mysql_query($updateReq);
			
			$tasksAr[$index] = $msgData;
		}
		
		
	}
	//for each task, add to the pullRequest (or incerement the counter)
	
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

//Return value: the id of added task
function addNewTask($taskId, $agentId, $dependsOn, $kind, $implementorId)
{
	$con=db_Open_conn();
	mysql_select_db("server",$con);
	//sanitizing the parameters we got
	$name = mysql_real_escape_string($agentId);
	$depends = mysql_real_escape_string($dependsOn);
	$kind = mysql_real_escape_string($kind);
	$password = mysql_real_escape_string($implementorId);
	$date = date("Y-m-d H:i:s");
	$str="INSERT INTO tasks VALUES ('".$taskId."','".$dependsOn."', '".$kind."', '".$agentId."', '".$implementorId."',NOW()), 0";
	mysql_query($str);

	//now get the id we got as auto incremented value
	//$idReq = "SELECT * FROM tasks WHERE AgentId = '$agentId' AND dependOn = '$dependsOn' AND kind = '$kind' 
				//AND ImplementorId = '$implementorId' AND commandDate = '$date'";
	//$result = mysql_query($idReq);

	mysql_close($con);
	//echo($result);
	return $taskId;
}

function dbTaskDone($taskId,$agentId,$kind,$impId,$con){
	mysql_select_db("server",$con);

	//avoid sql injection
	$agentId = mysql_real_escape_string($agentId);
	$taskId = mysql_real_escape_string($taskId);

	$commandDateQury="SELECT commandDate FROM tasks WHERE taskId=".$taskId; 
	$ans=mysql_fetch_array(mysql_query($commandDateQury));
	$commandDate=$ans[0]; 

	//add this to data base
	$str="INSERT INTO doneTasks VALUES ('".$taskId."','".$kind."', '".$impId."','".$agentId."', '".$commandDate."',NOW())";
	mysql_query($str);
	//delte it form task 
	$str="DELETE FROM tasks WHERE taskId=".$taskId;
	mysql_query($str);
	//add log message 
	$str= "INSERT INTO serverlog VALUES (\"task".$taskId." done successfully\",NOW(),'".$agentId."','".$impId."',false)" ;  
	mysql_query($str);
}

function dbGetDoneTaskKind($taskId,$con){

	mysql_select_db("server",$con);

	$taskId = mysql_real_escape_string($taskId);

	$str="SELECT kind FROM donetasks WHERE taskid=".$taskId;

	$res=mysql_query($str);

	$ans=mysql_fetch_array($res);

	return $ans[0]; 



}








?> 