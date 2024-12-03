<?php
// register.php
include('includes/db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Register</title>
    <!-- Include Bootstrap and custom CSS -->
    <!-- ... -->
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>
        <form action="register_process.php" method="post" class="mx-auto" style="max-width: 600px;">
            <!-- Personal Information -->
            <h4>Personal Information</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>First Name:</label>
                    <input type="text" name="firstName" required class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Middle Name:</label>
                    <input type="text" name="middleName" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Last Name:</label>
                    <input type="text" name="lastName" required class="form-control">
                </div>
            </div>
            <!-- Contact Information -->
            <h4>Contact Information</h4>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phoneNumber" required class="form-control">
            </div>
            <!-- Address Information -->
            <h4>Address Information</h4>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label>Street Number:</label>
                    <input type="text" name="streetNumber" required class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Street Name:</label>
                    <input type="text" name="streetName" required class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>City:</label>
                    <input type="text" name="city" required class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>State:</label>
                    <input type="text" name="state" required class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>ZIP Code:</label>
                    <input type="text" name="zip" required class="form-control">
                </div>
            </div>
            <!-- Account Information -->
            <h4>Account Information</h4>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <input type="submit" value="Register" class="btn btn-success btn-block">
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
    <!-- Include Bootstrap JS and dependencies -->
</body>
</html>
