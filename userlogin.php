<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            background-image: url('photo1.jpg');
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
            background: rgba(185, 232, 142, 0.5);
            padding: 20px;
            border-radius: 70px 0 70px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            border: 3px solid #0e3202;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #0e3202;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 3px solid #0e3202;
            border-radius: 15px 0 15px 0;
            background: transparent;
        }
        .login-box input::placeholder {
            color: #040404ca;
            font-weight: bold;
        }
        .login-box input[type="submit"] {
            display: block;
            line-height: 20px;
            height: 10%;
            text-align: center;
            background: #0e3202;
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
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Login</h2>
            <?php
            session_start(); // Start PHP session

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                $email = $_POST['email'];
                $password = $_POST['password'];

                // Prepare and bind
                if ($stmt = $conn->prepare("SELECT userid, pass FROM registration WHERE email = ?")) {
                    $stmt->bind_param("s", $email);

                    // Execute the query
                    $stmt->execute();

                    // Bind the result to variables
                    $stmt->bind_result($userid, $hashed_password);

                    // Fetch the result
                    if ($stmt->fetch()) {
                        // Verify the password
                        if (password_verify($password, $hashed_password)) {
                            // Login successful
                            $_SESSION['userid'] = $userid; // Store user ID in session
                            echo "<p>Login successful!</p>";

                            // Optionally set a cookie for persistent login
                            $cookie_name = "userid";
                            $cookie_value = $userid;
                            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 30 days

                            // Redirect to a protected page if needed
                            // header("Location: protected_page.php");
                            // exit();
                        } else {
                            echo "<p>Invalid email or password.</p>";
                        }
                    } else {
                        echo "<p>Invalid email or password.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Failed to prepare statement: " . $conn->error . "</p>";
                }

                $conn->close();
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#" class="pass">Forgot Password?</a>
                <input type="submit" value="Login">
                <p>Don't have an account? <a href="http://localhost:8080/crest/userregister.php" class="sig">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
