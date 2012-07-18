<?php
	include 'dbConnector.php';
	
	//-------------------------------------//
	//--------------functions-------------//
	//-----------------------------------//
	
	function startsWith($haystack, $needle){
		
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
		
	}

	// inform the database about task that done 
	function dbTaskDone($taskId,$agentId,$kin,$impId){
		
		
		//avoid sql injection
		$agentId = mysql_real_escape_string($agentId);
		$taskId = mysql_real_escape_string($taskId);
		
		$commandDateQury="SELECT commandDate,pullNum,kind FROM tasks WHERE taskId=".$taskId; 
		$ans=mysql_fetch_array(mysql_query($commandDateQury));
		
		
		$commandDate=$ans[0]; 
		$pullNum=$ans[1]; 
		$kind=$ans[2]; 
		
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

	
	
    function saveKeyData(){
    	
    	//get the properties for connecting to java class
		if(!@include_once("http://localhost:8087/JavaBridge/java/Java.inc")){
			return "fail"; 
		}
		
		//connect to java for saving 
		$world = new java("CertificateDB");
		$javaRet=$world->saveData(array($_POST["taskId"],$_POST["data"],$_POST["dataKind"],$_POST["dataAlg"]));	
		$javaRet=(string)$javaRet;
		return $javaRet; 
				
    }
	
	function saveLowSecureData(){
		$a=$_POST['data'];
		$b=$_POST['agentId'];
		$query="UPDATE agentsconf SET AgentConf='$a' WHERE agentId='$b'"; 
		mysql_query($query);
	}

	/*
	*write the exception ito file 
	* the filename will b suitable to the taskid; 
	*/
    function	saveException($strExcption,$taskId){
	
		$file=fopen("../exceptions/$taskId","a"); 
		$str="\n-------------------------------------------------\n";
		fwrite($file, $str);
		fwrite($file,$strExcption); 
		
		
	
	
	}
	 
	
	//-------------------------------------------//
	//---------------script---------------------//
	//-----------------------------------------//
	
	$con=db_Open_conn();
	updateLastConn($_POST["agentId"]);
	
    //case of error 
	if(strcmp($_POST["isOk"],"false")==0){
		
		//get the error massege 
		$errorMsg=$_POST["errorMsg"];
		
		echo "$errorMsg \n"; 
		echo $_POST["agentId"]."\n"; 
		echo $_POST["impId"]."\n";
		
		//add note to the log 
		addToserverLog($errorMsg,$_POST["agentId"],$_POST["impId"],true);
		
		//save the execption massege in the server 	
		saveException($_POST["fullException"],$_POST["taskId"]);
	}
	
	else{
		
		//get vars 
		$taskId=$_POST["taskId"];
		$agentId=$_POST["agentId"];
		$kind=$_POST["dataKind"];
		$impId=$_POST["impId"]; 

		$errorFlag=false; 
		
		//save the data (case we have a data)
		if (isset($_POST["data"])) {
			//case of low secure data - like agent configuration
			if(strcmp($impId,"nop")==0)
				saveLowSecureData();
			
			//use the jav connector 
			//for saving the key 
			else{
				$javaAns=saveKeyData();
				//the connect to hava fail 
				if(startsWith($javaAns,"error")||strcmp($javaAns,"fail")==0){
					$errorFlag=true;
				}
			}
		}
		 
		 //update the database 		 		
		if(!$errorFlag){
			dbTaskDone($taskId,$agentId,$kind,$impId); 			
		}
		else{
			//case of error 
			addToserverLog("poblem with java conntcetor while fet data of task $taskId",$agentId,$impId,true);			
		}		
		
	}


	db_close_conn($con); 


?>