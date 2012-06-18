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
	
	
	<table border="1" cellspacing="2" cellpadding="2">
	<!--table head --> 
	<tr>
	<td><font face="Arial, Helvetica, sans-serif">taskId</font></td>
	<td><font face="Arial, Helvetica, sans-serif">dependOn<font></td>
	<td><font face="Arial, Helvetica, sans-serif">alg</font></td>
	<td><font face="Arial, Helvetica, sans-serif">kind</font></td>
	<td><font face="Arial, Helvetica, sans-serif">AgentId</font></td>
	<td><font face="Arial, Helvetica, sans-serif">ImplementorId</font></td>
	<td><font face="Arial, Helvetica, sans-serif">commandDate</font></td>
	<td><font face="Arial, Helvetica, sans-serif">pullNum</font></td>
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
		$query="SELECT * FROM tasks"; 
		return mysql_query($query); 
	}
	
	function printRowInTable($row){
?>
	<tr>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["taskId"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["dependOn"]; ?><font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["alg"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["kind"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["AgentId"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["ImplementorId"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["commandDate"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["pullNum"]; ?></font></td>
	
	</tr>
	
<?php	}
?> 
	

	

	
	

