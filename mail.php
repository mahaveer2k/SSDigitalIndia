<?php

// https://github.com/PHPMailer/PHPMailer/wiki/Using-Gmail-with-XOAUTH2 <= SMTP ERROR: Password command failed:

error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "satyagangacompetitionclasses@gmail.com";
$mail->Password = "satyaganga@12345";
$mail->SetFrom("satyagangacompetitionclasses@gmail.com");
$mail->Subject = "Test";
$mail->Body = "hello";
$mail->AddAddress("satyagangacompetitionclasses@gmail.com");

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }



?>