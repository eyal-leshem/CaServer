
<?php
	//chek permission 
	include "chekSession.php"; 
	if(!chekSession())
		exit("permission denied");
?>


	
<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#queueTasks").click(function(){
						$("#tasksContent").load("tasks/queueTasks.php");
		});	
		
		$("#doneTasks").click(function(){
						$("#tasksContent").load("tasks/doneTasks.php");
		});

		$("#failedTasks").click(function(){
						$("#tasksContent").load("tasks/failedTasks.php");
		});
		
		failureDate
	});
	</script>
	


<html>
	<link rel="stylesheet" type="text/css" href="index.css" />
	<body>
			<div id="navContainer">
				<div id="navigation">
					<ul class="tab">
						<li id="queueTasks" class="active"><a href="#">tasks in queue</a></li>
						<li id="doneTasks"><a href="#">done tasks</a></li>
						<li id="failedTasks"><a href="#">failed tasks</a></li>						
					</ul>
				</div>
			</div>
			<div id="tasksContent">
			</div>
	
	
	</body>
</html> 