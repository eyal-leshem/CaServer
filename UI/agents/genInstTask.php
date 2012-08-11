<?php

/*
	php file that add the new task 
	of create new implementor to the database  
*/


//open connection to the database 
chdir (".."); 
chdir (".."); 
include_once 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

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

// save the configuration string in the lowsecuredata table 
function addInstData($taskId,$newInst){	
		
		$query="INSERT INTO  lowSecureData  VALUES('$taskId','$newInst')";
		mysql_query($query);
}


//add the task to the database 	
function addNewTask($taskId, $agentId, $dependsOn, $kind, $implementorId,$alg)
	{	
		//sanitizing the parameters we got
		$name = mysql_real_escape_string($agentId);
		$depends = mysql_real_escape_string($dependsOn);
		$kind = mysql_real_escape_string($kind);
		$password = mysql_real_escape_string($implementorId);
		$date = date("Y-m-d H:i:s");
		
		//insert the task into the data base 
		$str="INSERT INTO tasks VALUES (".$taskId.",".$dependsOn.", '$alg','".$kind."', '".$agentId."', '".$implementorId."',NOW(),0)";
		$ans=mysql_query($str);
			

		return $taskId;
	}

//the target to save the cofiguraton file 
$target_path = "tempFiles/";
$target_path = $target_path . basename( $_FILES["uploadedfile"]["name"]); 

$agentId=$_POST["agentIdForShare"]; 
$plugin=$_POST["plugin"];

										
//save the cofiguration file
if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}

//read content form file and delete him 
$myFile = $target_path;
$fh = fopen($myFile, 'r');
$theData = fread($fh,1000);
fclose($fh);
unlink($target_path);

//encode the data in json 
$theData =json_encode(json_decode($theData)); 


//full data to task; 
$dataForTask="{\"pluginName\":\"$plugin\",\"params\":$theData}"; 
$taskId=getTaskId(); 


//add the data and the task ;
addInstData($taskId,$dataForTask);
addNewTask($taskId,$agentId,0, "new inst","nop","");

//close connection 
db_close_conn($con);


?>