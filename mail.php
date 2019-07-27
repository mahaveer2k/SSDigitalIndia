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

function sendInvoice($email ){

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
// $mail->Host = "smtp.gmail.com";
$mail->Host = "smtpout.secureserver.net";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "no-reply@ssdigitalindia.com";
$mail->Password = "Bhilwara@1234";
$mail->SetFrom("no-reply@ssdigitalindia.com");
$mail->Subject = "INVOICE- SS Digital India";
$html = '<p style="text-align: center; ">'.
 '<img src="data:image/png;base64,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" data-filename="SS_Digital_India_logo.png" style="width: 25%;"></p>'.
 '<p style="text-align: center; ">'.
  '<br></p><h2 style="text-align: center; "><b>Thank You for your order, Akshay Rana.</b></h2><h3 style="text-align: center; ">Here is your confirmation for order number.</h3><p style="text-align: center;">    <br></p><p style="text-align: center;">    <br></p><p style="text-align: center;">    <br></p><table class="table table-bordered" style="text-align: left;">    <tbody>        <tr>            <td style="text-align: center; "><b style="color: rgb(255, 156, 0);">Image Size</b></td>            <td style="text-align: center; "><b>Quantity</b></td>            <td style="text-align: center; "><b>Rate</b></td>            <td style="text-align: center; "><b style="color: rgb(57, 123, 33);">Total Price</b></td> </tr>'.
        
  '<tr>
            <td style="text-align: left;">
                <br>
            </td>
            <td style="text-align: left;">
                <br>
            </td>
            <td style="text-align: left;">
                <br>
            </td>
            <td style="text-align: left;">
                <br>
            </td>
        </tr>
    </tbody>
</table>
<p style="text-align: left;">
    <br>
</p>
<p style="text-align: left;">
    <br>
</p>
<p>
    <br>
</p>';


$mail->msgHTML($html);
$mail->Body = "Thanks You for choosing SS Digital India. Your order id is";
$mail->AddAddress("akshaybhati28@gmail.com");

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }

}





?>