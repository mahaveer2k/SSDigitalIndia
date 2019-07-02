<?php 

$SERVERNAME = "localhost";
$USERNAME = "akshay";
$PASSWORD = "akshay@Rana";
$DB_NAME= "ssdigitialindia";

// Create connection
$conn = new mysqli($SERVERNAME, $USERNAME, $PASSWORD);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>