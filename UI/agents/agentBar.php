
<?php
	chdir (".."); 
	//chek permission 
	include "chekSession.php"; 
	if(!chekSession())
		exit("permission denied");
?>


	
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#createIntstance").click(function(){
						$("#agentContent").load("agents/addInstForm.php");
		});	
		
		
	});
	</script>
	


<html>
	
	<body>
			<div id="navContainer">
				<div id="navigation">
					<ul class="nav nav-tabs">
						<li id="createIntstance"><a href="#">create Instance</a></li>								
					</ul>
				</div>
			</div>
			<div id="agentContent">
			</div>
	
	
	</body>
</html> 