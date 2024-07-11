<?php
// Start the session at the very beginning
session_start();

// Database connection parameters
$host = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "miniproject";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX request for email check
if (isset($_POST['email_check'])) {
    $email = $_POST['email'];
    $query = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "taken";
    } else {
        echo "not_taken";
    }
    exit();
}

// Handle AJAX request for phone number check
if (isset($_POST['phone_check'])) {
    $phone = $_POST['phone'];
    $query = "SELECT * FROM user WHERE phno='$phone'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo "taken";
    } else {
        echo "not_taken";
    }
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $pass = $_POST['password']; // Plain password from form
    $hashed_password = hash('sha256', $pass); // Hash the password
    $gender = $_POST['gender'];
    $place = $_POST['place'];
    $phno = $_POST['phone'];
    $dob = $_POST['date']; // Capture the registration date from the form
    $role = 2; // Default role as user

    // Check for unique email and phone number
    $checkUnique = "SELECT * FROM user WHERE email='$email' OR phno='$phno'";
    $result = $conn->query($checkUnique);

    if ($result === false) {
        echo "<script>alert('Database query error: " . $conn->error . "');</script>";
    } elseif ($result->num_rows > 0) {
        echo "<script>alert('Email or phone number already exists. Please use a different email or phone number.');</script>";
    } else {
        // Insert user into database
        $sql = "INSERT INTO user (fname, lname, email, pass, role, gender, place, Dob, phno) 
                VALUES ('$fname', '$lname', '$email', '$hashed_password', '$role', '$gender', '$place', '$dob', '$phno')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            background-image: url('pic4.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(35, 15, 4, 0.4);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
            font-weight: bold;
            font-size: 12px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="date"],
        select {
            width: calc(100% - 20px);
            padding: 8px;
            box-sizing: border-box;
            border: 2px solid #fff; /* Thicker border */
            border-radius: 4px;
            background: transparent;
            color: white;
            font-size: 12px;
        }

        button {
            width: 100%;
            padding: 8px;
            background-color: #DC7633;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 14px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.9); /* Brighter placeholder */
            font-size: 12px;
        }

        select:focus {
            background: white;
            color: #DC7633;
        }

        select option {
            background: white;
            color: black;
        }

        select:active {
            background: white;
        }

        select option:checked {
            background: transparent;
            color: black;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #FFFF00;
            font-size: 10px; /* Adjusted font size for error messages */
            display: inline-block; /* Display inline to avoid elongating the form */
            margin-left: 5px; /* Margin to separate from input field */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            var typingTimer;
            var doneTypingInterval = 500; // milliseconds - adjust as needed

            $('#email').on('input', function(){
                clearTimeout(typingTimer);
                typingTimer = setTimeout(checkEmail, doneTypingInterval);
            });

            function checkEmail() {
                var email = $('#email').val();
                if (email == '') {
                    return;
                }
                $.ajax({
                    url: 'register.php',
                    type: 'post',
                    data: {
                        'email_check' : 1,
                        'email' : email,
                    },
                    success: function(response){
                        var emailError = $('#emailError');
                        if (response == 'taken' ) {
                            emailError.text('Sorry... Email already taken');
                            emailError.css('display', 'block');
                        } else if (response == 'not_taken') {
                            emailError.css('display', 'none');
                        }
                    }
                });
            }

            $('#phone').on('blur', function(){
                var phone = $('#phone').val();
                if (phone == '') {
                    return;
                }
                $.ajax({
                    url: 'register.php',
                    type: 'post',
                    data: {
                        'phone_check' : 1,
                        'phone' : phone,
                    },
                    success: function(response){
                        var phoneError = $('#phoneError');
                        if (response == 'taken' ) {
                            phoneError.text('Sorry... Phone number already taken');
                            phoneError.css('display', 'block');
                        } else if (response == 'not_taken') {
                            phoneError.css('display', 'none');
                        }
                    }
                });
            });
        });

        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var passwordError = document.getElementById("passwordError");
            var confirmPasswordError = document.getElementById("confirmPasswordError");

            if (password.length < 8) {
                passwordError.textContent = "Password must be at least 8 characters long.";
                passwordError.style.display = "block";
            } else {
                passwordError.style.display = "none";
            }

            if (password !== confirmPassword && confirmPassword !== "") {
                confirmPasswordError.textContent = "Passwords do not match.";
                confirmPasswordError.style.display = "block";
            } else {
                confirmPasswordError.style.display = "none";
            }
        }

        function validatePhone() {
            var phone = document.getElementById("phone").value;
            var phonePattern = /^[6-9]\d{9}$/;
            var phoneError = document.getElementById("phoneError");

            if (!phonePattern.test(phone)) {
                phoneError.textContent = "Phone number must be 10 digits and start with 6, 7, 8, or 9.";
                phoneError.style.display = "block";
            } else {
                phoneError.style.display = "none";
            }
        }

        function validateEmail() {
            var email = document.getElementById("email").value;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var emailError = document.getElementById("emailError");

            if (!emailPattern.test(email)) {
                emailError.textContent = "Please enter a valid email address.";
                emailError.style.display = "block";
            } else {
                emailError.style.display = "none";
            }
        }

        function validateName(id, errorId) {
            var name = document.getElementById(id).value;
            var namePattern = /^[A-Za-z]+$/;
            var nameError = document.getElementById(errorId);

            if (!namePattern.test(name)) {
                nameError.textContent = "Name must contain only letters.";
                nameError.style.display = "block";
            } else {
                nameError.style.display = "none";
            }
        }

        function validatePlace() {
            var place = document.getElementById("place").value;
            var placePattern = /^[A-Za-z]+$/;
            var placeError = document.getElementById("placeError");

            if (!placePattern.test(place)) {
                placeError.textContent = "Place must contain only letters.";
                placeError.style.display = "block";
            } else {
                placeError.style.display = "none";
            }
        }

        function validateDate() {
            var dateInput = document.getElementById("date").value;
            var dateError = document.getElementById("dateError");
            var today = new Date();
            var inputDate = new Date(dateInput);

            if (inputDate > today) {
                dateError.textContent = "Enter a valid year.";
                dateError.style.display = "block";
                return false;
            } else {
                dateError.style.display = "none";
                return true;
            }
        }

        function validateForm() {
            validatePassword();
            validatePhone();
            validateEmail();
            validateName('firstName', 'firstNameError');
            validateName('lastName', 'lastNameError');
            validatePlace();
            var isDateValid = validateDate();

            var passwordError = document.getElementById("passwordError").style.display;
            var confirmPasswordError = document.getElementById("confirmPasswordError").style.display;
            var phoneError = document.getElementById("phoneError").style.display;
            var emailError = document.getElementById("emailError").style.display;
            var firstNameError = document.getElementById("firstNameError").style.display;
            var lastNameError = document.getElementById("lastNameError").style.display;
            var placeError = document.getElementById("placeError").style.display;

            return passwordError === "none" && confirmPasswordError === "none" && phoneError === "none" && emailError === "none" && firstNameError === "none" && lastNameError === "none" && placeError === "none" && isDateValid;
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            var dateInput = document.getElementById("date");
            var today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('max', today);

            dateInput.addEventListener('change', validateDate);
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Registration Form</h2>
        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required oninput="validateName('firstName', 'firstNameError')">
                <div id="firstNameError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required oninput="validateName('lastName', 'lastNameError')">
                <div id="lastNameError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required oninput="validateEmail()">
                <div id="emailError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" minlength="8" required oninput="validatePassword()">
                <div id="passwordError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required oninput="validatePassword()">
                <div id="confirmPasswordError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required oninput="validatePhone()">
                <div id="phoneError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>Select your gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="place">Place</label>
                <input type="text" id="place" name="place" placeholder="Enter your place" required oninput="validatePlace()">
                <div id="placeError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="date">Date of Birth</label>
                <input type="date" id="date" name="date" required>
                <div id="dateError" class="error-message"></div>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
