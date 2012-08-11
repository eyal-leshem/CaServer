<!-- the page that contain the log of the server , 
 the page supply some filters for filtering the log file --> 
 
<?php 
//chek permission 
chdir("..");
include_once "chekSession.php"; 
if(!chekSession())
	exit("permission denied");

//include the connector for the dB
chdir(".."); 
require_once("dbConnector.php");
$con=db_Open_conn(); 

//go back to home
chdir ("UI");	
chdir("log");  


//get all the agents in the combo box 
function getAgentsOpt(){
	$query= " SELECT  agentId FROM agents" ; 
	return getOptions(mysql_query($query)); 
}

//print mysql answer in option html tag 
//for use it in combobox 
function getOptions($ans){
	
	$next=mysql_fetch_array($ans);
	while($next){
		echo "<option value=\"$next[0]\">$next[0]</option>"; 
		$next=mysql_fetch_array($ans);
		}
}
	
?>

<script type="text/javascript">
$(document).ready(function(){
				
			//when agent change load the relvant implemtors into combobox 
			$("#agentsForLog").change(function() {
									
									agentName=$("#agentsForLog").val();
									impName=$("impForLog").val();
									impForLog=$("#onlyErrors").val()
									
									$("#impForLog").load("getImpWithAll.php?agentId="+agentName) ;
					
							});
			 
			
			
			
			}); 
			
			//when filter chage change the table suitable 
			$(".changeTable").change(function() {
									
					agentName=$("#agentsForLog").val();
					impName=$("#impForLog").val();
					err=$("#onlyErrors").val();
									
					$("#impForLog").load("getImpWithAll.php?agentId="+agentName);
					$("#logTableContent").load("log/loadlogTable.php?agentsForLog="+agentName+"&impForLog="+impName+"&onlyErrors="+err); 
					
			});
			
			//while page load show all table without filters 
			$("#logTableContent").load("log/loadlogTable.php?agentsForLog=all&impForLog=all&onlyErrors=no"); 
			
			
			
			
			
			
</script>




<div id="logForm">
	
	<div class="row">
		<!-- the filter --> 
		<div class="well">
		
			agent:<select  name= "agentsForLog" id="agentsForLog" class="changeTable">
				<option value="all">all</option>
				<?php getAgentsOpt(); ?>
			</select>
			
			implemntor:<select  name="impForLog" id="impForLog" class="changeTable">		
			</select> 
			
			only errors? <select  name="onlyErrors" id="onlyErrors" class="changeTable" >
				<option value="no">no</option>
				<option value="yes">yes</option>
				
			</select> 
			
		</div>
		
	</div>
</div> 

<div id="logTableContent"> 
</div>  

<?php
	//close connection 
	db_close_conn($con);
?>