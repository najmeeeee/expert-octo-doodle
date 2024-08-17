<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crest Home Care Payment</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Add your styles here */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            padding: 0;
            color: #444;
            position: relative;
        }

        .side-image {
            position: absolute;
            top: 0;
            width: 15%;
            height: 100%;
            background-size: cover;
            background-position: center;
            z-index: -1;
        }

        .left-image {
            left: 0;
            background-image: url('pic5.jpg');
        }

        .right-image {
            right: 0;
            background-image: url('right-image.jpg');
        }

        .container {
            width: 40%;
            margin: 40px auto;
            background: #FFFFFF;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
            border: 1px solid #E0E0E0;
        }

        h1 {
            text-align: center;
            color: #1E1E1E;
            font-weight: 600;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        input {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 5px;
            border: 1px solid #E0E0E0;
            border-radius: 8px;
            background-color: #F9F9F9;
            color: #333;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        input:focus {
            border-color: #1E1E1E;
            background-color: #FFFFFF;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #CF6679;
            color: #121212;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #B00020;
            transform: translateY(-3px);
        }

        .message {
            text-align: center;
            font-size: 1.2em;
            color: #1E1E1E;
            margin-top: 20px;
        }

        .error {
            color: #B00020;
            font-size: 0.9em;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .amount-section {
            font-size: 1.2em;
            font-weight: bold;
            color: #1E1E1E;
            margin-bottom: 20px;
            text-align: center;
        }

        .booking-details {
            margin-top: 30px;
            padding: 20px;
            background-color: #F0F0F0;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .booking-details h2 {
            text-align: center;
            color: #1E1E1E;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .booking-details p {
            font-size: 1em;
            margin-bottom: 10px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .pay-now, .cancel {
            width: 48%;
            background-color: #4CAF50;
            color: #FFFFFF;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cancel {
            background-color: #FF5722;
        }

        .pay-now:hover {
            background-color: #45A049;
        }

        .cancel:hover {
            background-color: #E64A19;
        }
    </style>
</head>
<body>
    <div class="side-image left-image"></div>
    <div class="side-image right-image"></div>

    <div class="container">
        <h1>Payment Information</h1>
        
        <!-- Display the total amount -->
        <div class="amount-section">
            <?php
            if (isset($_SESSION['totalAmount'])) {
                echo "Total Amount: ₹" . htmlspecialchars($_SESSION['totalAmount']);
            } else {
                echo "Total Amount: ₹0"; // Default message if no amount is set
            }
            ?>
        </div>

        <form id="paymentForm" method="POST" action="">
            <label for="accountholdername">Account Holder Name:</label>
            <input type="text" id="accountholdername" name="accountholdername" oninput="validateAccountHolderName()">
            <div id="accountholdernameError" class="error"></div>

           

            <label for="accountno">Account Number:</label>
            <input type="text" id="accountno" name="accountno" oninput="validateAccountNo()">
            <div id="accountnoError" class="error"></div>

            <label for="ifsc">IFSC Code:</label>
            <input type="text" id="ifsc" name="ifsc" oninput="validateIfsc()">
            <div id="ifscError" class="error"></div>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" oninput="validateCvv()">
            <div id="cvvError" class="error"></div>

            <label for="expirydate">Expiry Date:</label>
            <input type="date" id="expirydate" name="expirydate" oninput="validateExpiryDate()">
            <div id="expirydateError" class="error"></div>

            <button type="submit" name="submit">Submit Payment</button>
        </form>
        <div id="paymentMessage" class="message"></div>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'miniproject');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $accountholdername = $_POST['accountholdername'];
    
    $accountno = $_POST['accountno'];
    $ifsc = $_POST['ifsc'];
    $cvv = $_POST['cvv'];
    $expirydate = $_POST['expirydate'];

    // Get the user ID from the session
    $stmt1 = $conn->prepare("SELECT ussrid FROM user WHERE email = ?");
    $stmt1->bind_param("s", $_SESSION['login_user']);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($row1 = $result1->fetch_assoc()) {
        $u_id = $row1['ussrid']; 
    }

    // Check if the entered details match any record in the 'bank' table
    $stmt = $conn->prepare("SELECT * FROM bank WHERE account_holder_name = ? AND accountno = ? AND ifsc = ? AND cvv = ? AND expirydate = ?");
    $stmt->bind_param("sssss", $accountholdername, $accountno, $ifsc, $cvv, $expirydate);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row1 = $result->fetch_assoc()) {
            $amt=$row1['balance']; 
           
            
           
        // Prepare and bind booking statement
        $stmt = $conn->prepare("INSERT INTO booking (residents_name, ussrid, dob, place, no_of_stay, gender, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissisi", $_SESSION['residentName'], $u_id, $_SESSION['dob'], $_SESSION['place'], $_SESSION['days'], $_SESSION['gender'], $_SESSION['totalAmount']);
        $currentDate = date("Y-m-d");
        $stmt = $conn->prepare("SELECT booking_id from booking where dob=? ");
        $stmt->bind_param("i", $currentDate);
        if ($row = $result->fetch_assoc()) {
            $b_id=$row['booking_id '];
        }
        // Prepare and bind booking statement
        $stmt = $conn->prepare("INSERT INTO orgtransaction (booking_id,transaction_date,credited_amount,name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis",$b_id,$currentDate,$_SESSION['totalAmount'],$accountholdername);
        
            // Execute the booking statement
            if ($stmt->execute()) {
                echo"executed";
            }
        // Execute the booking statement
        if ($stmt->execute()) {
            // Retrieve the last inserted booking details
            $booking_id = $stmt->insert_id;
            $stmt = $conn->prepare("SELECT residents_name, dob, place, no_of_stay, gender, amount FROM booking WHERE booking_id = ?");
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Display the booking details
                echo '<div class="booking-details">';
                echo '<h2>Booking Details</h2>';
                echo '<p><strong>Resident Name:</strong> ' . htmlspecialchars($row['residents_name']) . '</p>';
                echo '<p><strong>Date of Birth:</strong> ' . htmlspecialchars($row['dob']) . '</p>';
                echo '<p><strong>Place:</strong> ' . htmlspecialchars($row['place']) . '</p>';
                echo '<p><strong>Number of Days:</strong> ' . htmlspecialchars($row['no_of_stay']) . '</p>';
                echo '<p><strong>Gender:</strong> ' . htmlspecialchars($row['gender']) . '</p>';
                echo '<p><strong>Total Amount:</strong> ₹' . htmlspecialchars($row['amount']) . '</p>';
                echo '</div>';
                $newamt=$amt-$row['amount'];
                $stmt = $conn->prepare("UPDATE  bank set balance = ? WHERE account_holder_name = ? AND accountno = ? AND ifsc = ? AND cvv = ? AND expirydate = ?");
            $stmt->bind_param("isssss", $newamt, $accountholdername, $accountno, $ifsc, $cvv, $expirydate);
            if($stmt->execute())
            {
                
                echo"updation successful";
            }
            }

            // Confirm the payment success
            echo '<div id="paymentMessage" class="message">Payment Successful! Booking Confirmed.</div>';
        } else {
            // Handle booking failure
            echo '<div id="paymentMessage" class="message">Payment Failed! Please try again.</div>';
        }
        
        $stmt->close();
    } else {
        // Handle invalid payment details
        echo '<div id="paymentMessage" class="message">Invalid payment details! Please check your information and try again.</div>';
    }

    $conn->close();
}
?>

    </div>
    <script>
        // JavaScript validation functions
        function validateAccountHolderName() {
            var accountholdername = document.getElementById('accountholdername').value;
            var errorDiv = document.getElementById('accountholdernameError');
            if (accountholdername === '') {
                errorDiv.textContent = 'Account holder name cannot be empty.';
            } else {
                errorDiv.textContent = '';
            }
        }

        function validateAccountNo() {
            var accountno = document.getElementById('accountno').value;
            var errorDiv = document.getElementById('accountnoError');
            if (accountno === '') {
                errorDiv.textContent = 'Account number cannot be empty.';
            } else if (!/^\d{9,18}$/.test(accountno)) {
                errorDiv.textContent = 'Invalid account number. Please enter a valid number.';
            } else {
                errorDiv.textContent = '';
            }
        }

        function validateIfsc() {
            var ifsc = document.getElementById('ifsc').value;
            var errorDiv = document.getElementById('ifscError');
            if (ifsc === '') {
                errorDiv.textContent = 'IFSC code cannot be empty.';
            } else if (!/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc)) {
                errorDiv.textContent = 'Invalid IFSC code. Please enter a valid code.';
            } else {
                errorDiv.textContent = '';
            }
        }

        function validateCvv() {
            var cvv = document.getElementById('cvv').value;
            var errorDiv = document.getElementById('cvvError');
            if (cvv === '') {
                errorDiv.textContent = 'CVV cannot be empty.';
            } else if (!/^\d{3}$/.test(cvv)) {
                errorDiv.textContent = 'Invalid CVV. Please enter a valid 3-digit CVV.';
            } else {
                errorDiv.textContent = '';
            }
        }

        function validateExpiryDate() {
            var expirydate = document.getElementById('expirydate').value;
            var errorDiv = document.getElementById('expirydateError');
            if (expirydate === '') {
                errorDiv.textContent = 'Expiry date cannot be empty.';
            } else {
                errorDiv.textContent = '';
            }
        }
    </script>
</body>
</html>
