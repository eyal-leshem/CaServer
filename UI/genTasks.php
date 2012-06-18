<?php
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
<div>

<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
$(document).ready(function(){
			$("#agentSelect0").change(function() {
									agentName=$("#agentSelect0").val();
									$("#impSelect0").load("getImp.php?agentId="+agentName) ; 
							});
			 
			
			$("#agentSelect1").change(function() {
									agentName=$("#agentSelect1").val();
									$("#impSelect1").load("getImp.php?agentId="+agentName) ; 
							});
			
			
			$("#agentSelect2").change(function() {
									agentName=$("#agentSelect2").val();
									$("#impSelect2").load("getImp.php?agentId="+agentName) ; 
							});
			 
		
			$("#agentSelect3").change(function() {
									agentName=$("#agentSelect3").val();
									$("#impSelect3").load("getImp.php?agentId="+agentName) ; 
							});
			 
			
			$("#agentSelect4").change(function() {
									agentName=$("#agentSelect4").val();
									$("#impSelect4").load("getImp.php?agentId="+agentName) ; 
							});
			}); 
</script>


<div class="span4">
 <form method="post" action="setDependency.php" class="well">
		
		<!-- agent fot commiting the task -->
		Agent for Create key : <select  name= "agentIdForShare" id="agentSelect0">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		implemntor : <select  name= "implementorId" id="impSelect0">						
					</select> 	
		
		<BR/>
		task:
		<select  name= "task" id="task">
				<option value="generate secret">generate secret</option>	
				<option value="generate key Pair">generate key Pair</option>	
		</select> 
		<BR/> 
		algorithem:<input type = "text" name= "alg"/>
		
		
		<BR/> 
		<BR/><BR/> 
		implemtors for share :
		<BR/><BR/> 
		agent1:<select  name= "1" id="agentSelect1">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		implemntor : <select  name= "imp1" id="impSelect1">						
					</select> 	
		
		<BR/>
		<BR/> 
		
		agent2:<select  name= "2" id="agentSelect2">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		implemntor : <select  name= "imp2" id="impSelect2">						
					</select> 	
		
		<BR/>
		<BR/> 
		
		agent3:<select  name= "3" id="agentSelect3">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		implemntor : <select  name= "imp3" id="impSelect3">						
					</select> 	
		
		<BR/>
		<BR/> 
		
		
		agent4:<select  name= "4" id="agentSelect4">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		implemntor : <select  name= "imp4" id="impSelect4">						
					</select> 	
		
		<BR/>
		<BR/> 
		
		<input type="submit" name="submit"/>
		
		
		
		
  
 
</form> 
</div>
</div> 


<?php
db_close_conn($con);
?>
