<?php

function sign_csr($csrData){
	$csrdata=str_ireplace("*#","\r\n",$csrData);

	$jsonData = json_decode(file_get_contents("keyFiles.cnf"), true);
	// We need our CA cert and its private key
	$cacert = "file://".$jsonData["cert"];
	$privkey = "file://".$jsonData["key"];
	$usercert = openssl_csr_sign($csrdata, $cacert, $privkey, 365);
	openssl_x509_export($usercert, $certout);
	return $certout;
}

?>