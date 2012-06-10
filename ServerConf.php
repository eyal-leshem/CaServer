<?php


/**
 * Method for loading the data from conf file, decrypting it
 * 
 */
function loadConf($request)
{
	
	$jsonData = json_decode(file_get_contents("conf.cnf"), true);
	
	return $jsonData[$request];
	
}


?>