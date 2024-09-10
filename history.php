<?php
session_start(); // Start the session

// Include the database connection file
include('db.php');

// Check if the user is logged in by session email
if (!isset($_SESSION['login_user'])) {
    echo "Please log in to view your booking history.";
    exit;
}

$email = $_SESSION['login_user']; // Retrieve the logged-in user's email

// Check if the action is set (view, edit, or cancel)
$action = isset($_GET['action']) ? $_GET['action'] : 'view';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize variables
$booking = [];
$errors = [];
$message = '';

// Retrieve user ID
$sql = "SELECT ussrid FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = intval($row['ussrid']); // user_id
} else {
    echo "User not found.";
    exit;
}

// Handle cancel action
if ($action === 'cancel' && $id) {
    $stmt = $conn->prepare("DELETE FROM booking WHERE booking_id = ? AND ussrid = ?");
    $stmt->bind_param("ii", $id, $user_id); // Bind parameters
    if ($stmt->execute()) {
        $message = 'Booking canceled successfully!';
    } else {
        $errors[] = 'Error canceling booking.';
    }
}

// Handle edit action
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $place = $_POST['place'];
    $gender = $_POST['gender'];
    
    if (!empty($name) && !empty($dob) && !empty($place) && !empty($gender)) {
        $stmt = $conn->prepare("UPDATE booking SET residents_name = ?, checkin_date = ?, place = ?, gender = ? WHERE booking_id = ? AND ussrid = ?");
        $stmt->bind_param("sssiii", $name, $dob, $place, $gender, $id, $user_id); // Bind parameters
        if ($stmt->execute()) {
            $message = 'Booking updated successfully!';
            // Refresh the booking details
            $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = ? AND ussrid = ?");
            $stmt->bind_param("ii", $id, $user_id); // Bind parameters
            $stmt->execute();
            $result = $stmt->get_result();
            $booking = $result->fetch_assoc();
        } else {
            $errors[] = 'Error updating booking.';
        }
    } else {
        $errors[] = 'All fields are required.';
    }
}

// Fetch booking details for editing
if ($action === 'edit' && $id) {
    $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = ? AND ussrid = ?");
    $stmt->bind_param("ii", $id, $user_id); // Bind parameters
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
}

// Fetch all bookings for viewing, but only for the logged-in user
if ($action === 'view') {
    $stmt = $conn->prepare("SELECT * FROM booking WHERE ussrid = ?");
    $stmt->bind_param("i", $user_id); // Bind parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = [];
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
      <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 32px;
            margin-bottom: 40px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f8f8f8;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        button {
            padding: 10px 15px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            width: 150px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #6c757d;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #5a6268;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 40px;
        }

        .photo-grid img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking History</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($errors): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($action === 'view'): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Check-in Date</th>
                        <th>Place</th>
                        <th>Gender</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                                <td><?= htmlspecialchars($booking['residents_name']) ?></td>
                                <td><?= htmlspecialchars($booking['checkin_date']) ?></td>
                                <td><?= htmlspecialchars($booking['place']) ?></td>
                                <td><?= htmlspecialchars($booking['gender']) ?></td>
                                <td>
                                    <a href="?action=edit&id=<?= htmlspecialchars($booking['booking_id']) ?>">Edit</a> |
                                    <a href="?action=cancel&id=<?= htmlspecialchars($booking['booking_id']) ?>" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No bookings found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Photo grid section -->
            <div class="photo-grid">
                <img src="path_to_image1.jpg" alt="Image 1">
                <img src="path_to_image2.jpg" alt="Image 2">
                <img src="path_to_image3.jpg" alt="Image 3">
                <img src="path_to_image4.jpg" alt="Image 4">
            </div>
        <?php elseif ($action === 'edit'): ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($booking['residents_name']) ?>" required>

                <label for="dob">Check-in Date:</label>
                <input type="date" name="dob" value="<?= htmlspecialchars($booking['checkin_date']) ?>" required>

                <label for="place">Place:</label>
                <input type="text" name="place" value="<?= htmlspecialchars($booking['place']) ?>" required>

                <label for="gender">Gender:</label>
                <select name="gender" required>
                    <option value="Male" <?= $booking['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $booking['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= $booking['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>

                <button type="submit">Update Booking</button>
            </form>
        <?php endif; ?>
        
        <a href="klakla.php" class="back-button">Back to Home</a>
    </div>
</body>
</html>
