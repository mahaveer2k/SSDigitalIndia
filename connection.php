<?php 

$SERVERNAME = "localhost";
$USERNAME = "akshay";
$PASSWORD = "akshay@Ran";
$DB_NAME= "ssdigitalindia";

// Create connection
$conn = new mysqli($SERVERNAME, $USERNAME, $PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
error_log("Connecred to DB!");
?>