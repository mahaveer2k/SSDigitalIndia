<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");


require("./connection.php");


$stmt = $conn->prepare('INSERT INTO orders (size, quantity, amount, order_id, first_name, mobile, email, address, city, pin_code, country, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->bind_param("ssssssssssss","20.00", "5", "100", "xyz", "xas", "xyz", "xas", "xyz", "xas", "xas", "xas", "xas");
$stmt->execute();


?>