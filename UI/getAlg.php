<?php
chdir (".."); 
include 'dbConnector.php';
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
$impId=$_GET["impId"]; 

$query= " SELECT  algorithm  FROM  algorithms WHERE agentId='$agentId' AND implementorId='$impId'" ;

echo $query."<br>"; 
echo $con."<BR>";  


echo  getOptions(mysql_query($query));	

db_close_conn($con);
 

?>