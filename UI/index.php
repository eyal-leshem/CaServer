<html>
<meta http-equiv="refresh" content="600">
<?php
//include the check session 
include 'chekSession.php'; 
if (!chekSession()){
	echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=disconect.html\">" ; 
}	
?>
	<!-- link rel="stylesheet" type="text/css" href="index.css" / -->  
	<link  rel="stylesheet" type="text/css" href="boot/docs/assets/css/bootstrap.css" />
	<script type="text/javascript" src="jquery-1.7.2.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#taskPage").click(function(){
									$("#content").load("genTasks.php");
								});
								
			$("#oldTask").click(function(){
									$("#content").load("tasksBar.php");
								});
								
			$("#confPage").click(function(){
									$("#content").load("conf/confBar.php");
								});
								
			$("#addUser").click(function(){
									$("#content").load("addUser.php");
								});
								
			$("#log").click(function(){
									$("#content").load("log/serverLog.php");
								});
			$("#agentPage").click(function(){
									$("#content").load("agents/agentBar.php");
								});
	});
	</script>
	
	
	<body>
		<div id="masthead">
			
			<!-- the tab bar -->
			<div id="navContainer">
				<div id="navigation">
					<ul class="nav nav-tabs">
						<li id="taskPage"><a href="#">genrate tasks</a></li>
						<li id="oldTask"><a href="#">old tasks data</a></li>
						<li id="agentPage"><a href="#">agents data</a></li>
						<li id="confPage"><a href="#">configuration</a></li>
						<li id="log"><a href="#">server log</a></li>
						<li id="addUser"><a href="#">add User</a><li>
					</ul>
				</div>
			</div>
			
			<!-- the relvant content in the tab bar -->
			<div id="content">
			</div> 
			
		</div>	
	</body> 
	


</html> 
