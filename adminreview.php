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

// Process delete request
if (isset($_GET['delete'])) {
    $review_id = intval($_GET['delete']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM review WHERE review_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $review_id);
        if ($stmt->execute()) {
            echo "<p style='color: green; text-align: center;'>Review deleted successfully!</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error deleting review: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red; text-align: center;'>Prepare failed: " . $conn->error . "</p>";
    }
}

// Process block user request
if (isset($_GET['block'])) {
    $ussrid = intval($_GET['block']);

    // Prepare and execute block query (Assume 'status' column exists in 'user' table)
    $stmt = $conn->prepare("UPDATE user SET status = 'blocked' WHERE ussrid = ?");
    if ($stmt) {
        $stmt->bind_param("i", $ussrid);
        if ($stmt->execute()) {
            echo "<p style='color: green; text-align: center;'>User blocked successfully!</p>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error blocking user: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red; text-align: center;'>Prepare failed: " . $conn->error . "</p>";
    }
}

// Fetch reviews from the database
$sql = "SELECT review_id, ussrid, review_text, rating FROM review ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result === false) {
    die("Error fetching reviews: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Review Management</title>
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
        .btn-delete, .btn-block {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-block {
            background-color: orange;
        }
        .btn-delete:hover, .btn-block:hover {
            background-color: darkred;
        }
        .message {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard - Review Management</h1>

        <table>
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>User ID</th>
                    <th>Review Text</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['review_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['ussrid']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['review_text']) . '</td>';
                        echo '<td>' . str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) . '</td>';
                        echo '<td>';
                        echo '<a href="?delete=' . htmlspecialchars($row['review_id']) . '" class="btn-delete">Delete</a> ';
                        echo '<a href="?block=' . htmlspecialchars($row['ussrid']) . '" class="btn-block">Block User</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No reviews found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
