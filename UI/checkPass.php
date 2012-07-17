<?php

chdir(".."); 
include "hashPass.php"; 
chdir("UI");  

/**
*this function ask the if we have that usert name and password in our db - with this password 
*/
function dbChekInstallerPassword($name,$password){
	
	$name= mysql_real_escape_string($name); 
	$password= mysql_real_escape_string($password); 
	
	$str="SELECT * FROM permission WHERE username='".$name."'";
	$result=mysql_query($str);
	$row=mysql_fetch_array($result);
	if( isset($row) && isset($row["password"]) && checkEqual($password,$row["password"])){
		return true;
	}
	return false; 
}



function openSession($userName,$password){
	
	session_start();
	
	$_SESSION["LAST_ACTIVITY"] = time();
	$_SESSION["userName"]=$userName; 

	

	
}

echo "loding.." ; 

chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

if(dbChekInstallerPassword($_POST["userName"],$_POST["password"])){
	openSession($_POST["userName"],$_POST["password"]); 
	echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=index.php\">" ; 
}

else {
	echo "<BR><BR><BR><BR>" ; 
	echo "<center>" ; 
	echo "sorry you where type worg user name or password "; 
	echo "<BR>" ; 
	echo "<a href=\"login.php\">back to login page</a>";
	echo "</center>" ; 
}

db_close_conn($con);

//echo $con;
?>