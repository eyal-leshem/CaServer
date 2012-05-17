<?php

function sign_csr($csrData){
	$csrdata=str_ireplace("*#","\r\n",$csrData); 
	// We need our CA cert and its private key
	$cacert = "file://C:/Program Files/Apache Software Foundation/Apache2.2/cert/CA/cafesoftCa.crt";
	$privkey = "file://C:/Program Files/Apache Software Foundation/Apache2.2/cert/CA/cafesoftCa.key";
	$usercert = openssl_csr_sign($csrdata, $cacert, $privkey, 365);
	openssl_x509_export($usercert, $certout);
	return $certout;
}

?>