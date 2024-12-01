<?php
// login_process.php
session_start();
include('includes/db_connect.php');

// Retrieve and sanitize inputs
$email = htmlspecialchars($_POST['email']);
$password = $_POST['password']; // Will be verified against the hash

// Fetch user data from the database
$sql = "SELECT userID, password, firstName FROM UserVal WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // User found
    $user = $result->fetch_assoc();
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['firstName'] = $user['firstName'];
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid password
        echo "Incorrect password. <a href='login.php'>Try again</a>.";
    }
} else {
    // User not found
    echo "No account found with that email. <a href='register.php'>Register here</a>.";
}

$stmt->close();
$conn->close();
?>
