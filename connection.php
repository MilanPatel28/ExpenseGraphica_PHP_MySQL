<?php
// Database connection parameters
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = 'Krish0!1$8';
$database = 'webDB';

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
