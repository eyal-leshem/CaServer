
<?php
	//check that we are in safe session 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
		
	chdir (".."); 
	require_once("dbConnector.php");
	$con=db_Open_conn(); 
	chdir ("UI");
	
	
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
			$("#agentConfChooseAgent").change(function() {
									agentName=$("#agentSelect0").val();
									$("#dataAgentConf").load("conf/getAgentForm.php?agentId="+agentName) ; 
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