<?php

/**
	create option for combobox of all the  algortihems 
	of spesfic implmentors 
*/


//open conecttion to the data base 
chdir (".."); 
include 'dbConnector.php';
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

//the agent name implementor id 
$agentId=$_GET["agentId"];
$impId=$_GET["impId"]; 

//run the sql query 
$query= " SELECT  algorithm  FROM  algorithms WHERE agentId='$agentId' AND implementorId='$impId'" ;
echo  getOptions(mysql_query($query));	

//close the connection 
db_close_conn($con);
 

?>