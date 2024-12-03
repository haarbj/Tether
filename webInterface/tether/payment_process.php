<?php
// payment_process.php
session_start();
include('includes/db_connect.php');

if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

// Retrieve and sanitize inputs
$userID = $_SESSION['userID'];
$amount = floatval($_POST['amount']);
$paymentMethod = htmlspecialchars($_POST['paymentMethod']);
$invoiceNumber = 'INV' . time(); // Simple invoice number generation
$paymentDate = date('Y-m-d');

// Begin transaction
$conn->begin_transaction();

try {
    if ($paymentMethod === 'Card') {
        // Card payment details
        $cardAddress = htmlspecialchars($_POST['cardAddress']);
        $type_of_card = htmlspecialchars($_POST['type_of_card']);
        $cardName = htmlspecialchars($_POST['cardName']);
        $CVV = htmlspecialchars($_POST['CVV']);
        $cardNumber = htmlspecialchars($_POST['cardNumber']);
        $cardExpDateInput = htmlspecialchars($_POST['cardExpDate']);

        // Convert cardExpDate to 'Y-m-d' format
        $cardExpDate = date('Y-m-d', strtotime($cardExpDateInput));

        $cardFlag = 1;
        $echeckFlag = 0;

        // Prepare and execute payment insert with card details
        $sql_payment = "INSERT INTO Payment (amount, invoiceNumber, paymentDate, cardFlag, echeckFlag, cardAddress, type_of_card, cardName, CVV, cardNumber, cardExpDate)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_payment);
        $stmt->bind_param("dssiissssss", $amount, $invoiceNumber, $paymentDate, $cardFlag, $echeckFlag, $cardAddress, $type_of_card, $cardName, $CVV, $cardNumber, $cardExpDate);
        $stmt->execute();
        $paymentID = $conn->insert_id;

    } else {
        // E-Check payment details
        $echeckAccNumber = htmlspecialchars($_POST['echeckAccNumber']);
        $echeckRoutingNumber = htmlspecialchars($_POST['echeckRoutingNumber']);
        $echeckName = htmlspecialchars($_POST['echeckName']);
        $echeckAddress = htmlspecialchars($_POST['echeckAddress']);
        $cardFlag = 0;
        $echeckFlag = 1;

        // Prepare and execute payment insert with e-check details
        $sql_payment = "INSERT INTO Payment (amount, invoiceNumber, paymentDate, cardFlag, echeckFlag, echeckAccNumber, echeckRoutingNumber, echeckName, echeckAddress)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_payment);
        $stmt->bind_param("dssiissss", $amount, $invoiceNumber, $paymentDate, $cardFlag, $echeckFlag, $echeckAccNumber, $echeckRoutingNumber, $echeckName, $echeckAddress);
        $stmt->execute();
        $paymentID = $conn->insert_id;
    }

    // Insert into Assist table
    $sql_assist = "INSERT INTO Assist (userID, paymentID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_assist);
    $stmt->bind_param("ii", $userID, $paymentID);
    $stmt->execute();

    // Commit transaction
    $conn->commit();
    echo "Payment successful. <a href='dashboard.php'>Back to Dashboard</a>";
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    echo "Payment failed: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>
