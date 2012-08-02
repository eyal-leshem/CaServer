<?php
	include 'dbConnector.php';
	
	//-------------------------------------//
	//--------------functions-------------//
	//-----------------------------------//
	
	
	//function that check if the haystack string start with the needle string
	function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);		
	}

	/*
		inform the database about task that done 
	*/
	function dbTaskDone($taskId,$agentId,$kin,$impId){
		
		
		//avoid sql injection
		$agentId = mysql_real_escape_string($agentId);
		$taskId = mysql_real_escape_string($taskId);
	
		//get data about the task 
		$commandDateQury="SELECT commandDate,pullNum,kind FROM tasks WHERE taskId=".$taskId; 
		$ans=mysql_fetch_array(mysql_query($commandDateQury));		
		$commandDate=$ans[0]; 
		$pullNum=$ans[1]; 
		$kind=$ans[2]; 
		
		//insert it itno the table of the done tasks 
		$str="INSERT INTO doneTasks VALUES ('".$taskId."','".$kind."', '".$agentId."','".$impId."', '".$commandDate."',NOW(),$pullNum)";
		mysql_query($str);
		
		//delte it form the queued tasks 
		$str="DELETE FROM tasks WHERE taskId=".$taskId;
		mysql_query($str);
		
		//add log message 
		$str= "INSERT INTO serverlog VALUES (\"task".$taskId." done successfully\",NOW(),'".$agentId."','".$impId."',false)" ;  
		$ans=mysql_query($str);

	}

	/*
		use the java php connector to save 
		the keys in a keystore 
	*/
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
	
	/*
		data that we don't need to save in key store 
		so we store it in the database of the server s
	*/
	function saveLowSecureData(){
	
		//get the data from post 
		$taskId=$_POST["taskId"];
		$agentId=$_POST['agentId'];
		$data=$_POST['data'];
		
		//get lint of task
		$kindsQuery="SELECT kind FROM tasks WHERE  taskId=$taskId";
		$ans=mysql_query($kindsQuery);
		$ansArr=mysql_fetch_array($ans);
		$kind=$ansArr[0]; 
		
		//update configuration on server  
		if($kind=="change conf"){
			$query="UPDATE agentsconf SET AgentConf='$data' WHERE agentId='$agentId'"; 
			mysql_query($query);
		}
		
		//add new instance
		if($kind=="new inst"){
			$dataArr=split(",",$data); 
			$arrLength=count($dataArr);
			
			$impName=$dataArr[0]; 
			$query="INSERT INTO implementors VALUES ('$agentId','$impName')"; 
			mysql_query($query);
			
			for($i=1;$i<$arrLength;$i=$i+1){
					$algName=$dataArr[$i]; 
					$query="INSERT INTO algorithms VALUES ('$agentId','$impName','$algName')";
					mysql_query($query);
			}			
			
		}
	}

	/*
		write the exception ito file 
	 	the filename will b suitable to the taskid; 
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

		//defualt 
		$errorFlag=false; 
		
		//save the data (case we have a data)
		if (isset($_POST["data"])) {
			
			//case of low secure data - like agent configuration
			if(strcmp($impId,"nop")==0)
				saveLowSecureData();
			
			//use the java connector 
			//for saving the key 
			else{
				$javaAns=saveKeyData();
				//the connect to hava fail 
				if(startsWith($javaAns,"error")||strcmp($javaAns,"fail")==0){
					$errorFlag=true;
				}
			}
			
		}//end of if isset 
		 
		 //update the database 		 		
		if(!$errorFlag){
			dbTaskDone($taskId,$agentId,$kind,$impId); 			
		}
		else{
			//case of error 
			addToserverLog("poblem with java conntcetor while fet data of task $taskId",$agentId,$impId,true);			
		}		
		
	}

	//close the connection 
	db_close_conn($con); 


?>