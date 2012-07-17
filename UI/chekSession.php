
<?php


function chekSession(){

	
	session_start();
	
	//check this is authenticate user 
	if( (!isset($_SESSION["LAST_ACTIVITY"])) || (!isset($_SESSION["userName"]))  ) {
		return false; 
	}
	

	
	//if the user was't in activity in 15 minute destroy the session 
	if($_SESSION["LAST_ACTIVITY"] < time()- 1200){
		session_destroy(); 
		return false; 
	}
	else{
		$_SESSION["LAST_ACTIVITY"] = time() ; 
	}
	
	return true; 
	
}


?>