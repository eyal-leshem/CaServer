
<?php

include 'dbConnector.php';

//--------------------------------------------//
//--------------functions--------------------//
//------------------------------------------//

/*
*chek if string start with substring 
*/
function startsWith($str, $startStr){
    	$length = strlen($startStr);
    	return (substr($str, 0, $length) == $startStr);
}

/**
*call to java function (while use java-php brige),
*that return te relvant data  from this task 
*(that data where store in the javakeystroe of the server)
*/
function getDependOnData($taskNum,$taskKind){
		
		echo $taskNum; 
		$query="SELECT aData From lowSecureData WHERE taskId='$taskNum'";
		$ans=mysql_query($query); 
		$ans=mysql_fetch_array($ans); 
		
		if($ans){
		
			return $ans[0]; 
		}

		require_once("http://localhost:8087/JavaBridge/java/Java.inc");
		$world = new java("CertificateDB");
		$taskNumStr=(String)$taskNum; 
		return $world->getData(array($taskNumStr,$taskKind));
}

/**
* return an array with all the tasks of this agent 
*/
function getTasks($agentId, $pullNumBound)
{
	
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
		$msgData["alg"] = mysql_result($result, $index,"alg");
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
			$str = "DELETE FROM tasks WHERE taskId = '$taskId' OR dependOn = '$taskId'";
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

/**
*get kind of task  with that taskid from the database 
*/
function dbGetDoneTaskKind($taskId){	
	
	$taskId = mysql_real_escape_string($taskId);
	
	$str="SELECT kind FROM donetasks WHERE taskid=".$taskId;

	$res=mysql_query($str);
	
	$ans=mysql_fetch_array($res);
			
	return $ans[0]; 
	
	
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

//--------------------------------------------//
//--------------script start-----------------//
//------------------------------------------//



//connect to the mysql server
$con=db_Open_conn();
if (!$con)
{
 die('Could not connect: ' . mysql_error());
}

//get the id of Agent (in POST)
//$agentId = mysql_real_escape_string($_POST["agentId"]);
$agentId = $_POST["agentName"];
updateLastConn($agentId);

//get the value of bound of the pulls number of tasks from server.conf file (encoded as jason)
$jsonData = json_decode(file_get_contents('../conf.cnf'), true);
$pullBound = $jsonData["pullsNumBound"];
echo "pullBound", $pullBound;

$tasksAr = getTasks($agentId, $pullBound);

$index=0; 
//$newtaskArr=array(); 
foreach ($tasksAr as $task)
{
	//if depend on isn't 0 it's says that we Depends upon another task 
	//and need to get here data 
	if($task["dependOn"]!=0)
	{
		//get the relvant data kind 
		$dataKind=dbGetDoneTaskKind($task["dependOn"]);
		$replay=(String)getDependOnData($task["dependOn"],$dataKind);
		$task["data"]=$replay; 

	}
	
	//case of data without depend on 
	if(strcmp($task["kind"],"change conf") ==0){
		$task["data"]=(String)getDependOnData($task["taskId"],""); 
	}
	
	
	//if we don't get error when we try to pull the data 
	//add it to the array of task that will return to the client
	if(!isset($replay)||!startsWith((String)$replay,"error:")){
		$newtaskArr[$index]=$task; 		
		$index++;
	}
	//case of error - write it to the log
	else{
		addToserverLog("javaPull-".$javaRet,$_POST["agentId"],$_POST["impId"],true);
	}


}

//return it btween the "*****" , for help to parse the answer 
$jsonTasks = json_encode($newtaskArr);
echo "*****"; 
echo($jsonTasks);
echo "*****";

mysql_close($con);

?>

