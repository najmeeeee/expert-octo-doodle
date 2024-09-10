<?php
session_start(); // Ensure session is started

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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Print session email
    echo "<p>Session Email: " . htmlspecialchars($_SESSION['login_user'] ?? $_SESSION['login_admin'] ?? 'No session') . "</p>";

    // Check if the user is logged in
    if (!isset($_SESSION['login_user']) && !isset($_SESSION['login_admin'])) {
        echo "<p style='color: red; text-align: center;'>You must be logged in to leave a review.</p>";
    } else {
        // Get form data
        $review_text = trim($_POST['review_text']);
        $rating = intval($_POST['rating']);
        $email = $_SESSION['login_user'] ?? $_SESSION['login_admin'];

        // Debugging: Print form data
        echo "<p>Review Text: " . htmlspecialchars($review_text) . "</p>";
        echo "<p>Rating: " . htmlspecialchars($rating) . "</p>";

        // Fetch user ID based on email
        $sql = "SELECT ussrid FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($ussrid);
        $stmt->fetch();
        $stmt->close();

        // Debugging: Print user ID
        echo "<p>User ID: " . htmlspecialchars($ussrid) . "</p>";

        // Check if user ID was found
        if (!$ussrid) {
            echo "<p style='color: red; text-align: center;'>User not found.</p>";
        } else {
            // Check if user has already submitted a review today
            $sql = "SELECT * FROM review WHERE ussrid = ? AND DATE(created_at) = CURDATE()";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: " . $conn->error);
            }
            $stmt->bind_param("i", $ussrid);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo "<p style='color: red; text-align: center;'>You have already submitted a review today.</p>";
            } else {
                // Insert review into the database
                $stmt = $conn->prepare("INSERT INTO review (ussrid, review_text, rating) VALUES (?, ?, ?)");
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("isi", $ussrid, $review_text, $rating);

                if ($stmt->execute()) {
                    echo "<p style='color: green; text-align: center;'>Your review has been submitted successfully!</p>";
                } else {
                    echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
                }

                $stmt->close();
            }
        }

        $conn->close();

        // Redirect to prevent form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Fetch reviews from the database
$sql = "SELECT ussrid, review_text, rating FROM review ORDER BY created_at DESC";
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
    <title>Review Page</title>
    <style>
        /* Your existing CSS code here */

        .back-to-home {
            display: block;
            margin: 20px auto;
            text-align: center;
        }

        .back-to-home a {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .back-to-home a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="backdrop"></div>

    <div class="review-container">
        <!-- Back to Home Button -->
        <div class="back-to-home">
            <a href="klakla.php">Back to Home</a>
        </div>

        <h1>Customer Reviews</h1>
        <div class="reviews">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="review">';
                    echo '<div class="name">User ID: ' . htmlspecialchars($row['ussrid']) . '</div>';
                    echo '<div class="rating">' . str_repeat('★', $row['rating']) . str_repeat('☆', 5 - $row['rating']) . '</div>';
                    echo '<div class="text">' . htmlspecialchars($row['review_text']) . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No reviews yet. Be the first to leave a review!</p>';
            }
            ?>
        </div>

        <h2>Leave a Review</h2>
        <form action="" method="POST" id="reviewForm">
            <textarea name="review_text" id="review" placeholder="Your Review" required></textarea>

            <div class="rating-container">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">★</label>
            </div>

            <button type="submit">Submit Review</button>
        </form>

        <!-- Back to Home Button at the bottom -->
        
    </div>
</body>
</html>
