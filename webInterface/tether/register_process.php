<?php
// register_process.php
session_start();
include('includes/db_connect.php');

// Retrieve form data and sanitize inputs
$firstName = htmlspecialchars($_POST['firstName']);
$middleName = htmlspecialchars($_POST['middleName']);
$lastName = htmlspecialchars($_POST['lastName']);
$email = htmlspecialchars($_POST['email']);
$phoneNumber = htmlspecialchars($_POST['phoneNumber']);
$streetNumber = htmlspecialchars($_POST['streetNumber']);
$streetName = htmlspecialchars($_POST['streetName']);
$city = htmlspecialchars($_POST['city']);
$state = htmlspecialchars($_POST['state']);
$zip = intval($_POST['zip']);
$password = $_POST['password']; // Will be hashed

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check if the email already exists
$sql = "SELECT * FROM UserVal WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "An account with this email already exists. Please <a href='login.php'>login</a>.";
    exit();
}

// Insert the new user into the database
$sql = "INSERT INTO UserVal (phoneNumber, email, password, firstName, middleName, lastName, zip, state, city, streetNumber, streetName)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssissss", $phoneNumber, $email, $hashed_password, $firstName, $middleName, $lastName, $zip, $state, $city, $streetNumber, $streetName);

if ($stmt->execute()) {
    // Registration successful, redirect to login
    header("Location: login.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
