<?php

chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

//------------------------------------//
//-------------functions-------------//
//----------------------------------//


//Return value: the id of added task
function addNewTask($taskId, $agentId, $dependsOn, $kind, $implementorId,$alg)
{
	
	
	//sanitizing the parameters we got
	$name = mysql_real_escape_string($agentId);
	$depends = mysql_real_escape_string($dependsOn);
	$kind = mysql_real_escape_string($kind);
	$password = mysql_real_escape_string($implementorId);
	$date = date("Y-m-d H:i:s");
	$str="INSERT INTO tasks VALUES (".$taskId.",".$dependsOn.", '$alg','".$kind."', '".$agentId."', '".$implementorId."',NOW(),0)";
	$ans=mysql_query($str);
	echo "<BR> $ans <BR>"; 
	

	return $taskId;
}

function getTaskId(){

	$query=" SELECT MAX(taskId) FROM
						(SELECT taskId From tasks  UNION
						 SELECT taskId From donetasks	UNION	
						 SELECT taskId FROM failedtasks) AS x	"; 
	$ans=mysql_query($query);
	$res = mysql_fetch_array($ans); 

	echo "<BR> task id $res[0] <BR>";
	
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
		if(strlen($agent) > 0 && (strcmp($i, "submit") != 0))
		{
			$kv[$i] = $agent;
			$imps[$i]=$imp; 
	
		}
	}
	//the first value is agent id that it data has to be shared
	$agentId = $_POST['agentIdForShare'];
	$task = $_POST['task'];
	$implementorId = $_POST['implementorId'];	
	$alg= $_POST['algorithm'];
	
	$taskId=getTaskId(); 
	
	
	
	//problem unknowen command 
	if((strcmp($task,"generate key Pair")!=0)&&(strcmp($task,"generate secret")!=0)){
		//TODO handle error
	}
	
	//create a task for generating a key
	addNewTask($taskId, $agentId, 0, $task, $implementorId,$alg);
	
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