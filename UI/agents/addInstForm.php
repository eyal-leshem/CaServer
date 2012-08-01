<?php
chdir (".."); 
chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

//chek permission 
include "chekSession.php"; 
if(!chekSession())
	exit("permission denied");
	
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

							$("#agentSelect0").change(function() {
									agentName=$("#agentSelect0").val();
									$("#pluginSelect").load("agents/getPlugins.php?agentId="+agentName) ;
					
							});
				
				});

</script>


<script type="text/javascript">
  /* attach a submit handler to the form */
  $("#newInstForm").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
	var $form = $( this ),
         term = $form.find( 'input[name="s"]' ).val(),
         url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post( url, $(this).serialize(),
      function( data ) {
       
		  alert("task for create new instance where created");
         }
    );
  });
</script>


 <form method="post" id="newInstForm"  action="agents/genInstTask.php" class="well" enctype="multipart/form-data">
		
		<!-- agent fot commiting the task -->
		Agent for Create key : <select  name= "agentIdForShare" id="agentSelect0">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		plugin : <select  name= "plugin" id="pluginSelect">						
					</select> 			
		<BR/>
		
		<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
		cofiguration file:  <input name="uploadedfile" type="file" /><br />
		<input type="submit" value="create intsance" />
		
</form>