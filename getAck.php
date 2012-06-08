<?php
	include 'dbConnector.php';
	
    function saveData(){
    	echo "was in save data \n";
    	//get the properties for connecting to java class
		require_once("http://localhost:8087/JavaBridge/java/Java.inc");
		//connect to java 
		$world = new java("CertificateDB");
		$javaRet=$world->saveData(array($_POST["taskId"],$_POST["data"],$_POST["dataKind"],$_POST["dataAlg"]));
	
		
		
    }

    //case of error 
	if(strcmp($_POST["isOk"],"false")==0){
		$errorMsg=$_POST["errorMsg"];
		addToserverLog($errorMsg,$_POST["agentId"],$_POST["impId"],true);
		updateLastConn($agentId);
	}
	
	else{
		
		$taskId=$_POST["taskId"];
		$agentId=$_POST["agentId"];
		$kind=$_POST["dataKind"];
		$impId=$_POST["impId"]; 
		
		
		
		
		if (isset($_POST["data"])) { 
  			saveData();
		}
		 
		$con=db_Open_conn(); 
		updateLastConn($agentId,$con);
		dbTaskDone($taskId,$agentId,$kind,$impId,$con); 		
		db_close_conn($con); 
	}





?>