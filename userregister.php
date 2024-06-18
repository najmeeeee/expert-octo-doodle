<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            background-image: url('pic2.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgb(35, 15, 4, 0.5);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: white;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: transparent;
            color: white;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #e91268;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        select:focus {
            background: pink;
        }

        select option {
            background: black;
            color: white;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var phone = document.getElementById("phone").value;
            var email = document.getElementById("email").value;
            var phonePattern = /^[6-9]\d{9}$/;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            if (!phonePattern.test(phone)) {
                alert("Phone number must be 10 digits and start with 6, 7, 8, or 9.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security
    $gender = $_POST['gender'];
    $place = $_POST['place'];
    $phno = $_POST['phone'];

    $sql = "INSERT INTO registration (fname, lname, email, pass, gender, place, phno) VALUES ('$fname', '$lname', '$email', '$pass', '$gender', '$place', '$phno')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

    <div class="container">
        <form id="registrationForm" method="POST" action="" onsubmit="return validateForm()">
            <h2>Registration</h2>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" minlength="8"required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
            </div>
            <div class="form-group">
                <label for="place">Place</label>
                <input type="text" id="place" name="place" placeholder="Enter your place" required>
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
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
