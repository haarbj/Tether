<?php
// db_connect.php

$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = "";     // Default password is empty
$dbname = "tether_db"; // Your database name

// Create a new mysqli object with database connection parameters
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for a connection error and display a user-friendly message
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
