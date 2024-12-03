<?php
// login.php
include('includes/db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Login</title>
    <!-- Include Bootstrap and custom CSS -->
    <!-- ... -->
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h2 class="text-center">Login</h2>
        <form action="login_process.php" method="post" class="mx-auto" style="max-width: 400px;">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <input type="submit" value="Login" class="btn btn-primary btn-block">
        </form>
        <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
    <!-- Include Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- ... -->
</body>
</html>
