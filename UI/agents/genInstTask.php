<?php
chdir (".."); 
chdir (".."); 
include_once 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");


function getTaskId(){

		$query=" SELECT MAX(taskId) FROM
							(SELECT taskId From tasks  UNION
							 SELECT taskId From donetasks	UNION	
							 SELECT taskId FROM failedtasks) AS x	"; 
		$ans=mysql_query($query);
		$res = mysql_fetch_array($ans); 

		echo "<BR> task id $res[0] <BR>";
		
		if(is_null($res[0]))
			return 1; 
		else
			return  $res[0]+1; 
	
}

function addInstData($taskId,$newInst){
	
		
		$query="INSERT INTO  lowSecureData  VALUES('$taskId','$newInst')";
		mysql_query($query);
	}
	
function addNewTask($taskId, $agentId, $dependsOn, $kind, $implementorId,$alg)
	{	
		//sanitizing the parameters we got
		$name = mysql_real_escape_string($agentId);
		$depends = mysql_real_escape_string($dependsOn);
		$kind = mysql_real_escape_string($kind);
		$password = mysql_real_escape_string($implementorId);
		$date = date("Y-m-d H:i:s");
		$str="INSERT INTO tasks VALUES (".$taskId.",".$dependsOn.", '$alg','".$kind."', '".$agentId."', '".$implementorId."',NOW(),0)";
		$ans=mysql_query($str);
		echo "<BR> $ans <BR>"; 		

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

$theData =json_encode(json_decode($theData)); 
echo "<BR> $theData <BR>"; 

//full data to task; 
$dataForTask="{\"pluginName\":\"$plugin\",\"params\":$theData}"; 
$taskId=getTaskId(); 



addInstData($taskId,$dataForTask);
addNewTask($taskId,$agentId,0, "new inst","nop","");
























?>