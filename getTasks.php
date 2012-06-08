
<?php

include 'dbConnector.php';

function startsWith($str, $startStr){
    	$length = strlen($startStr);
    	return (substr($str, 0, $length) == $startStr);
}

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
updateLastConn($agentId,$con);

//get the value of bound of the pulls number of tasks from server.conf file (encoded as jason)
$jsonData = json_decode(file_get_contents('server.conf'), true);
$pullBound = $jsonData["pullsNumBound"];
echo "pullBound", $pullBound;

$tasksAr = getTasks($agentId, $pullBound);

$index=0; 

foreach ($tasksAr as $task)
{
	if($task["dependOn"]!=0)
	{
		$dataKind=dbGetDoneTaskKind($task["dependOn"],$con);
		$replay=(String)getDependOnData($task["dependOn"],$dataKind);
		
		//echo $replay; 
		$task["data"]=$replay; 

	}
	if(!isset($replay)||!startsWith($replay,"error:")){
		$newtaskArr[$index]=$task; 		
		$index++;
	}
	else{
		addToserverLog("javaPull-".$javaRet,$_POST["agentId"],$_POST["impId"],true);
	}


}

$jsonTasks = json_encode($newtaskArr);
echo "*****"; 
echo($jsonTasks);
echo "*****";

mysql_close($con);

?>

