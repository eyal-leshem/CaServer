<?php

include 'dbConnector.php';

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

echo("was here");
echo("<BR><BR>");

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