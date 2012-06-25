
<?php
	//chek permission 
	chdir(".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("permission denied");
	 
?>


	
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#serverConf").click(function(){
						$("#confContent").load("conf/uiServerConf.php");
		});	
		
		$("#agentConf").click(function(){
						$("#confContent").load("conf/agentConf.php");
		});

		
		
	});
	</script>
	


<html>
	
	<body>
			<div id="navContainer">
				<div id="navigation">
					<ul class="nav nav-tabs">
						<li id="serverConf"><a href="#">server conf</a></li>
						<li id="agentConf"><a href="#">agent conf</a></li>
											
					</ul>
				</div>
			</div>
			<div id="confContent">
			</div>
	
	
	</body>
</html> 