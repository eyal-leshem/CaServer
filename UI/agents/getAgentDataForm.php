<?php 

	//check that this is a register user 
	chdir (".."); 
	include "chekSession.php"; 
	if(!chekSession())
		exit("<BR><BR> permission denied<BR><BR>try login agin in <a href=\"login.php\"> login page </a>");
	
	//open connection to DB 
	chdir (".."); 
	require_once("dbConnector.php");
	$con=db_Open_conn(); 
	chdir ("UI");
		
	//get agent name	
	$agentId=$_GET["agentId"]; 
	
	//get the dates about the agents 
	$query="SELECT  * FROM agents WHERE agentId='$agentId'"; 
	$ans=mysql_query($query);
	$ansArr=mysql_fetch_array($ans); 
	
	//save it in php variable 
	$regDate=$ansArr[2];
	$lastConn=$ansArr[1]; 
	
	$query="SELECT pluginName FROM plugins WHERE agentId='$agentId'"; 
	$pluginRsc=mysql_query($query);
	
	$query="select implementorId from implementors WHERE agentId='$agentId'"; 
	$impRsc=mysql_query($query);
	
	
?> 


<div class="row">	
	<div class="span3">
		<dl class="well">

		  <dt>agent register date:</dt>
		  <dd> <?php echo $regDate ?>  </dd>
		  <dt>agent last connection date</dt>
		  <dd>  <?php echo $lastConn?></dd>

		</dl>
	</div> 


	<div class="span4">
		
			<table class="table table-bordered"">
				<!--table head --> 
				<tr>
						<td><b>plugins</b></td>
				</tr>
				<?php
					$row=mysql_fetch_array($pluginRsc);
					while($row){
						$pluginName=$row[0]; 						
				?> 				
						<tr>
								<td><font ><?php echo $pluginName; ?></font></td>
						</tr>				
				<?php
						$row=mysql_fetch_array($pluginRsc);
				  }
				?>
				
				
				
				
			</table>

	</div>
	
	
	<div class="span4">
		
			<table class="table table-bordered"">
				<!--table head --> 
				<tr>
						<td><b>implmentors</b></td>
				</tr>
				<?php
					$row=mysql_fetch_array($impRsc);
					while($row){
						$impName=$row[0]; 						
				?> 				
						<tr>
								<td><font ><?php echo $impName; ?></font></td>
						</tr>				
				<?php
						$row=mysql_fetch_array($impRsc);
				  }
				?>
				
				
				
				
			</table>

	</div>

</div>

















