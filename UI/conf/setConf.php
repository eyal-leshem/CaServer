

<?php

//chek  cofiguration's filed not empty empty 
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

	
//get the new configuration 
$toJson["dbName"]=$_GET["dbName"];
$toJson["timeLimit"]=$_GET["timeLimit"];
$toJson["dbUserName"]=$_GET["dbUserName"];
$toJson["dbAddress"]=$_GET["dbAddress"];
$toJson["pullsNumBound"]=$_GET["pullsNumBound"];

//encode it into json 
$json=json_encode($toJson);  

//go to the dir of configuration file
chdir("../..");

//store the old cofiguration - for make it easy to restore 
rename("conf.cnf","conf.old.cnf"); 

//write the new configuration file 
$fd=fopen("conf.cnf","w"); 
fwrite($fd,$json); 
fclose($fd);

//echo sucsses 
echo "SUCSSES: chage in success old conf was save in -conf.old.cnf ";  

	

	
  
 
?>