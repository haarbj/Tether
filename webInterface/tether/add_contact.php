<?php
// add_contact.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Add Contact</title>
    <!-- Include Bootstrap and custom CSS -->
    <!-- ... -->
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h2>Add New Contact</h2>
        <form action="add_contact_process.php" method="post">
            <!-- Contact Information -->
            <h4>Contact Information</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>First Name:</label>
                    <input type="text" name="contactFirstName" required class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Middle Name:</label>
                    <input type="text" name="contactMiddleName" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Last Name:</label>
                    <input type="text" name="contactLastName" required class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="contactPhoneNumber" required class="form-control">
            </div>
            <!-- Reminder Information -->
            <h4>Reminder Settings</h4>
            <div class="form-group">
                <label>Reminder Content:</label>
                <input type="text" name="reminderContent" required class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Reminder Frequency:</label>
                    <select name="reminderFrequency" required class="form-control">
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Reminder Format:</label>
                    <select name="reminderFormat" required class="form-control">
                        <option value="Text">Text</option>
                        <option value="Email">Email</option>
                        <option value="Audio">Audio</option>
                        <option value="Video">Video</option>
                    </select>
                </div>
            </div>
            <input type="submit" value="Add Contact" class="btn btn-success btn-block">
        </form>
    </div>
    <!-- Include Bootstrap JS and dependencies -->
</body>
</html>
