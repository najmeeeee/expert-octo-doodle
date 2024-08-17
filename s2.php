<?php
session_start();
include('login.php'); // Include database connection file

if (isset($_COOKIE['login_admin'])) {
    $_SESSION['login_admin'] = $_COOKIE['login_admin'];
    header("Location: admhome.php");
    die();
}
elseif (isset($_COOKIE['login_user'])) {
 $_SESSION['login_user'] = $_COOKIE['login_user'];
 header("Location: klakla.php");
 die();
}

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
            <form action="login.php" method="post">
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
                <p>Don't have an account? <a href="http://localhost:80/crest/register.php" class="sig">Sign Up</a></p>
                
            </form>
        </div>
    </div>
</body>
</html>
