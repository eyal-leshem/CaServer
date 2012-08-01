<?php 
	
	//secure chek in getAgent.php 
	include "getAgents.php";
	
	
		


?>


<script type="text/javascript">
$(document).ready(function(){
			$("#agentConfChooseAgent").change(function() {
									agentName=$("#agentSelect0").val();
									$("#agentDataContent").load("agents/getAgentDataForm.php?agentId="+agentName) ; 
							});
			});
</script> 


<div id="agentConfChooseAgent">
choose agent : <select  name= "agentIdForShare" id="agentSelect0">
					<option value=""></option>
						<?php getAgentsOpt() ?>
					</select>
</div>

<div id="agentDataContent">
</div> 