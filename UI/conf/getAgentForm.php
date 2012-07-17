<?php



	function getConf($agentId){
		$query="SELECT agentConf FROM agentsconf where agentId = '$agentId'"; 
		$ans=mysql_query($query);
		$asArr=mysql_fetch_array($ans); 
		
		return $asArr[0]; 
		
	}

	//check that we are in safe session 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
		
	chdir (".."); 
	require_once("dbConnector.php");
	$con=db_Open_conn(); 
	chdir ("UI");

	$agentId=$_GET["agentId"];
	$conf=json_decode(getConf($agentId),true);  			
	
?>

<script type="text/javascript">

	


	$(document).ready(function(){
		
		$('[name=sleepTime]').val('<?php echo $conf["sleepTime"]; ?>'); 	
		$('[name=urlSendAck]').val('<?php echo $conf["urlSendAck"];  ?>');
		$('[name=urlNewImplemtor]').val('<?php echo $conf["urlNewImplemtor"];?>');
		$('[name=urlPullTask]').val('<?php echo $conf["urlGetTask"]; ?>');
		
	});
</script> 


<script>
  /* attach a submit handler to the form */
  $("#confForm").submit(function(event) {

 
    /* stop form from submitting normally */
    event.preventDefault(); 
        
	var $form = $( this ),
         term = $form.find( 'input[name="s"]' ).val(),
         url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post( url, $(this).serialize(),
      function( data ) {
       
		  alert("new task where created");
         }
    );
  });
</script>

	
<div class="row">
	<div class="span0">
		<p></p>
	</div> 

	<div class="span6">
  
		<p id="ImpNowConf">
			now agents conf: <BR>
			
		</p>
		
		 <table class="table">
			<tr><td>sleep time (btween ask the server for tasks) </td><td><?php echo $conf["sleepTime"]; ?>  </td></tr>
			<tr><td>url for Send Ack</td><td><?php echo $conf["urlSendAck"]; ?> </td></tr>
			<tr><td>url for add New Implemtor</td><td><?php echo $conf["urlNewImplemtor"]?> </td></tr>
			<tr><td>url for pull tasks</td><td><?php echo $conf["urlGetTask"]; ?> </td></tr>
			
		</table> 
	</div>
	
	<div class="span1">
		<p>  </p>
	</div>
	
	
	<div class="span6"> 
		<p id="headNewAgentConf">
			change server configuration:   <BR>
		</p>


		 <form id="confForm" class="well"  method="post" action="conf/genUpdateTask.php?agentId=<?php echo $agentId ?>">
			sleep time: <input  type="text" name="sleepTime"  /><br />
			url for Send Ack: <input    type="text" name="urlSendAck" /><br />
			url for add New Implemtor: <input   type="text" name="urlNewImplemtor" /><br />
			url for pull tasks: <input  type="text" name="urlPullTask" /><br />
			
			<input type="submit" value="submit" />	
		</form>
	</div>

<div class="row"> 
<div id="confAgentAns"></div>
	
	
	
