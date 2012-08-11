<?php

/*
 get all the implementors with this alogrithem 
*/


//open connection to the daata base 
chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");


//selects only the implementors who has an algorithm that was chosen for create key
function getImplementors($ans, $algForShare, $agentId){

	
	$next = mysql_fetch_array($ans);
	
	while($next)
	{
		//get the next implementor 
		$imp = $next[0];				
		
		//get all the alogrithem of this implemntor
		$queryAlgs =  "SELECT algorithm FROM algorithms WHERE agentId='$agentId' AND implementorId='$imp'" ;	 	
		$algsAns = mysql_query($queryAlgs);
								
		//the only authorized type of key pair is X.509 
		if($algForShare!="X.509"){
			
			//start to rin over all the algorithems 
			$nextAlg = mysql_fetch_array($algsAns);
		
			//check if this implementor has the required algorithm
			while($nextAlg)
			{
				//mean it have the required algorithem 
				if(strcmp($nextAlg[0], $algForShare) == 0)
				{
					//and this implemtor and continue 
					echo "<option value=\"$next[0]\">$next[0]</option>"; 
					break; 
				}
				$nextAlg = mysql_fetch_array($algsAns);
			}
		}
		//if it is X.509 add this implemntor 
		else{
			echo "<option value=\"$next[0]\">$next[0]</option>"; 
		}
		
		$next=mysql_fetch_array($ans);
	}//end of while($next)	

}

//get the agentName and the alorithem he need to shar
$agentId=$_GET["agentId"];
$algForShare=$_GET["algForShare"]; 

//get all the relevant implementors 
$query= " SELECT implementorId FROM implementors WHERE agentId='$agentId'" ;
getImplementors(mysql_query($query), $algForShare, $agentId);	

db_close_conn($con);
 

?>