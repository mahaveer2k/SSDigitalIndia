<?php

// https://github.com/PHPMailer/PHPMailer/wiki/Using-Gmail-with-XOAUTH2 <= SMTP ERROR: Password command failed:

// error_reporting(-1);
// ini_set('display_errors', 'On');
// set_error_handler("var_dump");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


function sendInvoice($orderIDMail){
  
   
$rates = '{

   "03.00" :"3.5 x 5",
   "06.00" : "4 x 6",
   "08.00" : "5 x 7",
   "10.00" : "6 x 8",
   "15.00" : "8 x 10",
   "20.00" : "8 x 12",
   "25.00" : "10 x 12",
   "30.00" : "12 x 15",
   "35.00" : "12 x 18",
   "40.00" : "12 x 24",
   "50.00" : "12 x 36",
   "60.00" : "16 x 20",
   "80.00" : "20 x 24",
   "150.00" : "20 x 30",
   "180.00" : "24 x 36",
   "200.00" : "30 x 40",
   "32" : "passport"
 
 
 }';

 $rateJson = json_decode( $rates, true );

echo "orderIDMail is $orderIDMail <br>";

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
$mail->Subject = "INVOICE- SSDigitalIndia Order Comfirmed!";


require "./connection.php";

$stmt = $conn->prepare('SELECT * FROM  orders WHERE order_id=?');
$stmt->bind_param("s", $orderIDMail);
$stmt->execute();

$result = $stmt->get_result();
$emailID = null;
$firstname = "";
$tabelData = "";
while($row= $result->fetch_assoc()){


   $emailID = $row["email"];
   $firstname = $row["first_name"];

   $tabelData =   '<tr><td style="text-align: left;">'.$rateJson[$row["size"]] .' </td><td style="text-align: left;">'.$row["quantity"].' </td><td style="text-align: left;"> '.$rateJson[$row["size"]].'</td> <td style="text-align: left;">'.(int)$row["size"] * (int)$row["quantity"].' </td></tr>';
   
}

// $html = '<div style="padding: 20px; background:#F3F3F3"><p style="text-align: center; ">'.
// '<img src="data:image/png;base64,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" data-filename="SS_Digital_India_logo.png" style="width: 25%;"></p>'.
// '<p style="text-align: center; ">'.
// '<br></p><h2 style="text-align: center; "><b>Thank You for your order, '.$firstname .'.</b></h2><h3 style="text-align: center; ">Here is your confirmation for order number '.$orderID.'.</h3><p style="text-align: center;">    <br></p><p style="text-align: center;">    <br></p><p style="text-align: center;">    <br></p><table class="table table-bordered" style="text-align: left; border-collapse:collapse; width:100%">    <tbody>        <tr>            <td style="text-align: center; "><b style="color: rgb(255, 156, 0);">Image Size</b></td>            <td style="text-align: center; "><b>Quantity</b></td>            <td style="text-align: center; "><b>Rate</b></td>            <td style="text-align: center; "><b style="color: rgb(57, 123, 33);">Total Price</b></td> </tr>';
  
// $html .= $tabelData;

// $html .= '</tbody></table></div>';

// $mail->msgHTML($html);
// $mail->AltBody = "Thanks You for choosing SS Digital India. Your order number is";
// echo "email id = ".$emailID;
// $mail->AddAddress($emailID);

// if(!empty($emailID)){
//   echo "<br/> email is not empty = $emailID <br/>";
//  if(!$mail->Send()) {
//    //  echo "Mailer Error: " . $mail->ErrorInfo;
//  } else {
//    //  echo "Message has been sent";
//  }
// }else{
//   echo "email is empty = $emailID ";
//   echo "<br> firstname is $firstname";
// }
// }


// sendInvoice("SSDIN-1564133937546");
// &#8377; <= rupee symbol

$mail->AddEmbeddedImage("images/SS Digital.png", "header-image","header_image");
$mail->AddEmbeddedImage("images/SS_Digital_India_logo.png", "footer-image","footer_image");

$html= <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
 <head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title>New Template</title> 
  <!--[if (mso 16)]>    <style type="text/css">    a {text-decoration: none;}    </style>    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <style type="text/css">
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
	padding:0;
}
.ExternalClass {
	width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height:100%;
}
.es-button {
	mso-style-priority:100!important;
	text-decoration:none!important;
}
a[x-apple-data-detectors] {
	color:inherit!important;
	text-decoration:none!important;
	font-size:inherit!important;
	font-family:inherit!important;
	font-weight:inherit!important;
	line-height:inherit!important;
}
.es-desk-hidden {
	display:none;
	float:left;
	overflow:hidden;
	width:0;
	max-height:0;
	line-height:0;
	mso-hide:all;
}
</style> 
 </head> 
 <body style="width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
  <div class="es-wrapper-color" style="background-color:#F6F6F6;"> 
   <!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"><v:fill type="tile" color="#f6f6f6"></v:fill></v:background><![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
               <!--[if mso]><table width="560" cellpadding="0"                            cellspacing="0"><tr><td width="180" valign="top"><![endif]--> 
               <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="180" class="es-m-p0r es-m-p20b" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;"> <img class="adapt-img" src="cid:header-image" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="40"></td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="360" valign="top"><![endif]--> 
               <table cellpadding="0" cellspacing="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="360" align="left" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="right" style="padding:0;Margin:0;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:15px;color:#333333;">Order Number: SSDIN-1564133937546</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:15px;color:#333333;">Order Date: 30 Dec, 2019</p> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#333333;">Bill To:</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#333333;">Akshay Rana</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#333333;">121, Delhi</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#333333;">Delhi-&nbsp;110051</p> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;"> 
                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0px 0px 0px 0px;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px;"></td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr class="links" style="border-collapse:collapse;"> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-0" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:10px;padding-bottom:10px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#39443B;font-weight:bold;">Img Size</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-1" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:10px;padding-bottom:10px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#39443B;font-weight:bold;">Quantity</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-2" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:10px;padding-bottom:10px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#39443B;font-weight:bold;">Price/unit</a> </td> 
                          <td align="center" valign="top" width="25%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:10px;padding-bottom:10px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#39443B;font-weight:bold;">Total Price</a> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;"> 
                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0px;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px;"></td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr class="links" style="border-collapse:collapse;"> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-0" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">10x12"</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-1" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">10</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-2" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">&#8377;25</a> </td> 
                          <td align="center" valign="top" width="25%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">&#8377;250</a> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr class="links" style="border-collapse:collapse;"> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-0" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">4x6"</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-1" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">5</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-2" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">&#8377;6</a> </td> 
                          <td align="center" valign="top" width="25%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">&#8377;30</a> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr class="links" style="border-collapse:collapse;"> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-0" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">5x7"</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-1" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">10</a> </td> 
                          <td align="center" valign="top" width="25%" id="esd-menu-id-2" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">&#8377;8</a> </td> 
                          <td align="center" valign="top" width="25%" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:2px;padding-bottom:2px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#040404;">&#8377;80</a> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-left:20px;padding-right:20px;"> 
                       <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:0;Margin:0px 0px 0px 0px;border-bottom:1px solid #CCCCCC;background:none;height:1px;width:100%;margin:0px;"></td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-top:5px;padding-bottom:5px;padding-left:20px;padding-right:20px;"> 
               <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]--> 
               <table cellpadding="0" cellspacing="0" class="es-left" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="270" class="es-m-p20b" align="left" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;"> <img class="adapt-img" src="cid:footer-image" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="140"></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:15px;color:#333333;">B-2/22, Sector-20 Rohini</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:15px;color:#333333;">Delhi- 110086</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:15px;color:#333333;"><br></p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:10px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:15px;color:#333333;">GSTIN: 012345678901234</p> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]--> 
               <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="270" align="left" style="padding:0;Margin:0;"> 
                   <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"> 
                       <table cellpadding="0" cellspacing="0" width="100%" class="es-menu" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                         <tr class="links" style="border-collapse:collapse;"> 
                          <td align="center" valign="top" width="50%" id="esd-menu-id-1" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:10px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#010101;font-weight:bold;">Total Amount</a> </td> 
                          <td align="center" valign="top" width="50%" id="esd-menu-id-2" style="Margin:0;padding-left:5px;padding-right:5px;padding-top:0px;padding-bottom:10px;border:0;"> <a target="_blank" href="" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:10px;text-decoration:none;display:block;color:#0E0E0E;font-weight:bold;">&#8377;360</a> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> </td> 
     </tr> 
   </table> 
  </div>  
 </body>
</html>
EOD;


$mail->msgHTML($html);
$mail->AltBody = "Thanks You for choosing SS Digital India. Your order number is";
echo "email id = ".$emailID;
$mail->AddAddress($emailID);

if(!empty($emailID)){
  echo "<br/> email is not empty = $headeremailID <br/>";
 if(!$mail->Send()) {
   //  echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
   //  echo "Message has been sent";
 }
}else{
  echo "email is empty = $emailID ";
  echo "<br> firstname is $firstname";
}
}


sendInvoice("SSDIN-1564133937546");
?>