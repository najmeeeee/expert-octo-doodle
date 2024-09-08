<?php
session_start(); // Ensure session is started

// Check if the user is an admin
if (!isset($_SESSION['login_admin'])) {
    die("You must be logged in as an admin to view this page.");
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

// Process reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply'])) {
    $cid = intval($_POST['cid']);
    $reply = trim($_POST['reply']);

    // Update the contact table with the admin's reply
    $stmt = $conn->prepare("UPDATE contact SET reply = ? WHERE cid = ?");
    if ($stmt) {
        $stmt->bind_param("si", $reply, $cid);
        if ($stmt->execute()) {
            echo "<p style='color: green; text-align: center;'>Reply has been sent successfully!</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red; text-align: center;'>Prepare failed: " . $conn->error . "</p>";
    }
}

// Fetch contact messages from the database
$sql = "SELECT cid, ussrid, email, phno, message, reply FROM contact ORDER BY cid DESC";
$result = $conn->query($sql);

if ($result === false) {
    die("Error fetching messages: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Contact Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-reply {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-reply:hover {
            background-color: #4cae4c;
        }
        .message {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard - Contact Management</h1>

        <table>
            <thead>
                <tr>
                    <th>Contact ID</th>
                    <th>User ID</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Message</th>
                    <th>Reply</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['cid']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['ussrid']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['phno']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['reply']) . '</td>';
                        echo '<td>';
                        if (empty($row['reply'])) {
                            echo '<form action="" method="POST">';
                            echo '<textarea name="reply" rows="2" placeholder="Your reply here..."></textarea>';
                            echo '<input type="hidden" name="cid" value="' . htmlspecialchars($row['cid']) . '">';
                            echo '<button type="submit" class="btn-reply">Send Reply</button>';
                            echo '</form>';
                        } else {
                            echo 'Replied';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">No messages found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
