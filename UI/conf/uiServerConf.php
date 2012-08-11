<!-- page that contain a form with the configurtation of the server and option to change it --> 

<?php
	//check that we are in safe session 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
	

	//add the load configuration function 
	chdir ("..");
	require_once("ServerConf.php");
	
	//load the database configuration 
	$pullsNumBound=loadConf("pullsNumBound"); 
	$dbAddress=loadConf("dbAddress"); 
	$dbUserName=loadConf("dbUserName"); 
	$dbName=loadConf("dbName"); 
	$timeLimit=loadConf("timeLimit"); 
	$dbPassword=loadConf("password");
	
?>

<script type="text/javascript">

	function sendForm(){
		
			formdata=$('#confForm').serialize();		
			$('#confAns').load("conf/setConf.php",formdata);
	}; 
	


	$(document).ready(function(){
		//load the vals into the form of agents 
		$('[name=timeLimit]').val('<?php echo $timeLimit; ?>'); 	
		$('[name=dbName]').val('<?php echo $dbName ; ?> ');
		$('[name=dbUserName]').val('<?php echo $dbUserName ?>');
		$('[name=dbAddress]').val('<?php echo $dbAddress; ?>');
		$('[name=pullsNumBound]').val('<?php echo $pullsNumBound; ?>');
		$('[name=dbPassword]').val('<?php echo $dbPassword ?>');
	});
</script> 

	
<div class="row">
	<div class="span0">
		<p></p>
	</div> 

	<div class="span4">
	<!-- the table with the current content --> 
		<p id="headNewAgentConf">
			current server configuration: <BR>
		</p>
	 
		 <table class="table">
			<tr><td>time limit</td><td><?php echo $timeLimit; ?>  </td></tr>
			<tr><td>data Base Name</td><td><?php echo $dbName ; ?> </td></tr>
			<tr><td>data Base user Name</td><td><?php echo $dbUserName; ?> </td></tr>
			<tr><td>data Base aderss</td><td><?php echo $dbAddress; ?> </td></tr>
			<tr><td>pulls Num Bound</td><td><?php echo $pullsNumBound; ?> </td></tr>
			<tr><td>data base password</td><td><?php echo "*****" ?> </td></tr>
		</table> 
	</div>
	
	<div class="span1">
		<p>  </p>
	</div>
	
	
	<div class="span4"> 
		<!-- the tform with the new contentet --> 
		<p id="headNewAgentConf">
			change server configuration:   <BR>
		</p>


		 <form id="confForm" class="well"  method="get" onSubmit="sendForm();return false;">
			time limit: <input  type="text" name="timeLimit"  /><br />
			data Base Name: <input    type="text" name="dbName" /><br />
			data Base user Name: <input   type="text" name="dbUserName" /><br />
			data Base aderss: <input  type="text" name="dbAddress" /><br />
			pulls Num Bound: <input type="text" name="pullsNumBound" /> <br />
			data base password: <input type="password" name="dbPassword" /> <br />			
			<input type="submit" value="submit" />	
		</form>
	</div>

<div class="row"> 
<div id="confAns"></div>

 