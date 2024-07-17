<?php
session_start();
include('db.php'); // Include database connection file

if (isset($_COOKIE['login_admin'])) {
    $_SESSION['login_admin'] = $_COOKIE['login_admin'];
    header("Location: admhome.php");
    die();
} elseif (isset($_COOKIE['login_user'])) {
    $_SESSION['login_user'] = $_COOKIE['login_user'];
    header("Location: usehome.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'Roboto', sans-serif;
            color: #ffffff; /* Set default text color */
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
            object-fit: cover;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            
            z-index: 0;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
            z-index: 1;
            position: relative;
        }

        .login-box {
            background: rgba(50, 50, 50, 0.8); /* Dark, semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Box shadow for depth */
            width: 300px; /* Fixed width */
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.2); /* Subtle border */
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #ffffff; /* White text */
            font-size: 1.5em; /* Adjusted font size */
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent white background */
            color: #ffffff; /* White text */
            outline: none;
            transition: background 0.3s, color 0.3s;
        }

        .login-box input[type="text"]::placeholder,
        .login-box input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.6); /* Lighter placeholder color */
            font-weight: bold;
        }

        .login-box input[type="submit"] {
            display: block;
            line-height: 24px;
            height: 40px; /* Adjusted height */
            text-align: center;
            background: #e7800a; /* Orange background color */
            border: none;
            border-radius: 25px;
            color: #ffffff; /* White text */
            text-transform: uppercase;
            margin-top: 20px;
            font-size: 1em; /* Font size adjustment */
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }

        .login-box input[type="submit"]:hover {
            background: #BA4A00; /* Darker orange on hover */
        }

        .login-link {
            margin-top: 20px;
            font-size: 0.9em;
            color: #ffffff; /* White text */
        }

        .login-link a {
            color: #DC7633; /* Lighter orange */
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #e7800a; /* Darker orange on hover */
        }
        .content h1,
.content h2 {
    color: #000000; /* Black text color */
}

    </style>
</head>
<body>
    <video autoplay muted loop class="video-background">
        <source src="vedio.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="overlay"></div>

    <div class="content">
        <h1>Welcome to Crest Home Care Services</h1>
        <h2>Providing Compassionate Care at Home</h2>

        <div class="login-box">
            <h3>Login</h3>
            <form action="login.php" method="post">
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
                <div class="login-link">
                    Don't have an account? <a href="register.php">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
