<?php
// Start the session
session_start();
include('db.php');

// SQL query to fetch booking details without userid
$sql = "SELECT booking_id, residents_name, bookingdate, place, no_of_stay, gender, amount, checkin_date, status, description FROM booking";
$result = $conn->query($sql);

// Update booking if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // Update the booking status and description in the database
    $update_sql = "UPDATE booking SET status = ?, description = ? WHERE booking_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $status, $description, $booking_id);
    $stmt->execute();

    // Refresh the page after update
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Crest Home Care</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            padding: 2rem;
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        h1 {
            color: #005f73;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 0.8rem;
            text-align: left;
        }

        th {
            background-color: #005f73;
            color: #fff;
        }

        .back-button {
            display: inline-block;
            margin: 1rem 0;
            padding: 0.5rem 1rem;
            background-color: #005f73;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #003d34;
        }

        .edit-btn {
            color: #005f73;
            cursor: pointer;
        }

        .form-popup {
            display: none;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 1rem;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            border-radius: 8px;
        }

        .form-popup input, .form-popup select {
            margin-bottom: 0.8rem;
            width: 100%;
            padding: 0.5rem;
        }

        .form-popup button {
            padding: 0.5rem 1rem;
            background-color: #005f73;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .form-popup button:hover {
            background-color: #003d34;
        }

        .form-popup .close-btn {
            float: right;
            color: #005f73;
            cursor: pointer;
        }

        .readonly-field {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin.html" class="back-button">Back to Dashboard</a>
        <h1>Booking Details</h1>

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            echo '<table>';
            echo '<tr>
                    <th>Booking ID</th>
                    <th>Resident Name</th>
                    <th>Booking Date</th>
                    <th>Place</th>
                    <th>Number of Stay</th>
                    <th>Gender</th>
                    <th>Amount</th>
                    <th>Check-in Date</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Edit</th>
                  </tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["booking_id"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["residents_name"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["bookingdate"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["place"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["no_of_stay"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["gender"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["amount"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["checkin_date"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["status"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["description"]) . '</td>';
                echo '<td><span class="edit-btn" onclick="openForm(' . $row['booking_id'] . ', \'' . addslashes($row['status']) . '\', \'' . addslashes($row['description']) . '\')">Edit</span></td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No bookings found.</p>';
        }

        $conn->close();
        ?>

        <div class="form-popup" id="editForm">
            <span class="close-btn" onclick="closeForm()">X</span>
            <form method="POST" action="">
                <label for="booking_id">Booking ID:</label>
                <input type="text" id="bookingId" class="readonly-field" readonly name="booking_id" value="">

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Accepted">Accepted</option>
                    <option value="Pending">Pending</option>
                    <option value="Rejected">Rejected</option>
                </select>
                <label for="description">Description:</label>
                <select name="description" id="description">
                    <option value="Confirmed">Confirmed</option>
                    <option value="Pending Confirmation">Pending Confirmation</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openForm(bookingId, status, description) {
            document.getElementById('bookingId').value = bookingId;
            document.getElementById('status').value = status;
            document.getElementById('description').value = description;
            document.getElementById('editForm').style.display = 'block';
        }

        function closeForm() {
            document.getElementById('editForm').style.display = 'none';
        }
    </script>
</body>
</html>
