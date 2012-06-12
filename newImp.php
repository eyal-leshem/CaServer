<?php 

//------------------------------//
//----------function's---------// 
//----------------------------//

function dbAddImp($agentId,$impId){
		
		
		//avoid sql injection
		$agentId = mysql_real_escape_string($agentId);
		$impId = mysql_real_escape_string($ImpId);
		
		$query="INSERT INTO implementors VALUES($agentId,$ImpID)";			
		mysql_query($str)
}





//------------------------------//
//------------script-----------// 
//----------------------------//


$agentId=$_POST["agentId"]; 
$impID=$_POST["impId"];  
dbAddImp($agentId,$impId); 



?>