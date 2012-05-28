<?php
	include 'dbConnector.php';
	//chek if string begin with the pattern in "startStr"
	function startsWith($str, $startStr)
	{
    	$length = strlen($startStr);
    	return (substr($str, 0, $length) === $startStr);
	}
	
	
    function saveData(){
    	echo "was in save data \n";
    	//get the properties for connecting to java class
		require_once("http://localhost:8087/JavaBridge/java/Java.inc");
		//connect to java 
		$world = new java("CertificateDB");
		echo $world->saveData(array($_POST["taskId"],$_POST["data"],$_POST["dataKind"],$_POST["dataAlg"]));
		
    }
			
	if(strcmp($_POST["isOk"],"false")==0){
		$errorMsg=$_POST["errorMsg"];
		//TODO handle error 
		
	}
	
	$taskId=$_POST["taskId"];
	$agentId=$_POST["agentId"];
	$kind=$_POST["dataKind"];
	$impId=$_POST["impId"]; 
	if (isset($_POST["data"])) { 
  		saveData();
	} 
	$con=db_Open_conn(); 
	dbTaskDone($taskId,$agentId,$kind,$impId,$con); 
				
	db_close_conn($con); 
	





?>