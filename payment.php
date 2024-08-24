<?php
// Start the session
session_start();
include('db.php');

// Check if the session variable is set
if (isset($_SESSION['tamount'])) {
    $totalAmount = $_SESSION['tamount'];
} else {
    $totalAmount = 0; // Default value if not set
}
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
    margin-bottom: 100px; /* Add space for the back button */
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
        .back-button-container {
    position: absolute;
    bottom: 10px; /* Adjust this value to position the button closer to the bottom */
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    text-align: center;
}

#backButton {
    padding: 10px 20px;
    background-color:#CF6679;
    color: #121212;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    height: 30px;
    width: auto; /* Adjust width automatically based on content */
}

#backButton:hover {
    background-color: #0056b3;
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
            if (isset($_SESSION['tamount'])) {
                echo "Total Amount: ₹" . htmlspecialchars($_SESSION['tamount']);
            } else {
                echo "Total Amount: ₹0"; // Default message if no amount is set
            }
            ?>
        </div>

        <form id="paymentForm" method="POST" action="">
            <label for="accountholdername">Account Holder Name:</label>
            <input type="text" id="accountholdername" name="accountholdername" oninput="validateAccountHolderName()" required>
            <div id="accountholdernameError" class="error"></div>

           

            <label for="accountno">Account Number:</label>
            <input type="text" id="accountno" name="accountno" oninput="validateAccountNo()"  required>
            <div id="accountnoError" class="error"></div>

            <label for="ifsc">IFSC Code:</label>
            <input type="text" id="ifsc" name="ifsc" oninput="validateIfsc()"  required>
            <div id="ifscError" class="error"></div>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" oninput="validateCvv()"  required>
            <div id="cvvError" class="error"></div>

            <label for="expirydate">Expiry Date:</label>
            <input type="date" id="expirydate" name="expirydate" oninput="validateExpiryDate()"  required>
            <div id="expirydateError" class="error"></div>

            <button type="submit" name="submit">Submit Payment</button>
        </form>
        <div id="paymentMessage" class="message"></div>
    
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
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
     $stmt1->close();
    // Check if the entered details match any record in the 'bank' table
    $stmt2 = $conn->prepare("SELECT * FROM bank WHERE account_holder_name = ? AND accountno = ? AND ifsc = ? AND cvv = ? AND expirydate = ?");
    $stmt2->bind_param("sssss", $accountholdername, $accountno, $ifsc, $cvv, $expirydate);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    if ($row2 = $result2->fetch_assoc()) {
            $amt=$row2['balance']; 
           
            
           
        // Prepare and bind booking statement
        $currentDate = date("Y-m-d");
        $stmt3 = $conn->prepare("INSERT INTO booking (residents_name, ussrid, bookingdate, place, no_of_stay, gender, amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt3->bind_param("sissisi", $_SESSION['residentName'], $u_id, $currentDate, $_SESSION['place'], $_SESSION['days'], $_SESSION['gender'], $_SESSION['tamount']);
           if ($stmt3->execute()) {
              //  echo"booking ibsertion executed";
            }
             $stmt3->close();
              $stmt2->close();
      $stmt4 = $conn->prepare("SELECT booking_id FROM booking WHERE bookingdate = ? AND ussrid = ?");
$stmt4->bind_param("si", $currentDate, $u_id);
$stmt4->execute(); // Ensure the query is executed
$result4 = $stmt4->get_result();

if ($row4 = $result4->fetch_assoc()) {
    $b_id = $row4['booking_id']; // Corrected the key 'booking_id' without the extra space
   $stmt4->close();
}

   // Close the statement after use

        // Prepare and bind booking statement
        $stmt5 = $conn->prepare("INSERT INTO orgtransaction (booking_id,transaction_date,credited_amount,name) VALUES (?, ?, ?, ?)");
        $stmt5->bind_param("isis",$b_id,$currentDate,$_SESSION['tamount'],$accountholdername);
        
            // Execute the booking statement
            if ($stmt5->execute()) {
               // echo" org transaction insertion executed";
           $stmt5->close();
        // Execute the booking statement
       
            // Retrieve the last inserted booking details
          
            $stmt6 = $conn->prepare("SELECT residents_name, bookingdate, place, no_of_stay, gender, amount FROM booking WHERE booking_id = ?");
            $stmt6->bind_param("i", $b_id);
            $stmt6->execute();
            $result6 = $stmt6->get_result();

            if ($row6 = $result6->fetch_assoc()) {
                // Display the booking details
                echo '<div class="booking-details">';
                echo '<h2>Booking Details</h2>';
                echo '<p><strong>Resident Name:</strong> ' . htmlspecialchars($row6['residents_name']) . '</p>';
                echo '<p><strong>Booking date:</strong> ' . htmlspecialchars($row6['bookingdate']) . '</p>';
                echo '<p><strong>Place:</strong> ' . htmlspecialchars($row6['place']) . '</p>';
                echo '<p><strong>Number of Days:</strong> ' . htmlspecialchars($row6['no_of_stay']) . '</p>';
                echo '<p><strong>Gender:</strong> ' . htmlspecialchars($row6['gender']) . '</p>';
                echo '<p><strong>Total Amount:</strong> ₹' . htmlspecialchars($row6['amount']) . '</p>';
                echo ' </div>';
             

                      
       $stmt6->close();

                $newamt=$amt-$_SESSION['tamount'];
                $stmt7 = $conn->prepare("UPDATE  bank set balance = ? WHERE account_holder_name = ? AND accountno = ? AND ifsc = ? AND cvv = ? AND expirydate = ?");
            $stmt7->bind_param("isssss", $newamt, $accountholdername, $accountno, $ifsc, $cvv, $expirydate);
            if($stmt7->execute())
            {
                 $stmt7->close();
               // echo" balance updation successfully";
            }
            }

            // Confirm the payment success
            echo '<div id="paymentMessage" class="message">Payment Successful! Booking Confirmed.</div>';
        } else {
            // Handle booking failure
            echo '<div id="paymentMessage" class="message">Payment Failed! Please try again.</div>';
        }

    } else {
        // Handle invalid payment details
        echo '<div id="paymentMessage" class="message">Invalid payment details! Please check your information and try again.</div>';
    }

    
      
    $conn->close();

}
?>
<div class="back-button-container">
            <button id="backButton" onclick="window.location.href='klakla.php'">Back</button>
        </div>
    </div>
    </div>
    <script>
        // JavaScript validation functions
        function validateAccountHolderName() {
            var accountholdername = document.getElementById('accountholdername').value;
            var errorDiv = document.getElementById('accountholdernameError');
            if (accountholdername === '') {
                errorDiv.textContent = 'Account name should be in letters.';
            } else {
                errorDiv.textContent = '';
            }
        }

        function validateAccountNo() {
            var accountno = document.getElementById('accountno').value;
            var errorDiv = document.getElementById('accountnoError');
            if (accountno === '') {
                errorDiv.textContent = 'Account number should be 10 digits.';
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
    } else if (!/^[A-Za-z0-9]{7}$/.test(ifsc)) {
        errorDiv.textContent = 'Invalid IFSC code. Please enter exactly 7 characters (alphabets and numbers).';
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
    <div class="back-button-container">
    <button id="backButton" onclick="window.location.href='klakla.php'">Back</button>
</div>  


</body>
</html>
