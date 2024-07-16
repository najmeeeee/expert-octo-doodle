<?php

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
            $_SESSION['login_user'] = $user['email'];
            setcookie("login_user", $username, time() + (86400 * 30), "/"); // 30 days expiration

            header("Location: usehome.php");
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
    
            $_SESSION['login_user'] = $admin['email'];
            setcookie("login_admin", $username, time() + (86400 * 30), "/"); // 30 days expiration
            header("Location: admhome.php");
        }
    }
}

?>

