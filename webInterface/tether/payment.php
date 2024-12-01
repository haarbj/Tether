<!-- payment.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Tether - Payment</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
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
    <h2>Make a Payment</h2>
    <form action="payment_process.php" method="post">
        <label>Amount:</label>
        <input type="number" name="amount" step="0.01" required><br>

        <label>Payment Method:</label>
        <select id="paymentMethod" name="paymentMethod" onchange="togglePaymentMethod()" required>
            <option value="Card">Card</option>
            <option value="E-Check">E-Check</option>
        </select><br>

        <div id="cardDetails" style="display:block;">
            <h3>Card Details</h3>
            <label>Type of Card:</label>
            <input type="text" name="type_of_card"><br>

            <label>Card Name:</label>
            <input type="text" name="cardName"><br>

            <label>Card Number:</label>
            <input type="text" name="cardNumber"><br>

            <label>CVV:</label>
            <input type="text" name="CVV"><br>

            <label>Expiration Date:</label>
            <input type="date" name="cardExpDate"><br>

            <label>Billing Address:</label>
            <input type="text" name="cardAddress"><br>
        </div>

        <div id="echeckDetails" style="display:none;">
            <h3>E-Check Details</h3>
            <label>Account Number:</label>
            <input type="text" name="echeckAccNumber"><br>

            <label>Routing Number:</label>
            <input type="text" name="echeckRoutingNumber"><br>

            <label>Account Holder Name:</label>
            <input type="text" name="echeckName"><br>

            <label>Billing Address:</label>
            <input type="text" name="echeckAddress"><br>
        </div>

        <input type="submit" value="Submit Payment">
    </form>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
