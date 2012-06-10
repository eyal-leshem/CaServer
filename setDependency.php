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


if ($_POST)
 {
	//foreach ($_POST as $key => $value)
	for($i = 0; $i < 4; $i++)
	{
		//if it is more than one word (expected), return 
		$value = $_POST[$i];
		if(strlen($value) > 0 && (strcmp($i, "submit") != 0))
		{
			$kv[$i] = $value;
			echo($i);
			echo(" \n");
			echo($value);
			echo(" \n");
		}
	}
	//the first value is agent id that it data has to be shared
	$agentId = $_POST['agentIdForShare'];
	$task = $_POST['task'];
	$implementorId = $_POST['implementorId'];
	$taskId = $_POST['taskId'];
	$alg= $_POST['alg'];
	//now pass through all the parameters and create task in the table
	foreach($kv as $key => $value)
	{
		$newId = $taskId;
		if((strcmp($task,"generate key Pair")!=0)&&(strcmp($task,"generate secret")!=0)){
			//TODO handle error
		}
		else{		
			//create a task for generating a key
			addNewTask($taskId, $agentId, 0, $task, $implementorId,$alg);
			$taskId = $taskId+1;
			//create task for generating key with dependancy for updating task
			if(strcmp($task,"generate secret")==0)
				addNewTask($taskId, $value, $newId, "install secret", $implementorId,$alg);
			else 
				addNewTask($taskId, $value, $newId, "install cert", $implementorId,$alg);
		}
	}
	
	
}

?>