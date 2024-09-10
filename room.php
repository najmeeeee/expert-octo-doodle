<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
.mySlides {display: none}
</style>
</head>
<body class="w3-content w3-border-left w3-border-right">
<?php
// Database connection
include 'db.php';  // Make sure you have db.php file with database connection details

$availabilityMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkIn = $_POST['CheckIn'];
    $checkOut = $_POST['CheckOut'];
    $roomType = $_POST['room_type'];

    // Handling Search Availability
    if (isset($_POST['search_availability'])) {
        $query = "SELECT * FROM room WHERE room_name='$roomType' AND 
                  (check_in_date <= '$checkOut' AND check_out_date >= '$checkIn')";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 0) {
            $availabilityMessage = "Yes, available";
        } else {
            $availabilityMessage = "No, not available";
        }
    }

    // Handling Proceed (Insert into room table and redirect to booking page)
    if (isset($_POST['proceed'])) {
        $query = "INSERT INTO room (check_in_date, check_out_date, room_name)
                  VALUES ('$checkIn', '$checkOut', '$roomType')";
        if (mysqli_query($conn, $query)) {
            // Redirect to the booking.php page
            header("Location: http://localhost/crest/booking.php");
            exit(); // Make sure to exit after the header to stop further execution
        } else {
            echo "<script>alert('Booking Failed');</script>";
        }
    }
}
?>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-light-grey w3-collapse w3-top" style="z-index:3;width:260px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright"></i>
    <h3>Rental</h3>
    <h3>from $99</h3>
    <h6>per night</h6>
    <hr>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return validateDates()">
      <h4>Check Availability</h4>
      <p><label><i class="fa fa-calendar-check-o"></i> Check In</label></p>
      <input id="checkin" class="w3-input w3-border" type="date" placeholder="YYYY MM DD" name="CheckIn" required>          
      <p><label><i class="fa fa-calendar-o"></i> Check Out</label></p>
      <input id="checkout" class="w3-input w3-border" type="date" placeholder=" YYYY MM DD " name="CheckOut" required>
      
      <!-- Room Type Selection -->
      <p><label><i class="fa fa-home"></i> Select Room Type</label></p>
      <select class="w3-select w3-border" name="room_type" required>
        <option value="" disabled selected>Choose your option</option>
        <option value="Platinum">Platinum</option>
        <option value="Gold">Gold</option>
      </select>
      
      <p><button class="w3-button w3-block w3-green w3-left-align" type="submit" name="search_availability"><i class="fa fa-search w3-margin-right"></i> Search availability</button></p>
      
      <!-- Display availability message here -->
      <?php if (!empty($availabilityMessage)) : ?>
        <p class="w3-text-green"><strong><?php echo $availabilityMessage; ?></strong></p>
      <?php endif; ?>
      
      <p><button class="w3-button w3-block w3-green w3-left-align" type="submit" name="proceed"> Proceed </button></p>
    </form>
    <hr>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <span class="w3-bar-item">Rental</span>
  <a href="javascript:void(0)" class="w3-right w3-bar-item w3-button" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main w3-white" style="margin-left:260px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:80px"></div>

  <!-- Slideshow Header -->
  <div class="w3-container" id="apartment">
    <h2 class="w3-text-green">The Apartments</h2>
    
    <!-- Platinum Apartment Slideshow -->
    <div class="w3-display-container mySlides">
      <img src="/w3images/platinum_livingroom.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Platinum Living Room</p>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="/w3images/platinum_diningroom.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Platinum Dining Room</p>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="/w3images/platinum_bedroom.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Platinum Bedroom</p>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="/w3images/platinum_balcony.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Platinum Balcony</p>
      </div>
    </div>

    <!-- Gold Apartment Slideshow -->
    <div class="w3-display-container mySlides">
      <img src="/w3images/gold_livingroom.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Gold Living Room</p>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="/w3images/gold_diningroom.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Gold Dining Room</p>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="/w3images/gold_bedroom.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Gold Bedroom</p>
      </div>
    </div>
    <div class="w3-display-container mySlides">
      <img src="/w3images/gold_balcony.jpg" style="width:100%;margin-bottom:-6px">
      <div class="w3-display-bottomleft w3-container w3-black">
        <p>Gold Balcony</p>
      </div>
    </div>
  </div>
  
  <div class="w3-row-padding w3-section">
    <!-- Platinum Thumbnails -->
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/platinum_livingroom.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(1)" title="Platinum Living room">
    </div>
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/platinum_diningroom.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(2)" title="Platinum Dining room">
    </div>
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/platinum_bedroom.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(3)" title="Platinum Bedroom">
    </div>
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/platinum_balcony.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(4)" title="Platinum Balcony">
    </div>
  </div>
  
  <div class="w3-row-padding w3-section">
    <!-- Gold Thumbnails -->
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/gold_livingroom.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(5)" title="Gold Living room">
    </div>
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/gold_diningroom.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(6)" title="Gold Dining room">
    </div>
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/gold_bedroom.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(7)" title="Gold Bedroom">
    </div>
    <div class="w3-col s3">
      <img class="demo w3-opacity w3-hover-opacity-off" src="/w3images/gold_balcony.jpg" style="width:100%;cursor:pointer" onclick="currentDiv(8)" title="Gold Balcony">
    </div>
  </div>
  <!-- Apartment Information -->
  <div class="w3-container">
    <h4><strong>Details</strong></h4>
    <div class="w3-row w3-large">
      <div class="w3-col s6">
        <p><i class="fa fa-fw fa-shower"></i> Shower</p>
        <p><i class="fa fa-fw fa-wifi"></i> WiFi</p>
        <p><i class="fa fa-fw fa-tv"></i> TV</p>
      </div>
      <div class="w3-col s6">
        <p><i class="fa fa-fw fa-cutlery"></i> Kitchen</p>
        <p><i class="fa fa-fw fa-thermometer"></i> Heating</p>
        <p><i class="fa fa-fw fa-wheelchair"></i> Accessible</p>
      </div>
    </div>
    <hr>
  </div>
  
<!-- Rules Section -->
<div class="w3-container">
  <h4><strong>Rules</strong></h4>
  <ul class="w3-large">
    <li><i class="fa fa-exclamation-circle"></i> No Smoking in Rooms</li>
    <li><i class="fa fa-exclamation-circle"></i> Check-in after 2:00 PM</li>
    <li><i class="fa fa-exclamation-circle"></i> Check-out by 11:00 AM</li>
    <li><i class="fa fa-exclamation-circle"></i> No Pets Allowed</li>
    <li><i class="fa fa-exclamation-circle"></i> Quiet Hours from 10:00 PM to 8:00 AM</li>
    <li><i class="fa fa-exclamation-circle"></i> ID Required at Check-in</li>
    <li><i class="fa fa-exclamation-circle"></i> Maximum Occupancy: 2 Adults</li>
  </ul>
  <hr>
</div>


<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-opacity-off";
}

function validateDates() {
    var checkInDate = new Date(document.getElementById('checkin').value);
    var checkOutDate = new Date(document.getElementById('checkout').value);
    var today = new Date();
    var oneMonthLater = new Date();
    oneMonthLater.setMonth(today.getMonth() + 1);  // Set one month later

    today.setHours(0, 0, 0, 0);  // Set time to midnight to compare dates only
    oneMonthLater.setHours(0, 0, 0, 0);  // Set time to midnight to compare dates only

    // Check if check-in date is in the past or too far in the future
    if (checkInDate < today) {
        alert("Check-in date cannot be in the past.");
        return false;
    } else if (checkInDate > oneMonthLater) {
        alert("Check-in date cannot be more than one month from today.");
        return false;
    }

    // Check if check-out date is before or the same as the check-in date
    if (checkOutDate <= checkInDate) {
        alert("Check-out date must be after the check-in date.");
        return false;
    }

    // If all checks pass
    return true;
}
</script>

</body>
</html>
