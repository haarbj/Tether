<?php
// update_contact.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Retrieve and sanitize inputs
$userID = $_SESSION['userID'];
$contactPhoneNumber = htmlspecialchars($_POST['contactPhoneNumber']);
$contactFirstName = htmlspecialchars($_POST['contactFirstName']);
$contactMiddleName = htmlspecialchars($_POST['contactMiddleName']);
$contactLastName = htmlspecialchars($_POST['contactLastName']);
$reminderContent = htmlspecialchars($_POST['reminderContent']);
$reminderFrequency = htmlspecialchars($_POST['reminderFrequency']);
$reminderFormat = htmlspecialchars($_POST['reminderFormat']);

// Begin transaction
$conn->begin_transaction();

try {
    // Update User_Social_Contact
    $sql_contact = "UPDATE User_Social_Contact SET firstName = ?, middleName = ?, lastName = ?
                    WHERE userID = ? AND phoneNumber = ?";
    $stmt = $conn->prepare($sql_contact);
    $stmt->bind_param("sssis", $contactFirstName, $contactMiddleName, $contactLastName, $userID, $contactPhoneNumber);
    $stmt->execute();

    // Get reminderID
    $sql_reminderID = "SELECT reminderID FROM Refers WHERE userID = ? AND phoneNumber = ?";
    $stmt = $conn->prepare($sql_reminderID);
    $stmt->bind_param("is", $userID, $contactPhoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $reminderID = $result->fetch_assoc()['reminderID'];

    // Update Reminder
    $sql_reminder = "UPDATE Reminder SET content = ?, frequency = ? WHERE reminderID = ?";
    $stmt = $conn->prepare($sql_reminder);
    $stmt->bind_param("ssi", $reminderContent, $reminderFrequency, $reminderID);
    $stmt->execute();

    // Update Reminds
    $sql_reminds = "UPDATE Reminds SET format = ? WHERE userID = ? AND reminderID = ?";
    $stmt = $conn->prepare($sql_reminds);
    $stmt->bind_param("sii", $reminderFormat, $userID, $reminderID);
    $stmt->execute();

    // Commit transaction
    $conn->commit();
    header("Location: dashboard.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    echo "Failed to update contact: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>
