<?php
session_start();

if (!isset($_SESSION['login_user']) && isset($_COOKIE['login_user'])) {
  $_SESSION['login_user'] = $_COOKIE['login_user'];
}

if (!isset($_SESSION['login_user'])) {
  header("location: s2.php");
  die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .container p {
            color: #666;
            margin-bottom: 40px;
        }
        .container a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0e3202;
            text-decoration: none;
            border-radius: 5px;
        }
        .container a:hover {
            background-color: #e7800a;
        }
    </style>
</head>
<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "miniproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->close();
?>

<body>
    <div class="container">
        <h1>Welcome User</h1>
        <p>You have successfully logged in.</p>
        <a href="slog.php">Logout</a>
    </div>
</body>
</html>
