
<?php

include 'dbConnector.php';

function getDependOnData($taskNum,$taskKind){
		require_once("http://localhost:8087/JavaBridge/java/Java.inc");
		$world = new java("CertificateDB");
		$taskNumStr=(String)$taskNum; 
		return $world->getData(array($taskNumStr,$taskKind));
}

//connect to the mysql server
$con=db_Open_conn();
if (!$con)
{
 die('Could not connect: ' . mysql_error());
}

//get the id of Agent (in POST)
//$agentId = mysql_real_escape_string($_POST["agentId"]);
$agentId = $_POST["agentName"];

$tasksAr = getTasks($agentId);

$index=0; 

foreach ($tasksAr as $task){
	if($task["dependOn"]!=0){
		$dataKind=dbGetDoneTaskKind($task["dependOn"],$con);
		$replay=(String)getDependOnData($task["dependOn"],$dataKind);
		echo $replay; 
		$task["data"]=$replay; 
		
	}
	$newtaskArr[$index]=$task; 		
	$index++; 
	
	
}

$jsonTasks = json_encode($newtaskArr);
echo "*****"; 
echo($jsonTasks);
echo "*****";

mysql_close($con);

?>

