<?php
/**
 return combo box of all the implemtors 
 and also add the option all 
*/


//include the connector to the database 
chdir (".."); 
include_once 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

//get all the option from sql answer 
function getOptions($ans){
	
	$next=mysql_fetch_array($ans);
	while($next){
		echo "<option value=\"$next[0]\">$next[0]</option>"; 
		$next=mysql_fetch_array($ans);
	}	

}

//get the id of the agents 
$agentId=$_GET["agentId"]; 

//add "all" option 
echo "<option value=\"all\">all</option>";

//print all others options 
$query= " SELECT  implementorId  FROM  implementors WHERE agentId='$agentId'" ;
getOptions(mysql_query($query));	

//close connection 
db_close_conn($con);
 

?>