<?php
	//chek permission 
	chdir (".."); 
	
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
		
	//load the data base connector 	
	chdir (".."); 	
	require_once('dbConnector.php');
	if(!isset($con))
		$con=db_Open_conn(); 
	chdir ("UI");
	
	?>
	
	
	<table class="table table-striped">
	<!--table head --> 
	<tr>
	<td><font face="Arial, Helvetica, sans-serif">taskId</font></td>
	<td><font face="Arial, Helvetica, sans-serif">AgentId</font></td>
	<td><font face="Arial, Helvetica, sans-serif">ImplementorId</font></td>
	<td><font face="Arial, Helvetica, sans-serif">failureDate</font></td>
	
	</tr>
	
	<?php
	$ans=getTasks(); 
	
	//print all the rows in the table 
	$row=mysql_fetch_array($ans);
	while($row){
		printRowInTable($row); 
		$row=mysql_fetch_array($ans);
	}
	?> 
	</table> 
	<?php 
	//function to get tasks from the db 
	function getTasks(){
		$query="SELECT * FROM failedtasks"; 
		return mysql_query($query); 
	}
	
	function printRowInTable($row){
?>
	<tr>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["taskId"]; ?></font></td>	
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["agentId"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["implementorId"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["failureDate"]; ?></font></td>
	
	
	</tr>
	
<?php	}
?> 
	

	

	
	

