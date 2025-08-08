<?php
// Database configuration
$host = "localhost";    // Database host
$user = "root";         // Database username
$pass = "";             // Database password
$dbname = "pg_booking"; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF-8 for proper encoding
$conn->set_charset("utf8");
?>
