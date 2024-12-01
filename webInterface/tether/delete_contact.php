<?php
// delete_contact.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Retrieve and sanitize input
$userID = $_SESSION['userID'];
$contactPhoneNumber = htmlspecialchars($_POST['contactPhoneNumber']);

// Begin transaction
$conn->begin_transaction();

try {
    // Get reminderID
    $sql_reminderID = "SELECT reminderID FROM Refers WHERE userID = ? AND phoneNumber = ?";
    $stmt = $conn->prepare($sql_reminderID);
    $stmt->bind_param("is", $userID, $contactPhoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $reminderID = $result->fetch_assoc()['reminderID'];

    // Delete from Reminds
    $sql_reminds = "DELETE FROM Reminds WHERE userID = ? AND reminderID = ?";
    $stmt = $conn->prepare($sql_reminds);
    $stmt->bind_param("ii", $userID, $reminderID);
    $stmt->execute();

    // Delete from Refers
    $sql_refers = "DELETE FROM Refers WHERE reminderID = ? AND userID = ? AND phoneNumber = ?";
    $stmt = $conn->prepare($sql_refers);
    $stmt->bind_param("iis", $reminderID, $userID, $contactPhoneNumber);
    $stmt->execute();

    // Delete from Reminder
    $sql_reminder = "DELETE FROM Reminder WHERE reminderID = ?";
    $stmt = $conn->prepare($sql_reminder);
    $stmt->bind_param("i", $reminderID);
    $stmt->execute();

    // Delete from User_Social_Contact
    $sql_contact = "DELETE FROM User_Social_Contact WHERE userID = ? AND phoneNumber = ?";
    $stmt = $conn->prepare($sql_contact);
    $stmt->bind_param("is", $userID, $contactPhoneNumber);
    $stmt->execute();

    // Commit transaction
    $conn->commit();
    header("Location: dashboard.php");
    exit();
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    echo "Failed to delete contact: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>
