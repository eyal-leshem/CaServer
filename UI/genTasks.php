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
			$("#alg").html("<option value=\"X.509\">X.509</option>");
			$("#serialNumberForm").hide(); 
			$("#agentSelect0").change(function() {
									agentName=$("#agentSelect0").val();
									$("#impSelect0").load("getImp.php?agentId="+agentName) ;
					
							});
			 
			
			$("#agentSelect1").change(function() {
									agentName=$("#agentSelect1").val();
									//$("#impSelect1").load("getImp.php?agentId="+agentName) ; 
									algName=$("#alg").val();
									$("#impSelect1").load("checkAlgForShare.php?agentId="+agentName+"&algForShare="+algName) ;
							});
			
							
			$("#agentSelect2").change(function() {
									agentName=$("#agentSelect2").val();
									//$("#impSelect2").load("getImp.php?agentId="+agentName) ; 
									algName=$("#alg").val();
									$("#impSelect2").load("checkAlgForShare.php?agentId="+agentName+"&algForShare="+algName) ;
							});
			 
		
			$("#agentSelect3").change(function() {
									agentName=$("#agentSelect3").val();
									//$("#impSelect3").load("getImp.php?agentId="+agentName) ; 
									algName=$("#alg").val();
									$("#impSelect3").load("checkAlgForShare.php?agentId="+agentName+"&algForShare="+algName) ;
							});
			 
			
			$("#agentSelect4").change(function() {
									agentName=$("#agentSelect4").val();
									
									//$("#impSelect4").load("getImp.php?agentId="+agentName) ; 
									algName=$("#alg").val();
									$("#impSelect4").load("checkAlgForShare.php?agentId="+agentName+"&algForShare="+algName) ; 
							});
			
			
			$("#taskKind").change(function() {
									kind=$("#taskKind").val();
									$("#alg").hide();
									//alert("imp selected"+agentName+" "+implementorId);
									if("remove certifcate"==kind  || "add to crl"==kind){
										$("#restOfForm").hide(); 
										$("#serialNumberForm").show();
									}
									else{
										$("#serialNumberForm").hide(); 
										$("#restOfForm").show();
										if("generate key Pair"==kind){
											$("#alg").show(); 
											$("#alg").html("<option value=\"X.509\">X.509</option>");
											$("#serialNumberForm").hide(); 
										}
											
										//for loading the algorithm while choosing agent
										if(kind == "generate secret")
										{
											$("#alg").show();
											agentName=$("#agentSelect0").val();
											//get the implementor name chosen
											implementorId = $("#impSelect0").val();
											
											$("#alg").load("getAlg.php?agentId="+agentName+"&impId="+implementorId) ;
											$("#serialNumberForm").hide(); 
										}
										
										
									}
							});
							
			
			}); 
			
			
			
			
</script>


<script>
  /* attach a submit handler to the form */
  $("#impfrom").submit(function(event) {

    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $( this ),
        term = $form.find( 'input[name="s"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post( url, $(this).serialize(),
      function( data ) {
        //  var content = $( data ).find( '#content' );
		  alert("task craeted");
         // $( "#impres" ).empty().append( "<p>new task apeend in succsess</p>" );
      }
    );
  });
</script>



<div class="span4">
 <form method="post" id="impfrom"  action="setDependency.php" class="well">
		
		<!-- agent fot commiting the task -->
		Agent for Create key : <select  name= "agentIdForShare" id="agentSelect0">
			<option value=""></option>
			<?php getAgentsOpt() ?>
		</select>
		<BR>
		<!-- the implmentor that need to cmmit the task commit this task -->
		implementor : <select  name= "implementorId" id="impSelect0">						
					</select> 	
		
		<BR/>
		task:
		<select  name= "task" id="taskKind">
				<option value="generate key Pair">generate key Pair</option>
				<option value="generate secret">generate secret</option>
				<option value="remove certifcate">remove certifcate</option>
				<option value="add to crl">add to crl</option>				
		</select> 
		<BR/>
		
		<!-- the implmentor that need to share the key -->
		<div id="restOfForm">
		algorithm : <select  name= "algorithm" id="alg">						
					</select>
		
		
			<BR/> 
			<BR/><BR/> 
			implementors for share :
			<BR/><BR/> 
			agent1:<select  name= "1" id="agentSelect1">
				<option value=""></option>
				<?php getAgentsOpt() ?>
			</select>
			<BR>
			
		
			implementor : <select  name= "imp1" id="impSelect1">						
						</select> 	
			
			<BR/>
			<BR/> 
			
			agent2:<select  name= "2" id="agentSelect2">
				<option value=""></option>
				<?php getAgentsOpt() ?>
			</select>
			<BR>
			<!-- the implmentor that need to cmmit the task commit this task -->
			implementor : <select  name= "imp2" id="impSelect2">						
						</select> 	
			
			<BR/>
			<BR/> 
			
			agent3:<select  name= "3" id="agentSelect3">
				<option value=""></option>
				<?php getAgentsOpt() ?>
			</select>
			<BR>
			<!-- the implmentor that need to cmmit the task commit this task -->
			implementor : <select  name= "imp3" id="impSelect3">						
						</select> 	
			
			<BR/>
			<BR/> 
			
			
			agent4:<select  name= "4" id="agentSelect4">
				<option value=""></option>
				<?php getAgentsOpt() ?>
			</select>
			<BR>
			<!-- the implmentor that need to cmmit the task commit this task -->
			implementor : <select  name= "imp4" id="impSelect4">						
						</select> 	
			
			<BR/>
		<BR/> 
		</div>
		
		<div id="serialNumberForm">
			serial number : <input type="text" name="serialNumber" />
		
		</div>
		<!-- end of rest of form -->
		<input type="submit" name="submit"/>
		
		
		
		
  
 
</form> 
</div>
	<div id="impres">
	<div>
</div> 


<?php
db_close_conn($con);

?>
