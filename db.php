<?php
$servername = "localhost"; // Database server address
$username = "root";         // Default username for XAMPP
$password = "";             // Default password (leave empty)
$dbname = "hotel_management"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
