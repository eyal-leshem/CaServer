
<?php
	//secure check in getAgents.php
	include "getAgents.php"; 
?>

<script type="text/javascript">
$(document).ready(function(){
			$("#agentConfChooseAgent").change(function() {
									agentName=$("#agentSelect0").val();
									$("#dataAgentConf").load("agents/getAgentForm.php?agentId="+agentName) ; 
							});
			});
</script> 


<div id="agentConfChooseAgent">
choose agent : <select  name= "agentIdForShare" id="agentSelect0">
					<option value=""></option>
						<?php getAgentsOpt() ?>
					</select>
</div>

<div id="dataAgentConf">
	
</div> 