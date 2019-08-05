<?php

function sendSMS($phone_number){
    	// Authorisation details.
	$username = "mahaveer@ssdigitalindia.com";
	$hash = "b258e8a694838c5bbe59f20cc5df97cebd7989ba176853a625f2acca49792270";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "1";

	// Data for text message. This is the text message data.
	$sender = "TXTLCL"; // This is who the message appears to be from.
	$numbers = "91$phone_number"; // A single number or a comma-seperated list of numbers
	$message = "Thank you for choosing SS Digital India. Your order is comfirmed. /n web: www.ssdigitalindia.com";
	// 612 chars or less
	// A single number or a comma-seperated list of numbers
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    
    echo $result;

	curl_close($ch);
}


sendSMS(9818954821);

?>