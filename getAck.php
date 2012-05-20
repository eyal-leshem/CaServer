<?php




	function  saveData($taskId,$data){
			$myFile = "tasksData/".$taskId;
			$fh = fopen($myFile, 'w') or die("can't open file");
			fwrite($fh, $data);				
			fclose($fh);
	}

	$taskId=$_POST["taskId"];
	$agentId=$_POST["agentId"];
	if (in_array($_POST["data"])){ 
		saveData($taskId, $_POST["data"]); 
	} 
	$con=db_Open_conn(); 
	$dbTaskDone($taskId,$agentId); 
	db_close_conn($con); 
	





?>