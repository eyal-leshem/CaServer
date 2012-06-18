

<?php
chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

function getAgents(){

	$query= " SELECT  agentId FROM agents" 
	return mysql_query($query); 
}


?>

 <form method="post" action="https://localhost/MA/setDependency.php">

		Cereator: <select  name= "agentIdForShare"/>
		<?php 
			$agents=getAgents();
			$next=mysql_fetch_array($agents);
			while($next){
				echo "<option value=\"$next[0]\">$next[0]</option>"
				$next=mysql_fetch_array($agents);
				
			}			
		?>
		</select><BR><BR> 
  
 
</form> 


<?php
db_close_conn($con);
?>