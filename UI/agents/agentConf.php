
<!-- the page that contain the agent confguration -->

<?php
	//secure check in getAgents.php
	include "getAgents.php"; 
?>

<script type="text/javascript">
//use jQuery to load the form of the relvant agent 
$(document).ready(function(){
			$("#agentConfChooseAgent").change(function() {
									agentName=$("#agentSelect0").val();
									$("#dataAgentConf").load("agents/getAgentForm.php?agentId="+agentName) ; 
							});
			});
</script> 

<!-- combo box to choose agents --> 
<div id="agentConfChooseAgent">
choose agent : <select  name= "agentIdForShare" id="agentSelect0">
					<option value=""></option>
						<?php getAgentsOpt() ?>
					</select>
</div>

<div id="dataAgentConf">
	
</div> 

<?php
//close connection 
	db_close_conn($con);
?>