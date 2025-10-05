<?php
// Database configuration
$host = "localhost";       // XAMPP runs MySQL on localhost
$user = "root";            // Default XAMPP MySQL username
$pass = "";                // Default password is empty
$dbname = "student_system"; // Database name from phpMyAdmin

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
