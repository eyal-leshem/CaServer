<?php 
/*
	contain function for combox with the names of the agents  
*/

	//=check the user is authorized 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
		
	//open coneection to databse 	
	chdir (".."); 
	require_once("dbConnector.php");
	$con=db_Open_conn(); 
	chdir ("UI");

	//print all the agnet in the server into combobox 
	function getAgentsOpt(){
		$query= " SELECT  agentId FROM agents" ; 
		return getOptions(mysql_query($query)); 
	}



	//print mysql answer in combobox html formt 
	function getOptions($ans){
	
		$next=mysql_fetch_array($ans);
		while($next){
			echo "<option value=\"$next[0]\">$next[0]</option>"; 
			$next=mysql_fetch_array($ans);
		}
	}

	
?>