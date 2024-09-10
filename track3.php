<?php
// Include database connection
include 'db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT status, description FROM booking WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->bind_result($status, $description);

    // Fetch result
    if ($stmt->fetch()) {
        $status_message = htmlspecialchars($status);
        $description_message = htmlspecialchars($description);
    } else {
        $status_message = "No booking found with that ID.";
        $description_message = "";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Tracking</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }

        .container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 100px;
            background: url('path_to_your_image.jpg') no-repeat center center/cover;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            text-align: left;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9fafc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .result h2 {
            color: #17a2b8;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .result p {
            font-size: 1.2rem;
            color: #555;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Track Your Booking</h1>
        <form action="" method="post">
            <label for="booking_id">Enter Booking ID:</label>
            <input type="text" id="booking_id" name="booking_id" required>
            <button type="submit">Check Status</button>
            <a href="klakla.php" class="back-button">Back to Home</a>
        </form>
        <?php
        if (isset($status_message)) {
            echo "<div class='result'>";
            echo "<h2>Status: " . $status_message . "</h2>";
            if (!empty($description_message)) {
                echo "<p>Description: " . $description_message . "</p>";
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
