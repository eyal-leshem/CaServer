<?php
//TODO debug

include 'dbConnector.php';
include 'MyKeyTool.php';

$jasonStr=$_POST[json];
$con=db_Open_conn(); 
$data=json_decode($jasonStr,true,2000);
if (dbChekInstallerPassword($data[name], $data[password], $con)) {
	$certout=sign_csr($_POST[csr]);
	if ($certout) {
		echo $certout;
		dbAddNewAgent($data[name],$data[implementors]);
	} 
	
}

db_close_conn($con); 







?>