<?php 
include 'dbConnector.php';
//------------------------------//
//----------function's---------// 
//----------------------------//

function dbAddImp($agentId, $impId){
		
		
		//avoid sql injection
		$agentId = mysql_real_escape_string($agentId);
		$impId = mysql_real_escape_string($impId);
	
		
		$query="INSERT INTO plugins VALUES('$agentId','$impId')";		
		echo $query; 
		mysql_query($query);
		
		
		
		
	
}





//------------------------------//
//------------script-----------// 
//----------------------------//

$con=db_Open_conn();

//get the data the request 
$agentId=$_POST["agentId"]; 
$impID=$_POST["impId"]; 

 
//ad the new implemtor  
dbAddImp($agentId,$impID, $algs); 
addToserverLog("new implenetor - $impID ,for agent -$agentId ",$agentId,$impID,false);	

//close the connection 
db_close_conn($con); 

?>