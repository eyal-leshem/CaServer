<?php

/*
	this file contain function to check username and password 
	during entry to the web site  
*/

//include the moudle that check the hash on the password 
chdir(".."); 
include "hashPass.php"; 
chdir("UI");  

/**
*this function ask the if we have that usert name and password in our db - with this password 
* is ok - return true , else return false 
*/
function dbChekInstallerPassword($name,$password){
	
	//avoid sql injection 
	$name= mysql_real_escape_string($name); 
	$password= mysql_real_escape_string($password); 
	
	//get the user name from the database 
	$str="SELECT * FROM permission WHERE username='".$name."'";
	$result=mysql_query($str);
	$row=mysql_fetch_array($result);
	
	//check the password equals 
	if( isset($row) && isset($row["password"]) && checkEqual($password,$row["password"])){
		return true;
	}
	return false; 
}


/*
	stats session and save there the username 
*/
function openSession($userName,$password){
	
	session_start();
	
	$_SESSION["LAST_ACTIVITY"] = time();
	$_SESSION["userName"]=$userName; 	

	
}

echo "loding.." ; 


//open connection to the database 
chdir (".."); 
include 'dbConnector.php';
$con=db_Open_conn(); 
chdir ("UI");

//if the password and the username is ok open session for this user
//and redirect him into the web page 
if(dbChekInstallerPassword($_POST["userName"],$_POST["password"])){
	openSession($_POST["userName"],$_POST["password"]); 
	echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=index.php\">" ; 
}

//not good password 
else {
	echo "<BR><BR><BR><BR>" ; 
	echo "<center>" ; 
	echo "sorry you where type worg user name or password "; 
	echo "<BR>" ; 
	echo "<a href=\"login.php\">back to login page</a>";
	echo "</center>" ; 
}

//close connection to database 
db_close_conn($con);

?>