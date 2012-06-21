

<?php

if(!strcmp($_GET["dbName"],"")!=0){
	echo "<font color=\"red\">ERROR:date base name must contain value </font>";
}

if(!strcmp($_GET["dbUserName"],"")!=0){
	echo "<font color=\"red\">ERROR:db name must contain value </font>";
}

if(!strcmp($_GET["dbAddress"],"")!=0){
	echo "<font color=\"red\">ERROR:db name must contain value </font>";
}

if(!preg_match("/^[0-9]+$/", $_GET["timeLimit"])){
	echo "<font color=\"red\">ERROR:time limit must to an nubmer </font>";
}

if(!preg_match("/^[0-9]+$/", $_GET["pullsNumBound"])){
	echo "<font color=\"red\">ERROR:time pulls num bound must to be an nubmer </font>";
}

	

$toJson["dbName"]=$_GET["dbName"];
$toJson["timeLimit"]=$_GET["timeLimit"];
$toJson["dbUserName"]=$_GET["dbUserName"];
$toJson["dbAddress"]=$_GET["dbAddress"];
$toJson["pullsNumBound"]=$_GET["pullsNumBound"];

$json=json_encode($toJson);  

chdir("../..");

rename("conf.cnf","conf.old.cnf"); 
$fd=fopen("conf.cnf","w"); 
fwrite($fd,$json); 
fclose($fd);

echo "SUCSSES: chage in success old conf was save in -conf.old.cnf ";  

	

	
  
 
?>