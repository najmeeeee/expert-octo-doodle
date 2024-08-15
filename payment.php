
You said:
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

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob">

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
            $dob = $_POST['dob'];
            $accountno = $_POST['accountno'];
            $ifsc = $_POST['ifsc'];
            $cvv = $_POST['cvv'];
            $expirydate = $_POST['expirydate'];

            // Check if the entered details match any record in the 'bank' table
            $stmt = $conn->prepare("SELECT * FROM bank WHERE account_holder_name = ? AND accountno = ? AND ifsc = ? AND cvv = ? AND expirydate = ?");
            $stmt->bind_param("sssss", $accountholdername, $accountno, $ifsc, $cvv, $expirydate);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Insert the payment details into the 'booking' table
                $stmt = $conn->prepare("INSERT INTO booking (residents_name, dob, place, no_of_stay, gender, amount) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $accountholdername, $dob, $_SESSION['place'], $_SESSION['no_of_stay'], $_SESSION['gender'], $_SESSION['totalAmount']);
                $stmt->execute();
                $stmt->close();

                // Display booking details and action buttons
                echo '<div class="booking-details">';
                echo '<h2>Booking Details</h2>';
                echo '<p><strong>Resident Name:</strong> ' . htmlspecialchars($accountholdername) . '</p>';
                echo '<p><strong>Date of Birth:</strong> ' . htmlspecialchars($dob) . '</p>';
                echo '<p><strong>Place:</strong> ' . htmlspecialchars($_SESSION['place']) . '</p>';
                echo '<p><strong>Number of Days:</strong> ' . htmlspecialchars($_SESSION['no_of_stay']) . '</p>';
                echo '<p><strong>Gender:</strong> ' . htmlspecialchars($_SESSION['gender']) . '</p>';
                echo '<p><strong>Total Amount:</strong> ₹' . htmlspecialchars($_SESSION['totalAmount']) . '</p>';
                echo '<div class="action-buttons">';
                echo '<button class="pay-now" onclick="window.location.href=\'confirmation.php\'">Pay Now</button>';
                echo '<button class="cancel" onclick="window.location.href=\'index.php\'">Cancel</button>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="message error">Payment details are incorrect or account does not exist.</div>';
            }

            $conn->close();
        }
        ?>

        <script>
            function validateAccountHolderName() {
                const name = document.getElementById('accountholdername').value;
                const nameError = document.getElementById('accountholdernameError');
                if (name.trim() === '') {
                    nameError.textContent = 'Account Holder Name is required.';
                } else {
                    nameError.textContent = '';
                }
            }

            function validateAccountNo() {
                const accountNo = document.getElementById('accountno').value;
                const accountNoError = document.getElementById('accountnoError');
                if (accountNo.trim() === '') {
                    accountNoError.textContent = 'Account Number is required.';
                } else {
                    accountNoError.textContent = '';
                }
            }

            function validateIfsc() {
                const ifsc = document.getElementById('ifsc').value;
                const ifscError = document.getElementById('ifscError');
                const ifscPattern = /^[A-Z0-9]{11}$/;
                if (!ifscPattern.test(ifsc)) {
                    ifscError.textContent = 'IFSC Code must be 11 characters (letters and digits).';
                } else {
                    ifscError.textContent = '';
                }
            }

            function validateCvv() {
                const cvv = document.getElementById('cvv').value;
                const cvvError = document.getElementById('cvvError');
                const cvvPattern = /^[0-9]{3}$/;
                if (!cvvPattern.test(cvv)) {
                    cvvError.textContent = 'CVV must be exactly 3 digits.';
                } else {
                    cvvError.textContent = '';
                }
            }

            function validateExpiryDate() {
                const expiryDate = document.getElementById('expirydate').value;
                const expiryDateError = document.getElementById('expirydateError');
                if (expiryDate.trim() === '') {
                    expiryDateError.textContent = 'Expiry Date is required.';
                } else {
                    expiryDateError.textContent = '';
                }
            }
        </script>
    </div>
</body>