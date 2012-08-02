<?php
chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");


//selects only the implementors who has an algorithm that was chosen for create key
function getImplementors($ans, $algForShare, $agentId){

	
	$next = mysql_fetch_array($ans);
	
	while($next)
	{
		$imp = $next[0];
		
		
		
		$queryAlgs =  "SELECT algorithm FROM algorithms WHERE agentId='$agentId' AND implementorId='$imp'" ;
		
		echo $queryAlgs."<br>"; 
		echo $con."<BR>"; 
		
		$algsAns = mysql_query($queryAlgs);
		
		$nextAlg = mysql_fetch_array($algsAns);
		
		
		//the only authorized type form key pair is X.509 
		if($algForShare!="X.509"){
			
			//check if this implementor has the required algorithm
			while($nextAlg)
			{
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

$agentId=$_GET["agentId"];
$algForShare=$_GET["algForShare"]; 

$query= " SELECT implementorId FROM implementors WHERE agentId='$agentId'" ;


getImplementors(mysql_query($query), $algForShare, $agentId);	

db_close_conn($con);
 

?>