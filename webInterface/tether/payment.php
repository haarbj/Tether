<?php
// payment.php
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
    <title>Tether - Payment</title>
    <!-- Include Bootstrap and custom CSS -->
    <!-- ... -->
    <script>
        function togglePaymentMethod() {
            var method = document.getElementById('paymentMethod').value;
            if (method === 'Card') {
                document.getElementById('cardDetails').style.display = 'block';
                document.getElementById('echeckDetails').style.display = 'none';
            } else {
                document.getElementById('cardDetails').style.display = 'none';
                document.getElementById('echeckDetails').style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <h2>Make a Payment</h2>
        <form action="payment_process.php" method="post">
            <div class="form-group">
                <label>Amount:</label>
                <input type="number" name="amount" step="0.01" required class="form-control">
            </div>
            <div class="form-group">
                <label>Payment Method:</label>
                <select id="paymentMethod" name="paymentMethod" onchange="togglePaymentMethod()" required class="form-control">
                    <option value="Card">Card</option>
                    <option value="E-Check">E-Check</option>
                </select>
            </div>
            <div id="cardDetails">
                <h4>Card Details</h4>
                <div class="form-group">
                    <label>Type of Card:</label>
                    <input type="text" name="type_of_card" class="form-control">
                </div>
                <div class="form-group">
                    <label>Card Name:</label>
                    <input type="text" name="cardName" class="form-control">
                </div>
                <div class="form-group">
                    <label>Card Number:</label>
                    <input type="text" name="cardNumber" class="form-control">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>CVV:</label>
                        <input type="text" name="CVV" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Expiration Date:</label>
                        <input type="date" name="cardExpDate" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Billing Address:</label>
                    <input type="text" name="cardAddress" class="form-control">
                </div>
            </div>

            <div id="echeckDetails" style="display:none;">
                <h4>E-Check Details</h4>
                <div class="form-group">
                    <label>Account Number:</label>
                    <input type="text" name="echeckAccNumber" class="form-control">
                </div>
                <div class="form-group">
                    <label>Routing Number:</label>
                    <input type="text" name="echeckRoutingNumber" class="form-control">
                </div>
                <div class="form-group">
                    <label>Account Holder Name:</label>
                    <input type="text" name="echeckName" class="form-control">
                </div>
                <div class="form-group">
                    <label>Billing Address:</label>
                    <input type="text" name="echeckAddress" class="form-control">
                </div>
            </div>
            <input type="submit" value="Submit Payment" class="btn btn-success btn-block">
        </form>
    </div>
    <!-- Include Bootstrap JS and dependencies -->
</body>
</html>
