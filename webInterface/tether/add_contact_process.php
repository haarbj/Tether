<?php
// add_contact_process.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Retrieve and sanitize inputs
$userID = $_SESSION['userID'];
$contactFirstName = htmlspecialchars($_POST['contactFirstName']);
$contactMiddleName = htmlspecialchars($_POST['contactMiddleName']);
$contactLastName = htmlspecialchars($_POST['contactLastName']);
$contactPhoneNumber = htmlspecialchars($_POST['contactPhoneNumber']);
$reminderContent = htmlspecialchars($_POST['reminderContent']);
$reminderFrequency = htmlspecialchars($_POST['reminderFrequency']);
$reminderFormat = htmlspecialchars($_POST['reminderFormat']);

// Begin transaction
$conn->begin_transaction();

try {
    // Insert into User_Social_Contact
    $sql_contact = "INSERT INTO User_Social_Contact (userID, phoneNumber, firstName, middleName, lastName)
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_contact);
    $stmt->bind_param("issss", $userID, $contactPhoneNumber, $contactFirstName, $contactMiddleName, $contactLastName);
    $stmt->execute();

    // Insert into Reminder
    $sql_reminder = "INSERT INTO Reminder (content, frequency)
                     VALUES (?, ?)";
    $stmt = $conn->prepare($sql_reminder);
    $stmt->bind_param("ss", $reminderContent, $reminderFrequency);
    $stmt->execute();
    $reminderID = $conn->insert_id;

    // Insert into Refers
    $sql_refers = "INSERT INTO Refers (reminderID, phoneNumber, userID)
                   VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_refers);
    $stmt->bind_param("isi", $reminderID, $contactPhoneNumber, $userID);
    $stmt->execute();

    // Insert into Reminds
    $sql_reminds = "INSERT INTO Reminds (userID, reminderID, format)
                    VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_reminds);
    $stmt->bind_param("iis", $userID, $reminderID, $reminderFormat);
    $stmt->execute();

    // Commit transaction
    $conn->commit();
    header("Location: dashboard.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    echo "Failed to add contact: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>
