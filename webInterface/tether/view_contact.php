<?php
// view_contact.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['userID'];
$contactPhoneNumber = htmlspecialchars($_GET['phone']);

// Fetch contact and reminder details
$sql = "SELECT usc.firstName, usc.middleName, usc.lastName, r.content, r.frequency, rem.format
        FROM User_Social_Contact usc
        LEFT JOIN Refers ref ON usc.userID = ref.userID AND usc.phoneNumber = ref.phoneNumber
        LEFT JOIN Reminder r ON ref.reminderID = r.reminderID
        LEFT JOIN Reminds rem ON rem.userID = usc.userID AND rem.reminderID = r.reminderID
        WHERE usc.userID = ? AND usc.phoneNumber = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $userID, $contactPhoneNumber);
$stmt->execute();
$result = $stmt->get_result();
$contact = $result->fetch_assoc();

if (!$contact) {
    echo "Contact not found. <a href='dashboard.php'>Back to Dashboard</a>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tether - View Contact</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>View/Edit Contact</h2>
    <form action="update_contact.php" method="post">
        <input type="hidden" name="contactPhoneNumber" value="<?php echo htmlspecialchars($contactPhoneNumber); ?>">
        <!-- Contact Information -->
        <label>First Name:</label>
        <input type="text" name="contactFirstName" value="<?php echo htmlspecialchars($contact['firstName']); ?>" required><br>

        <label>Middle Name:</label>
        <input type="text" name="contactMiddleName" value="<?php echo htmlspecialchars($contact['middleName']); ?>"><br>

        <label>Last Name:</label>
        <input type="text" name="contactLastName" value="<?php echo htmlspecialchars($contact['lastName']); ?>" required><br>

        <!-- Reminder Information -->
        <h3>Reminder Settings</h3>
        <label>Reminder Content:</label>
        <input type="text" name="reminderContent" value="<?php echo htmlspecialchars($contact['content']); ?>" required><br>

        <label>Reminder Frequency:</label>
        <select name="reminderFrequency" required>
            <option value="Daily" <?php if ($contact['frequency'] == 'Daily') echo 'selected'; ?>>Daily</option>
            <option value="Weekly" <?php if ($contact['frequency'] == 'Weekly') echo 'selected'; ?>>Weekly</option>
            <option value="Monthly" <?php if ($contact['frequency'] == 'Monthly') echo 'selected'; ?>>Monthly</option>
        </select><br>

        <label>Reminder Format:</label>
        <select name="reminderFormat" required>
            <option value="Text" <?php if ($contact['format'] == 'Text') echo 'selected'; ?>>Text</option>
            <option value="Email" <?php if ($contact['format'] == 'Email') echo 'selected'; ?>>Email</option>
            <option value="Audio" <?php if ($contact['format'] == 'Audio') echo 'selected'; ?>>Audio</option>
            <option value="Video" <?php if ($contact['format'] == 'Video') echo 'selected'; ?>>Video</option>
        </select><br>

        <input type="submit" value="Update Contact">
    </form>
    <form action="delete_contact.php" method="post" onsubmit="return confirm('Are you sure you want to delete this contact?');">
        <input type="hidden" name="contactPhoneNumber" value="<?php echo htmlspecialchars($contactPhoneNumber); ?>">
        <input type="submit" value="Delete Contact">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
