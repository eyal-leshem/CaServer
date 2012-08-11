<?php

define('SALT_LENGTH', 9);

//
function generateHash($plainText, $salt = null)
{
	//get random string in require length
    if ($salt === null)
    {
        $salt = substr(uniqid(rand(), true), 0, SALT_LENGTH);
    }
    else
    {
        $salt = substr($salt, 0, SALT_LENGTH);
    }

	//add it to the password and genrate the hashes password 
    return $salt . hash("sha256",$salt . $plainText);
}


//check that the password and the hashed password 
// are same in  the src 
function checkEqual($password,$hashPassword){

	//take the random number from the hashed password
	$salt = substr($hashPassword, 0, SALT_LENGTH);	
	
	//get the hashed part 
	$hashed=substr($hashPassword,SALT_LENGTH);
	
	//add the random number to the unhashed password 
	$toHash=$salt.$password;
	
	//make hash and compere 
	if(strcmp(hash("sha256",$toHash),$hashed)==0){
		return true; 
	}
	
	return false; 
	
	
	
	
}





?>