<?php
	include 'dbConnector.php';
	
	//-------------------------------------//
	//--------------functions-------------//
	//-----------------------------------//
	function dbTaskDone($taskId,$agentId,$kind,$impId){
		
		
		//avoid sql injection
		$agentId = mysql_real_escape_string($agentId);
		$taskId = mysql_real_escape_string($taskId);
		
		$commandDateQury="SELECT commandDate,pullNum FROM tasks WHERE taskId=".$taskId; 
		$ans=mysql_fetch_array(mysql_query($commandDateQury));
		
		
		$commandDate=$ans[0]; 
		$pullNum=$ans[1]; 
		
		//add this to data base
		$str="INSERT INTO doneTasks VALUES ('".$taskId."','".$kind."', '".$agentId."','".$impId."', '".$commandDate."',NOW(),$pullNum)";
		mysql_query($str);
		//delte it form task 
		$str="DELETE FROM tasks WHERE taskId=".$taskId;
		mysql_query($str);
		
		//add log message 
		$str= "INSERT INTO serverlog VALUES (\"task".$taskId." done successfully\",NOW(),'".$agentId."','".$impId."',false)" ;  
		$ans=mysql_query($str);
		echo $ans; 
	}

	
	
    function saveData(){
    	echo "was in save data \n";
    	//get the properties for connecting to java class
		require_once("http://localhost:8087/JavaBridge/java/Java.inc");
		//connect to java 
		$world = new java("CertificateDB");
		$javaRet=$world->saveData(array($_POST["taskId"],$_POST["data"],$_POST["dataKind"],$_POST["dataAlg"]));	
				
    }

	/*
	*write the exception ito file 
	* the filename will b suitable to the taskid; 
	*/
    function	saveException($strExcption,$taskId){
	
		$file=fopen("exceptions/$taskId","a"); 
		$str="\n-------------------------------------------------\n";
		fwrite($file, $str);
		fwrite($file,$strExcption); 
		
		
	
	
	}
	
	
	//-------------------------------------------//
	//---------------script---------------------//
	//-----------------------------------------//
	
	$con=db_Open_conn();
	
    //case of error 
	if(strcmp($_POST["isOk"],"false")==0){
		
		$errorMsg=$_POST["errorMsg"];
		addToserverLog($errorMsg,$_POST["agentId"],$_POST["impId"],true);
		updateLastConn($_POST["agentId"]);
		saveException($_POST["fullException"],$_POST["taskId"]);
	}
	
	else{
		
		//get vars 
		$taskId=$_POST["taskId"];
		$agentId=$_POST["agentId"];
		$kind=$_POST["dataKind"];
		$impId=$_POST["impId"]; 			
		
		//save the data (case we have a data)
		if (isset($_POST["data"])) { 
  			saveData();
		}
		 
		 //update the database 
		 
		updateLastConn($agentId,$con);
		dbTaskDone($taskId,$agentId,$kind,$impId); 		
		
	}


	db_close_conn($con); 


?>