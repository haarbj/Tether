<!-- register.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Register</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Register</h2>
    <form action="register_process.php" method="post">
        <!-- Personal Information -->
        <label>First Name:</label>
        <input type="text" name="firstName" required><br>

        <label>Middle Name:</label>
        <input type="text" name="middleName"><br>

        <label>Last Name:</label>
        <input type="text" name="lastName" required><br>

        <!-- Contact Information -->
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Phone Number:</label>
        <input type="text" name="phoneNumber" required><br>

        <!-- Address Information -->
        <label>Street Number:</label>
        <input type="text" name="streetNumber" required><br>

        <label>Street Name:</label>
        <input type="text" name="streetName" required><br>

        <label>City:</label>
        <input type="text" name="city" required><br>

        <label>State:</label>
        <input type="text" name="state" required><br>

        <label>ZIP Code:</label>
        <input type="text" name="zip" required><br>

        <!-- Account Information -->
        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</body>
</html>
