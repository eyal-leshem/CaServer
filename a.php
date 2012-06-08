<?php
//TODO debug
//aa
include 'dbConnector.php';
include 'MyKeyTool.php';
 // Let's assume that this script is set to receive a CSR that has
// been pasted into a textarea from another page
echo "was here\n"; 
//$jasonStr=$GLOBALS[HTTP_RAW_POST_DATA];

$con=db_Open_conn(); 
$data=json_decode($jasonStr,true,2000);


if (dbChekInstallerPassword($data["name"], $data["password"], $con)) {	
	$certout=sign_csr($_POST["csr"]);
	if ($certout) {
		if(dbAddNewAgent($_POST["name"],$_POST["implementors"])==false){
			echo "agent name is not free"; 
			$msg = "anoher agent with name ".$_POST["name"]." try to register"; 
			addToserverLog($msg,$_POST["name"],$_POST["name"],true); 
				
		}
		else{
			addToserverLog("new agent register",$_POST["name"],$_POST["name"],false);
			echo $certout;
		}
	} 
	
}
else {
	$msg="installer with name ".$data["name"]." type worng password"; 
	addToserverLog($msg,$_POST["name"],$_POST["name"],true); 
}

db_close_conn($con); 







?>