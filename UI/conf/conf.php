

<?php
	//check that we are in safe session 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
		
	chdir ("..");
	require_once("ServerConf.php");
	
	
	$pullsNumBound=loadConf("pullsNumBound"); 
	$dbAddress=loadConf("dbAddress"); 
	$dbUserName=loadConf("dbUserName"); 
	$dbName=loadConf("dbName"); 
	$timeLimit=loadConf("timeLimit");  
	
?>

<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
						$('#target').submit(function() {
							$('#id').post("conf/setConf.php", )
						});
	});
</script> 

	<table border="1" cellspacing="2" cellpadding="2">
	 
	 <p id="headNewAgentConf">
	 now agents conf:   <BR>
	 </p>
	 
	 <table border="1" cellspacing="2" cellpadding="2">
		<tr><td>time limit</td><td><?php echo $timeLimit; ?>  
		<tr><td>data Base Name</td><td><?php echo $dbName ; ?> 
		<tr><td>data Base user Name</td><td><?php echo $dbUserName; ?> 
		<tr><td>data Base aderss</td><td><?php echo $dbAddress; ?> 
		<tr><td>pulls Num Bound</td><td><?php echo $pullsNumBound; ?> 
	</table> 
	
	
	<BR><BR><BR><BR> 
	
	 <p id="headNewAgentConf">
		change server configuration:   <BR>
	 </p>


 <form method="post">
	time limit: <input type="text" name="timeLimit" /><br />
	data Base Name: <input type="text" name="dbName" /><br />
	data Base user Name: <input type="text" name="dbUserName" /><br />
	data Base aderss: <input type="text" name="dbAddress" /><br />
	pulls Num Bound: <input type="password" name="pullsNumBound" /> <br /> 
	<input type="submit" value="Submit" />	
</form>

<div id="ans"></div> 
 