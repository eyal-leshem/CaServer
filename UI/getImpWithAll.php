<?php
chdir (".."); 
include_once 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

function getOptions($ans){

	
	$next=mysql_fetch_array($ans);
	while($next){
		echo "<option value=\"$next[0]\">$next[0]</option>"; 
		$next=mysql_fetch_array($ans);
	}	

}

$agentId=$_GET["agentId"]; 


$query= " SELECT  implementorId  FROM  implementors WHERE agentId='$agentId'" ;

echo "<option value=\"all\">all</option>";
 getOptions(mysql_query($query));	

db_close_conn($con);
 

?>