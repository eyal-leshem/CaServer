<?php 
	
	//add the new update task to the database 
	function addNewTask($taskId, $agentId, $dependsOn, $kind, $implementorId,$alg)
	{	
		//sanitizing the parameters we got
		$name = mysql_real_escape_string($agentId);
		$depends = mysql_real_escape_string($dependsOn);
		$kind = mysql_real_escape_string($kind);
		$password = mysql_real_escape_string($implementorId);
		$date = date("Y-m-d H:i:s");
		
		//isert the answer into the database 
		$str="INSERT INTO tasks VALUES (".$taskId.",".$dependsOn.", '$alg','".$kind."', '".$agentId."', '".$implementorId."',NOW(),0)";
		$ans=mysql_query($str);
		
		return $taskId;
	}
	
	//add the data of the new coiguration to the database 
	function addConfData($taskId,$newConf){
		$query="INSERT INTO  lowSecureData  VALUES('$taskId','$newConf')";
		mysql_query($query);
	}
	
	/*
		get the next free task id 
	*/
	function getTaskId(){

			//get the bigger task number already use
			$query=" SELECT MAX(taskId) FROM
								(SELECT taskId From tasks  UNION
								 SELECT taskId From donetasks	UNION	
								 SELECT taskId FROM failedtasks) AS x	"; 
			$ans=mysql_query($query);
			$res = mysql_fetch_array($ans); 

		
			//if it is the first task return 1 
			//else the next free number 
			if(is_null($res[0]))
				return 1; 
			else
				return  $res[0]+1; 
		
	}
	
	//check that we are in safe session 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
	
	//open connection 
	chdir (".."); 
	require_once("dbConnector.php");
	$con=db_Open_conn(); 
	chdir ("UI");

	//get the new configuration 
	$arr=array(); 
	$arr["sleepTime"]=$_POST["sleepTime"]; 
	$arr["urlSendAck"]=$_POST["urlSendAck"];
	$arr["urlNewImplemtor"]=$_POST["urlNewImplemtor"]; 
	$arr["urlGetTask"]=$_POST["urlPullTask"];
	
	//encode the data 
	$newConf=json_encode($arr); 
	 
	//save the new task and the data 
	$taskId=getTaskId(); 
	addNewTask($taskId, $_GET["agentId"],0, "change conf", "nop" ,"" );
	addConfData($taskId,$newConf); 
	
	//close connection 
	db_close_conn($con);


	
	
?>