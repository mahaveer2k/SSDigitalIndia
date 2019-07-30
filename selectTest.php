<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");


require("./connection.php");

$s = "size";
$q = "qunatity";
$a = "this->amount";
$o = "this->orderID";
$f = "this->first_name";
$m = "this->mobile";
$e = "this->email";
$add = "this->address";
$ci = "this->city";
$p = "this->pin_code";
$country = "this->country";
$i_path = "this->image_path";


$stmt = $conn->prepare('INSERT INTO orders (size, quantity, amount, order_id, first_name, mobile, email, address, city, pin_code, country, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->bind_param("ssssssssssss", $s, $q, $a, $o, $f, $m, $e, $add, $ci, $p, $country, $i_path);
$stmt->execute();


?>