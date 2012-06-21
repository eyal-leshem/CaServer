

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

<script type="text/javascript">

	function sendForm(){
		
			formdata=$('#confForm').serialize();		
			$('#confAns').load("conf/setConf.php",formdata);
	}; 
	


	$(document).ready(function(){
		$('[name=timeLimit]').val('<?php echo $timeLimit; ?>'); 	
		$('[name=dbName]').val('<?php echo $dbName ; ?> ');
		$('[name=dbUserName]').val('<?php echo $dbUserName ?>');
		$('[name=dbAddress]').val('<?php echo $dbAddress; ?>');
		$('[name=pullsNumBound]').val('<?php echo $pullsNumBound; ?>');
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

<div class="span4">
 <form id="confForm" class="well"  method="get" onSubmit="sendForm();return false;">
	time limit: <input  type="text" name="timeLimit"  /><br />
	data Base Name: <input    type="text" name="dbName" /><br />
	data Base user Name: <input   type="text" name="dbUserName" /><br />
	data Base aderss: <input  type="text" name="dbAddress" /><br />
	pulls Num Bound: <input type="text" name="pullsNumBound" /> <br /> 
	<input type="submit" value="submit" />	
</form>
</div>
<div id="confAns"></div>

 