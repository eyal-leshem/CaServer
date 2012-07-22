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
		<td><font face="Arial, Helvetica, sans-serif">event</font></td>
		<td><font face="Arial, Helvetica, sans-serif">date</font></td>
		<td><font face="Arial, Helvetica, sans-serif">agent</font></td>
		<td><font face="Arial, Helvetica, sans-serif">implemntor</font></td>	
		<td><font face="Arial, Helvetica, sans-serif">error</font></td>	
	</tr>
	
	<?php 
	
		//get the relvant data
		$agentName=$_GET["agentsForLog"]; 
		$impName=$_GET["impForLog"]; 
		$onlyErrors=$_GET["onlyErrors"];
		
		
	
		//build the query 
		$query="SELECT * FROM serverlog WHERE 1";  
		
		if($agentName!="all"){
			$query=$query." AND agent='$agentName'"; 			
		}
	
		if($agentName!="all" && $impName!="all"){
			$query=$query." AND implemntor='$impName'";  
			
		}
		
		if($onlyErrors=="yes"){
			$query=$query." AND error=1"; 
		}
		
		$ans=mysql_query($query);
		
		//print all the rows in the table 
		$row=mysql_fetch_array($ans);
		while($row){
			printRowInTable($row); 
			$row=mysql_fetch_array($ans);
		}
		
	//build dynamicly the function 	
	function printRowInTable($row){
?>
	<tr>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["event"]; ?></font></td>	
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["eventDate"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["agent"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php echo $row["implemntor"]; ?></font></td>
	<td><font face="Arial, Helvetica, sans-serif"><?php  if($row["error"]==0) echo "NO"; else echo "YES";?></font></td>
	</tr>
	
<?php	}
?> 
</table>
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	