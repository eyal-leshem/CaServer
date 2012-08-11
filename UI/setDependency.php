<?php

/*
	in this file we add new genrated tasks 
	(that created with the form of "gettasks.php")   
	into the database 
*/


//open coneccetion to the database 
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
	
	//isert the task into the database 
	$date = date("Y-m-d H:i:s");
	$str="INSERT INTO tasks VALUES (".$taskId.",".$dependsOn.", '$alg','".$kind."', '".$agentId."', '".$implementorId."',NOW(),0)";
	$ans=mysql_query($str);
	 
	return $taskId;
}

//ad low secure data to the database (like configuration data, or serial number to crl  ...)
function addLowSecureData($taskId,$data){
		
		$query="INSERT INTO  lowSecureData  VALUES('$taskId','$data')";
		mysql_query($query);
}

/*
	return the next free number to be the task id 
*/
function getTaskId(){

	//the max from all the tabel 
	$query=" SELECT MAX(taskId) FROM
						(SELECT taskId From tasks  UNION
						 SELECT taskId From donetasks	UNION	
						 SELECT taskId FROM failedtasks) AS x	"; 
	$ans=mysql_query($query);
	$res = mysql_fetch_array($ans); 

	//the data base will return null 
	//at the first tast 
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

//get the relavant data of the agent that need to create the key (or rmove or add to crl )
$agentId = $_POST['agentIdForShare'];
$task = $_POST['task'];
$implementorId = $_POST['implementorId'];	
$taskId=getTaskId(); 
$alg= $_POST['algorithm'];

//case we need to save the serial number in the database 
if( ($task=="remove certifcate") || ($task=="add to crl") ){
	
	//get the taskid and the serial number
	$ser=$_POST["serialNumber"];
	$taskId=getTaskId();
	
	//add the serialNumber to the database
	addLowSecureData($taskId,$ser);
	addNewTask($taskId, $agentId, 0, $task, $implementorId,""); 
	return; 
	
	
}

//instalize agent string to empty string 
$agents_string = "";

//the  agents array
$kv = array();

//the implemtors array 
$imps=array(); 


if ($_POST)
 {
	//foreach ($_POST as $key => $value)
	for($i = 1; $i <= 4; $i++)
	{
		
		//add the implemtors to array 
		$agent = $_POST["$i"];		
		$imp   = $_POST["imp$i"]; 
		if(strlen($agent) > 0 && (strcmp($i, "submit") != 0))
		{
			$kv[$i] = $agent;
			$imps[$i]=$imp; 
	
		}
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