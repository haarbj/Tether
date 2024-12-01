<!-- add_contact.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Add Contact</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Add New Contact</h2>
    <form action="add_contact_process.php" method="post">
        <!-- Contact Information -->
        <label>First Name:</label>
        <input type="text" name="contactFirstName" required><br>

        <label>Middle Name:</label>
        <input type="text" name="contactMiddleName"><br>

        <label>Last Name:</label>
        <input type="text" name="contactLastName" required><br>

        <label>Phone Number:</label>
        <input type="text" name="contactPhoneNumber" required><br>

        <!-- Reminder Information -->
        <h3>Reminder Settings</h3>
        <label>Reminder Content:</label>
        <input type="text" name="reminderContent" required><br>

        <label>Reminder Frequency:</label>
        <select name="reminderFrequency" required>
            <option value="Daily">Daily</option>
            <option value="Weekly">Weekly</option>
            <option value="Monthly">Monthly</option>
        </select><br>

        <label>Reminder Format:</label>
        <select name="reminderFormat" required>
            <option value="Text">Text</option>
            <option value="Email">Email</option>
            <option value="Audio">Audio</option>
            <option value="Video">Video</option>
        </select><br>

        <input type="submit" value="Add Contact">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
