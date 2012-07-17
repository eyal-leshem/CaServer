<?php

include 'dbConnector.php';

//------------------------------------//
//-------------functions-------------//
//----------------------------------//


//Return value: the id of added task
function addNewTask($taskId, $agentId, $dependsOn, $kind, $implementorId,$alg)
{
	$con=db_Open_conn();
	mysql_select_db("server",$con);
	//sanitizing the parameters we got
	$name = mysql_real_escape_string($agentId);
	$depends = mysql_real_escape_string($dependsOn);
	$kind = mysql_real_escape_string($kind);
	$password = mysql_real_escape_string($implementorId);
	$date = date("Y-m-d H:i:s");
	$str="INSERT INTO tasks VALUES (".$taskId.",".$dependsOn.", '$alg','".$kind."', '".$agentId."', '".$implementorId."',NOW(),0)";
	$ans=mysql_query($str);
	echo $ans; 
	
	//now get the id we got as auto incremented value
	//$idReq = "SELECT * FROM tasks WHERE AgentId = '$agentId' AND dependOn = '$dependsOn' AND kind = '$kind' 
				//AND ImplementorId = '$implementorId' AND commandDate = '$date'";
	//$result = mysql_query($idReq);
	
	mysql_close($con);
	//echo($result);
	return $taskId;
}

//get the next taskid 
//new number that bigger from all 
//the past tasks ids 
 function getTaskId(){
	
	//get the max task number 
	$query=" SELECT MAX(taskId) FROM
						(SELECT taskId From tasks  UNION
						 SELECT taskId From donetasks	UNION	
						 SELECT taskId FROM failedtasks) AS x	"; 
						 
	//ask the database 					 
	$ans=mysql_query($str);
	$res = mysql_fetch_array($ans); 

	//return the next free number 
	if(is_null($res[0]))
		return 1; 
	else
		return  $res[0]+1; 
	
}



//------------------------------------//
//--------------script---------------//
//----------------------------------//


/*POST messages format:
 
"agentIdForShare" => Id
"task" => GenerateKey/...

List with agentId-s for sharing:

"1" => agentId
"2" => agentId
....

*/

//get the id-s of the agents that we want to set them get the data
$agents_string = "";

$kv = array();
$imps=array(); 


if ($_POST)
 {
	//foreach ($_POST as $key => $value)
	for($i = 1; $i <= 4; $i++)
	{
		//if it is more than one word (expected), return 
		$agent = $_POST["$i"];
		$imp   = $_POST["imp$i"]; 
		if(strlen($value) > 0 && (strcmp($i, "submit") != 0))
		{
			$kv[$i] = $value;
			$imps[$i]=$imp; 
		}
	}
	//the first value is agent id that it data has to be shared
	$agentId = $_POST['agentIdForShare'];
	$task = $_POST['task'];
	$implementorId = $_POST['implementorId'];	
	$alg= $_POST['alg'];
	
	$taskId=getTaskId(); 
	

	//create a task for generating a key
	addNewTask($taskId, $agentId, 0, $task, $implementorId,$alg);
	addToserverLog("new task created for agent ",$agentId,$implementorId,false);	
	
	$dependOn = $taskId;
	
	//share all other agents; 
	foreach($kv as $key => $value)
	{
		$taskId = $taskId + 1; 
				
		$implementorId=$imps[$key]; 
		
		//create task for generating key with dependancy for updating task
		if(strcmp($task,"generate secret")==0)
			addNewTask($taskId, $value, $dependOn, "install secret",$implementorId ,$alg);
		else 
			addNewTask($taskId, $value, $dependOn, "install cert", $implementorId,$alg);
		
	}
	
	
}

?>