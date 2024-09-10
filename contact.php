<?php
session_start(); // Ensure session is started

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    die("You must be logged in to contact us.");
}

$servername = "localhost";
$username = "root";
$password = ""; // Your database password
$database = "miniproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user ID from session
$ussrid = $_SESSION['login_user'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phno = trim($_POST['phno']);
    $message = trim($_POST['message']);

    // Insert contact data into the contact table
    $stmt = $conn->prepare("INSERT INTO contact (ussrid, name, email, phno, message) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("issss", $ussrid, $name, $email, $phno, $message);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Your message has been submitted successfully!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch user's contact messages and replies from the database
$sql = "SELECT name, message, reply FROM contact WHERE ussrid = ? ORDER BY cid DESC";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $ussrid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    die("Error fetching messages: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('pic5.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Transparent box */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            border-radius: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #5cb85c;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .message-box {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .message-box h2 {
            margin-top: 0;
        }
        .message-box p {
            margin: 5px 0;
        }
        .reply {
            color: #4cae4c;
            font-weight: bold;
        }
        .home-button {
            margin-top: 20px;
            text-align: center;
        }
        .home-button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }
        .home-button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_email); ?>" required>

            <label for="phno">Phone Number:</label>
            <input type="text" name="phno" id="phno" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit">Submit</button>
        </form>

        <div class="message-box">
            <h2>Your Messages and Replies:</h2>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<p><strong>' . htmlspecialchars($row['name']) . ':</strong> ' . htmlspecialchars($row['message']) . '</p>';
                    if ($row['reply']) {
                        echo '<p class="reply"><strong>CREST HOME CARE:</strong> ' . htmlspecialchars($row['reply']) . '</p>';
                    } else {
                        echo '<p><em>Waiting for reply...</em></p>';
                    }
                    echo '<hr>';
                }
            } else {
                echo '<p>You have not sent any messages yet.</p>';
            }
            ?>
        </div>

        <div class="home-button">
            <a href="klakla.php">Back to Home</a> <!-- Change "index.php" to your actual home page URL -->
        </div>
    </div>
</body>
</html>
