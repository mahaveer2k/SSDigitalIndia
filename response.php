<?php
$postdata = $_POST;
$msg = '';
if (isset($postdata['key'])) {
    $key = $postdata['key'];
    $salt = '6ShWIUoEIp';
    $txnid = $postdata['txnid'];
    $amount = $postdata['amount'];
    $productInfo = $postdata['productinfo'];
    $firstname = $postdata['firstname'];
    $email = $postdata['email'];
    $udf5 = $postdata['udf5'];
    $mihpayid = $postdata['mihpayid'];
    $status = $postdata['status'];
    $resphash = $postdata['hash'];
    //Calculate response hash to verify
    $keyString = $key . '|' . $txnid . '|' . $amount . '|' . $productInfo . '|' . $firstname . '|' . $email . '|||||' . $udf5 . '|||||';
    $keyArray = explode("|", $keyString);
    $reverseKeyArray = array_reverse($keyArray);
    $reverseKeyString = implode("|", $reverseKeyArray);
    $CalcHashString = strtolower(hash('sha512', $salt . '|' . $status . '|' . $reverseKeyString));

    error_log("salt = ".$salt);
    if ($status == 'success' && $resphash == $CalcHashString) {
        $msg = "Thank You!!";
        $second_msg = "Your order is confirmed!!";
        require("./connection.php");
        $msg = "Transaction Successfull";
        //Do success order processing here...

        // Connect to the database using mysqli
        require "./connection.php";

        $stmt = $conn->prepare('UPDATE orders SET payment_status=true WHERE order_id=?');
        $stmt->bind_param("s", $txnid);
        $stmt->execute();

        require("./mail.php");

        sendInvoice($txnid);
        

       


    } else {
        //tampered or failed
        $msg = "Payment failed!!";
        $second_msg = "Your order is not confirmed!!";
    }

} else {
    header('Location: '."/");
}
// else exit(0);
// $msg = "Thank You!!";
// $second_msg = "Your order is confirmed!!";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="theme-color" content="#118496" />

    <link rel="stylesheet" href="stylesheets//bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="javascript/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="stylesheets/style.css"> -->
    <script src="javascript/script.js" type="text/javascript"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


<title><?php echo $msg; ?></title>
</head>
<style type="text/css">

	img#logo {
        width: 20%;
    }

    @media only screen and (max-width: 768px) {
        img#logo {
            width: 80%;
        }

    }


</style>
<body>
<nav class="navbar  text-white justify-content-center ">
        <a class="navbar-brand text-white" href="/">
            <!-- <img src="/docs/4.3/assets/brand/bootstrap-solid.svg" width="30" height="30"          class="d-inline-block align-top" alt=""> -->
            <h2 class="font-weight-bold text-center mt-3">
                <img src="images/SS_Digital_India_logo.png" alt="Online web studio..." title="Online web studio..."
                    class="img-fluid mx-auto" id="logo">
            </h2>
        </a>
    </nav>



<div class="container-fluid p-3 mb-5 bg-light">

	<h1 class="text-center mb-2" >
		<?php echo $msg; ?>
    </h1>
    <h4 class="text-center mb-5"><?php echo $second_msg; ?></h4>
<div class="container">
    <div class="dv">
    <span ><label>Your Order ID:</label></span>
    <span><?php echo $txnid; ?></span>
    </div>
	<br>

    <div class="dv">
    <span ><label>Amount:</label></span>
    <span><?php echo $amount; ?></span>
    </div>

	<br>


    <div class="dv">
    <span ><label>First Name:</label></span>
    <span><?php echo $firstname; ?></span>
    </div>
	<br>

    <div class="dv">
    <span ><label>Email ID:</label></span>
    <span><?php echo $email; ?></span>
    </div>
<!--
    <div class="dv">
    <span ><label>Mihpayid:</label></span>
    <span><?php echo $mihpayid; ?></span>
    </div>
     -->
	 <br>

    <div class="dv">
    <span ><label>Transaction Status:</label></span>
    <span><?php echo $status; ?></span>
    </div>

    <!-- <div class="dv">
    <span ><label>Message:</label></span>
    <span><?php echo $msg; ?></span>
    </div> -->
</div>
<hr>
<div class="text-center">
    <p>Having Trouble? <a href="/contact.html">Contact Us</a></p>
    <button class="btn btn-primary btn-sm">Continue to homepage</button>
</div>

</div>
<footer class="text-white text-center footer navbar-fixed-bottom z--1000">
        <div class="container">
            <div class="h6">
                <!-- <div> Quick Links </div> -->
                <nav class="navbar navbar-expand-lg navbar-light justify-content-center  text-white">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="about.html">About us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="service.html">Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="faq.html">FAQs</a>
                        </li>
                    </ul>
                </nav>
            </div>


        </div>
        <div class="card-footer text-muted text-center">
            All Right Reserved | © 2019 SS Digital India
        </div>
    </footer>

</body>
</html>
