<?php
/*
	get all the plugin of one implementor 
*/

//open conection to database 
chdir (".."); 
chdir (".."); 
include_once 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

//check the session is ok
include "chekSession.php"; 
	if(!chekSession())
		exit("permission denied");
		
//get all the option in html format for combox 
function getOptions($ans){

	$next=mysql_fetch_array($ans);
	
	while($next){
		echo "<option value=\"$next[0]\">$next[0]</option>"; 
		$next=mysql_fetch_array($ans);
	}	

}

//get the agents id 
$agentId=$_GET["agentId"]; 

//print all the options 
$query= " SELECT  pluginName  FROM  plugins WHERE agentId='$agentId'" ;
echo  getOptions(mysql_query($query));	

//close connection 
db_close_conn($con);
 

?>