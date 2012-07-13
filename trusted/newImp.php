<?php 
include 'dbConnector.php';
//------------------------------//
//----------function's---------// 
//----------------------------//

function dbAddImp($agentId, $impId, $algs){
		
		
		//avoid sql injection
		$agentId = mysql_real_escape_string($agentId);
		$impId = mysql_real_escape_string($impId);
		$algorithms = mysql_real_escape_string($algs);
		
		$query="INSERT INTO implementors VALUES('$agentId','$impId')";		
		echo $query; 
		mysql_query($query);
		
		//now store the algorithms
		$algList = explode(",", $algorithms);
		
		foreach ($algList as &$alg) 
		{
			$query="INSERT INTO algorithms VALUES('$agentId','$impId','$alg')";
			mysql_query($query);
		}
}





//------------------------------//
//------------script-----------// 
//----------------------------//

$con=db_Open_conn();
$agentId=$_POST["agentId"]; 
$impID=$_POST["impId"]; 
$algs=$_POST["algs"];  
dbAddImp($agentId,$impID, $algs); 
db_close_conn($con); 

?>