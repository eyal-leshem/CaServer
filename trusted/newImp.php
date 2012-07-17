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

//get the data the request 
$agentId=$_POST["agentId"]; 
$impID=$_POST["impId"]; 
$algs=$_POST["algs"];
 
//ad the new implemtor  
dbAddImp($agentId,$impID, $algs); 
addToserverLog("new implenetor - $impID ,for agent -$agentId ",$agentId,$impID,false);	

//close the connection 
db_close_conn($con); 

?>