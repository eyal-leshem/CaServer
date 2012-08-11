<!-- page that give the data abuot choosen agent --> 
<?php 
	
	//secure chek in getAgent.php 
	include "getAgents.php";

?>


<script type="text/javascript">

//load the relvat data of agent when choose 
$(document).ready(function(){
			$("#agentConfChooseAgent").change(function() {
									agentName=$("#agentSelect0").val();
									$("#agentDataContent").load("agents/getAgentDataForm.php?agentId="+agentName) ; 
							});
			});
</script> 


<!-- combo box with all agents --> 
<div id="agentConfChooseAgent">
choose agent : <select  name= "agentIdForShare" id="agentSelect0">
					<option value=""></option>
						<?php getAgentsOpt() ?>
					</select>
</div>

<div id="agentDataContent">
</div> 

<?php
	//close connection 
	db_close_conn($con);
?>