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
		
		
		//check if this implementor has the required algorithm
		while($nextAlg)
		{
			if(strcmp($nextAlg[0], $algForShare) == 0)
			{
				echo "<option value=\"$next[0]\">$next[0]</option>"; 
			}
			$nextAlg = mysql_fetch_array($algsAns);
		}
		
		
		$next=mysql_fetch_array($ans);
	}	

}

$agentId=$_GET["agentId"];
$algForShare=$_GET["algForShare"]; 

$query= " SELECT implementorId FROM implementors WHERE agentId='$agentId'" ;

echo $query."<br>"; 
echo $con."<BR>"; 

echo  getImplementors(mysql_query($query), $algForShare, $agentId);	

db_close_conn($con);
 

?>