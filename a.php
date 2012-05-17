<?php
//TODO debug
//aa
include 'dbConnector.php';
include 'MyKeyTool.php';
 // Let's assume that this script is set to receive a CSR that has
// been pasted into a textarea from another page

$jasonStr=$GLOBALS[HTTP_RAW_POST_DATA];
$con=db_Open_conn(); 
$data=json_decode($jasonStr,true,2000);
if (dbChekInstallerPassword($data[name], $data[password], $con)) {
	$certout=sign_csr($data[csr]);
	if ($certout) {
		echo $certout;
		dbAddNewAgent($data[name],$data[implementors]);
	} 
	
}







?>