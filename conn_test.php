<?php 
error_reporting(-1);
ini_set('display_errors', 'On');
set_error_handler("var_dump");

$SERVERNAME = "localhost";
$USERNAME = "akshay";
$PASSWORD = "akshay@Rana";
$DB_NAME= "ssdigitalindia";

// Create connection
$conn = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo("Connecred to DB!");
?>