
<?php

include 'dbConnector.php';

//connect to the mysql server
$con=db_Open_conn();
if (!$con)
{
 die('Could not connect: ' . mysql_error());
}

//get the id of Agent (in POST)
//$agentId = mysql_real_escape_string($_POST["agentId"]);
$agentId = "lalala";

$tasksAr = getTasks($agentId);

$jsonTasks = json_encode($tasksAr);

echo($jsonTasks);

mysql_close($con);






?>

