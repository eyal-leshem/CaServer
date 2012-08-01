<?php
	 
	 include 'dbConnector.php';
	 
	 $con=db_Open_conn();
	 
	 //it's work!
	 echo "walla"; 
	 
	 $name=$_GET["name"]; 
	 
	 //insert this name into the agents table 
	 $query="INSERT INTO agents  VALUES ('".$name."',NOW(),NOW())";
	 mysql_query($query); 
	 
	 //delete this impelmntor from the inReg table
	 $query="DELETE FROM inReg WHERE agentId='$name'";
	 mysql_query($query); 
	 
	 $timelimit=time()-60; 
	 
	 $query="DELETE FROM inReg WHERE connTime < $timelimit"; 
	 mysql_query($query);
	 
	 
	db_close_conn($con); 
 



?>