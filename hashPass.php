<?php

define('SALT_LENGTH', 9);

function generateHash($plainText, $salt = null)
{
    if ($salt === null)
    {
        $salt = substr(uniqid(rand(), true), 0, SALT_LENGTH);
    }
    else
    {
        $salt = substr($salt, 0, SALT_LENGTH);
    }

    return $salt . hash("sha256",$salt . $plainText);
}

function checkEqual($password,$hashPassword){

	$salt = substr($hashPassword, 0, SALT_LENGTH);	
	
	$hashed=substr($hashPassword,SALT_LENGTH);
	
	$toHash=$salt.$password;
	
	echo $salt; 
	echo "<BR>" ; 
	echo $hashPassword; 
	echo "<BR>" ; 
	echo "new hash: <BR>";  
	echo hash("sha256",$toHash); 
	echo "<BR>" ; 
	echo "old hash: <BR>"; 
	echo $hashed; 
	echo "<BR>" ;
	
	if(strcmp(hash("sha256",$toHash),$hashed)==0){
		return true; 
	}
	
	return false; 
	
	
	
	
}





?>