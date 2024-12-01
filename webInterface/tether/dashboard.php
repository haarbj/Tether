<?php
// dashboard.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];
$firstName = $_SESSION['firstName'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($firstName); ?>!</h2>
    <nav>
        <a href="add_contact.php">Add New Contact</a> |
        <a href="payment.php">Make a Payment</a> |
        <a href="logout.php">Logout</a>
    </nav>
    <h3>Your Contacts</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch contacts
        $sql = "SELECT phoneNumber, firstName, lastName FROM User_Social_Contact WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $contacts = $stmt->get_result();
        while ($contact = $contacts->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($contact['firstName'] . ' ' . $contact['lastName']) . "</td>";
            echo "<td>" . htmlspecialchars($contact['phoneNumber']) . "</td>";
            echo "<td><a href='view_contact.php?phone=" . urlencode($contact['phoneNumber']) . "'>View/Edit</a></td>";
            echo "</tr>";
        }
        $stmt->close();
        ?>
    </table>

    <h3>Pending Reminders</h3>
    <?php
    // Fetch pending reminders
    $sql = "SELECT r.content, r.frequency, usc.firstName, usc.lastName
            FROM Reminds rem
            JOIN Reminder r ON rem.reminderID = r.reminderID
            JOIN Refers ref ON r.reminderID = ref.reminderID
            JOIN User_Social_Contact usc ON ref.userID = usc.userID AND ref.phoneNumber = usc.phoneNumber
            WHERE rem.userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $reminders = $stmt->get_result();

    if ($reminders->num_rows > 0) {
        echo "<ul>";
        while ($reminder = $reminders->fetch_assoc()) {
            echo "<li>Reminder to contact " . htmlspecialchars($reminder['firstName'] . ' ' . $reminder['lastName']) . ": " . htmlspecialchars($reminder['content']) . " (Frequency: " . htmlspecialchars($reminder['frequency']) . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "No pending reminders.";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
