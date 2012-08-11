<!-- the bar with the list of the agents --> 

<?php
	chdir (".."); 
	//chek permission 
	include "chekSession.php"; 
	if(!chekSession())
		exit("permission denied");
?>


	
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
	
	//use jQuuery to load the relvant tab 
	$(document).ready(function(){
		$("#createIntstance").click(function(){
						$("#agentContent").load("agents/addInstForm.php");
		});	
		
		$("#agentConf").click(function(){
						$("#agentContent").load("agents/agentConf.php");
		});	
		
		$("#agentData").click(function(){
						$("#agentContent").load("agents/agentData.php");
		});	
		
		
	});
	</script>
	


<html>
	
	<body>
			<div id="navContainer">
				<div id="navigation">
					<!-- the list of the tabs of the agents-->
					<ul class="nav nav-tabs">
						<li id="createIntstance"><a href="#">create implementor Instance</a></li>
						<li id="agentConf"><a href="#">configure agent</a></li>		
						<li id="agentData"><a href="#">agent data</a></li> 						
					</ul>
				</div>
			</div>
			<div id="agentContent">
			</div>
	
	
	</body>
</html> 