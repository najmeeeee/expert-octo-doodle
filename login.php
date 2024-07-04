<?php
session_start();

$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$dbname = "miniproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $admin_check = false;

    // Check if the user is a regular user
    $sql = "SELECT * FROM user WHERE email='$email' AND role=2";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) == 0) {
        // Check if the user is an admin
        $sql1 = "SELECT * FROM user WHERE email='$email' AND role=1";
        $query1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($query1) != 0) {
            $admin_check = true;
        } else {
            echo '<script>alert("User not found. Register! ");</script>';
            exit();
        }
    }

    // User password combination check
    if ($admin_check === false) {
        $sql = "SELECT * FROM user WHERE email='$email' AND pass=SHA2('$password',256) AND role=2";
        $query = mysqli_query($conn, $sql);

        if (mysqli_num_rows($query) == 0) {
            echo '<script>alert("Invalid email and password combination! ");</script>';
        } else {
            $user = mysqli_fetch_assoc($query);
            $_SESSION['user_id'] = $user['usrid'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: usrHome.php");
            exit();
        }
    }
    // Admin password combination check
    else {
        $sql1 = "SELECT * FROM user WHERE email='$email' AND pass=SHA2('$password',256) AND role=1";
        $query1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($query1) == 0) {
            echo '<script>alert("Invalid email and password combination! ");</script>';
        } else {
            $admin = mysqli_fetch_assoc($query1);
            $_SESSION['admin_id'] = $admin['usrid'];
            $_SESSION['user_email'] = $admin['email'];
            header("Location: admHome.php");
            exit();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            background-image: url('pic5.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: rgba( 237, 187, 153, 0.5);
            padding: 20px;
            border-radius: 70px 0 70px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            border: 3px solid #BA4A00;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: white;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 3px solid #BA4A00;
            border-radius: 15px 0 15px 0;
            background: transparent;
            color: white;
        }
        .login-box input::placeholder {
            color: white;
            font-weight: bold;
        }
        .login-box input[type="submit"] {
            display: block;
            line-height: 20px;
            height: 10%;
            text-align: center;
            background: #6E2C00;
            border-radius: 25px;
            color: #e5ede3;
            text-transform: uppercase;
            margin-top: 10px;
            letter-spacing: 5px;
            cursor: pointer;
            width: 100%;
        }
        .login-box input[type="submit"]:hover {
            background: #e7800a;
        }
        .pass {
            display: block;
            margin-top: 5px;
            font-weight: bold;
            font-size: 10px;
            color: #0e0d0d;
            text-align: left;
        }
        .sig {
            margin-top: 10px;
            font-family: bold;
            color: #6E2C00;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
                <p>Don't have an account? <a href="http://localhost/crest/demo1.php" class="sig">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
