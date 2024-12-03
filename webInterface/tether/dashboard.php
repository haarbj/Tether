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
    <!-- Include Bootstrap and custom CSS -->
    <!-- ... -->
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h2 class="text-center">Welcome, <?php echo htmlspecialchars($firstName); ?>!</h2>
        <div class="mt-4">
            <h3>Your Contacts</h3>
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
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
                    echo "<td><a href='view_contact.php?phone=" . urlencode($contact['phoneNumber']) . "' class='btn btn-sm btn-info'>View/Edit</a></td>";
                    echo "</tr>";
                }
                $stmt->close();
                ?>
                </tbody>
            </table>
            <a href="add_contact.php" class="btn btn-primary">Add New Contact</a>
        </div>

        <div class="mt-5">
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
                echo "<ul class='list-group'>";
                while ($reminder = $reminders->fetch_assoc()) {
                    echo "<li class='list-group-item'>";
                    echo "<strong>" . htmlspecialchars($reminder['firstName'] . ' ' . $reminder['lastName']) . "</strong>: ";
                    echo htmlspecialchars($reminder['content']) . " ";
                    echo "<span class='badge badge-info'>" . htmlspecialchars($reminder['frequency']) . "</span>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No pending reminders.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
    <!-- Include Bootstrap JS and dependencies -->
</body>
</html>
