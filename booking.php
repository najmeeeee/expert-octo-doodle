<?php
// Start the session
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store total amount in session
    $_SESSION['residentName'] = $_POST['residentName'];
    $days = $_POST['days'];
    $rtype = $_POST['roomtype'];

    if ($rtype == "Platinum") {
        $amt = 150 * $days;
    } else {
        $amt = 100 * $days;
    }
    $_SESSION['tamount'] = $amt;
    $_SESSION['days'] = $days;
    $_SESSION['place'] = $_POST['place'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['checkin']=$_POST['checkin'];

    header("location: payment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crest Home Care Booking</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F5F5;
            margin: 0;
            padding: 0;
            color: #444;
        }

        .video-section {
            width: 100%;
            height: 50vh;
            position: relative;
            overflow: hidden;
        }

        #backgroundVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .video-section .content {
            position: relative;
            z-index: 1;
            color: #FFF;
            text-align: center;
            padding: 20px;
        }

        .video-section h1, .video-section h2, .video-section p {
            margin: 0;
        }

        .container {
            width: 70%;
            margin: 20px auto;
            background: #b87f89;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        h1, h2 {
            text-align: center;
            color: #1E1E1E;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .room-selection {
            text-align: center;
            margin-bottom: 40px;
        }

        .room-options {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .room {
            width: 200px;
            padding: 15px;
            border: 2px solid #1E1E1E;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            background-color: #F5F5F5;
        }

        .room.selected {
            background-color: #1E1E1E;
            color: #FFF;
        }

        .room img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .room:hover img {
            transform: scale(1.05);
        }

        .room h3 {
            margin-top: 15px;
            font-size: 1.2em;
            color: inherit;
        }

        .room p {
            color: inherit;
            font-weight: bold;
            font-size: 1.1em;
        }

        .booking-form {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            transition: border-color 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #1E1E1E;
            outline: none;
        }

        .total-section {
            text-align: center;
            margin-top: 30px;
        }

        h3 {
            color: #1E1E1E;
            font-weight: 600;
        }

        .total-amount {
            font-size: 1.8em;
            font-weight: 700;
            color: #03DAC6;
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #CF6679;
            color: #121212;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: #B00020;
            transform: translateY(-3px);
        }

        .proceed-button {
            background-color: #CF6679;
            margin-top: 20px;
        }

        .proceed-button:hover {
            background-color: #B00020;
        }

        .error {
            color: #FFFFFF;
            font-size: 0.9em;
            margin-top: -15px;
            margin-bottom: 10px;
            display: none;
            font-style: italic;
        }

        .room-description {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .description {
            width: 45%;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .description h3 {
            margin: 0;
            font-size: 1.5em;
            color: #1E1E1E;
        }

        .description p {
            margin: 10px 0;
            font-size: 1em;
            color: #666;
        }

        .error.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="video-section">
        <video autoplay muted loop id="backgroundVideo">
            <source src="bveido.mov" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="content">
            <h1>Crest Home Care</h1>
            <h2>Your Comfort, Our Priority</h2>
            <p>Providing compassionate and quality care for your loved ones.</p>
        </div>
    </div>

    <div class="container">
        <h1>Book Your Ideal Apartment</h1>
        
        <div class="room-selection">
            <h2>Choose Your Room Type</h2>
            <div class="room-options">
                <div class="room">
                    <img src="platinum.jpg" alt="Platinum Room">
                    <h3>Platinum Room</h3>
                    <p>$150 per day</p>
                </div>
                <div class="room">
                    <img src="gold.jpg" alt="Gold Room">
                    <h3>Gold Room</h3>
                    <p>$100 per day</p>
                </div>
            </div>
        </div>

        <div class="room-description">
            <div class="description">
                <h3>Platinum Room</h3>
                <p>The Platinum Room offers the highest level of comfort and luxury. Enjoy premium amenities, including a spacious layout, premium furnishings, and enhanced privacy features. Perfect for those seeking an unparalleled experience.</p>
            </div>
            <div class="description">
                <h3>Gold Room</h3>
                <p>The Gold Room provides a balanced blend of comfort and value. Featuring a cozy atmosphere with essential amenities, this option is ideal for residents looking for quality care without the extra frills.</p>
            </div>
        </div>

        <div id="bookingContainer">
            <h2>Complete Your Booking</h2>
            <div class="booking-form">
                <form method="POST" action="">
                    <label for="residentName">Resident's Name</label>
                    <input type="text" id="residentName" name="residentName" required>
                    <div id="nameError" class="error">Please enter a valid name (letters only).</div>

                    <label for="place">Place</label>
                    <input type="text" id="place" name="place" required>
                    <div id="placeError" class="error">Place must contain only letters and spaces.</div>

                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="roomtype">Room Type</label>
                    <select id="roomtype" name="roomtype" required>
                        <option value="Platinum">Platinum</option>
                        <option value="Gold">Gold</option>
                    </select>

                    <label for="days">Number of Days</label>
                    <input type="number" id="days" name="days" required>
                    <div id="daysError" class="error">Number of days should be a positive number.</div>
                     <label for="checkin">Check-in Date:</label>
        <input type="date" id="checkin" name="checkin">
        <div id="checkinError" class="error"></div>
                    <button type="submit">Book Now</button>
                </form>
            </div>
        </div>

      
    </div>

    <script>
        function validateName(id, errorId) {
            var name = document.getElementById(id).value;
            var namePattern = /^[A-Za-z]+$/;
            var nameError = document.getElementById(errorId);

            if (!namePattern.test(name)) {
                nameError.textContent = "Name must contain only letters.";
                nameError.classList.add("show");
            } else {
                nameError.classList.remove("show");
            }
        }

        function validatePlace() {
            var place = document.getElementById("place").value;
            var placePattern = /^[A-Za-z\s]+$/;
            var placeError = document.getElementById("placeError");

            if (!placePattern.test(place)) {
                placeError.textContent = "Place must contain only letters and spaces.";
                placeError.classList.add("show");
            } else {
                placeError.classList.remove("show");
            }
        }

        function validateDays() {
            var days = document.getElementById("days").value;
            var daysError = document.getElementById("daysError");

            if (days <= 0 || isNaN(days)) {
                daysError.textContent = "Number of days should be a positive number.";
                daysError.classList.add("show");
            } else {
                daysError.classList.remove("show");
            }
        }
        document.getElementById("checkin").addEventListener("input", function () {
    var checkinDate = new Date(this.value),
        today = new Date(),
        futureLimit = new Date(today.setDate(today.getDate() + 30)),
        errorMsg = "";

    if (checkinDate < new Date()) {
        errorMsg = "Check-in date cannot be in the past.";
    } else if (checkinDate > futureLimit) {
        errorMsg = "Check-in date cannot be more than 30 days in the future.";
    }

    document.getElementById("checkinError").textContent = errorMsg;
    document.getElementById("checkinError").classList.toggle("show", errorMsg !== "");
});


        document.getElementById("residentName").addEventListener("input", function() {
            validateName("residentName", "nameError");
        });

        document.getElementById("place").addEventListener("input", validatePlace);

        document.getElementById("days").addEventListener("input", validateDays);

        document.getElementById("roomtype").addEventListener("change", function() {
            var roomType = document.getElementById("roomtype").value;
            var days = document.getElementById("days").value;
            var totalAmount = 0;

            if (roomType === "Platinum") {
                totalAmount = 150 * days;
            } else if (roomType === "Gold") {
                totalAmount = 100 * days;
            }

            document.getElementById("totalAmount").textContent = "$" + totalAmount.toFixed(2);
        });

        document.getElementById("days").addEventListener("input", function() {
            var days = document.getElementById("days").value;
            var roomType = document.getElementById("roomtype").value;
            var totalAmount = 0;

            if (roomType === "Platinum") {
                totalAmount = 150 * days;
            } else if (roomType === "Gold") {
                totalAmount = 100 * days;
            }

            document.getElementById("totalAmount").textContent = "$" + totalAmount.toFixed(2);
        });
    </script>
</body>
</html>
