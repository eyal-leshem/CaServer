<!-- a form to add new instance of implementor --> 

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
	
	//print all the agenta oprtions 
	function getAgentsOpt(){
		$query= " SELECT  agentId FROM agents" ; 
		return getOptions(mysql_query($query)); 
	}

	//print mysql answer to combobox  
	function getOptions($ans){
		$next=mysql_fetch_array($ans);
		while($next){
			echo "<option value=\"$next[0]\">$next[0]</option>"; 
			$next=mysql_fetch_array($ans);
		}	

	}
	
	


?>
<script type="text/javascript">
//load the plugins that relvant to the implemntors 
$(document).ready(function(){

							$("#agentSelect0").change(function() {
									agentName=$("#agentSelect0").val();
									$("#pluginSelect").load("agents/getPlugins.php?agentId="+agentName) ;
					
							});
				
				});

</script>





 <form method="post" id="newInstForm"  action="agents/genInstTask.php" class="well" enctype="multipart/form-data">
		
		<!-- agent to add him the instance -->
		Agent name : <select  name= "agentIdForShare" id="agentSelect0">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		
		<!--choose the relavat plugin for the new isntance  -->
		plugin : <select  name= "plugin" id="pluginSelect">						
					</select> 			
		<BR/>
		
		<!-- configuration file --> 
		<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
		cofiguration file:  <input name="uploadedfile" type="file" /><br />
		<input type="submit" value="create intsance" />
		
</form>