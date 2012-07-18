
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

function getAgentsOpt(){
	$query= " SELECT  agentId FROM agents" ; 
	return getOptions(mysql_query($query)); 
}




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
						
			$("#agentsForLog").change(function() {
									
									agentName=$("#agentsForLog").val();
									impName=$("impForLog").val();
									impForLog=$("#onlyErrors").val()
									
									$("#impForLog").load("getImpWithAll.php?agentId="+agentName) ;
					
							});
			 
			
			
			
			}); 
			
			$(".changeTable").change(function() {
									
					agentName=$("#agentsForLog").val();
					impName=$("#impForLog").val();
					err=$("#onlyErrors").val();
									
					$("#impForLog").load("getImpWithAll.php?agentId="+agentName);
					$("#logTableContent").load("log/loadlogTable.php?agentsForLog="+agentName+"&impForLog="+impName+"&onlyErrors="+err); 
					
			});
			
			$("#logTableContent").load("log/loadlogTable.php?agentsForLog=all&impForLog=all&onlyErrors=no"); 
			
			
			
			
			
			
</script>




<div id="logForm">
	
	<div class="row">
		
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