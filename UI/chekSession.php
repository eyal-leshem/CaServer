
<?php


function chekSession(){

	
	//session_start();
	
	$_SESSION["LAST_ACTIVITY"] = time();
	
	//add the db connector 
	chdir (".."); 
	require_once('dbConnector.php');
	
	//open connection 
	$con=db_Open_conn(); 
	
	//clean old session from db 
	delTimeLimtSession(); 
	
	//go back to our directory 
	chdir ("UI");
	
	//if the user was't in activity in 15 minute destroy the session 
	if($_SESSION["LAST_ACTIVITY"] < time()- 1200){
		session_destroy(); 
		return false; 
	}
	
	//get hashed username and password from session 
	$sUser= $_SESSION["userName"]; 
	$sPass= $_SESSION["password"];
	
	
	//for sql injection 
	$sUser= mysql_real_escape_string($sUser); 
	$sPass= mysql_real_escape_string($sPass);

	//chek if have open session with this user is in this session  
	$query="SELECT * FROM sessions WHERE (userName='$sUser')";
	$ans= mysql_query($query);
 	$row= mysql_fetch_array($ans); 

	//check if the password is correct 
	if($row["password"]==$sPass && $row["id"]==session_id())
		return true; 	
	return false; 
	
}


?>