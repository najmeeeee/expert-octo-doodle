
<?php
session_start();

if (!isset($_SESSION['login_user']) && isset($_COOKIE['login_user'])) {
  $_SESSION['login_user'] = $_COOKIE['login_user'];
}

if (!isset($_SESSION['login_user'])) {
  header("location: login.php");
  die();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Rent a house</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <style>
    .img-container img {
      width: 100%;
      height: auto;
      display: block;
      margin: auto;
    }
    .img-container {
      text-align: center;
    }
    .modal-body img {
      width: 100%;
      height: auto;
    }
    .welcome-section {
      background: url('pic3.jpg') no-repeat center center;
      background-size: cover;
      color: white;
      padding: 50px 0;
    }
    .welcome-section h1, .welcome-section h2 {
      color: white;
    }
    .text-center {
      text-align: center;
    }
    .img-container img {
      margin: 10px;
    }
    h3 {
      margin-bottom: 20px;
    }
    .why-us .img-container {
      margin-left: 120px;
      /* Space from the border */
    }
    /* Center logo in the 'Where does it come from' section */
    .second {
      max-width: 50%; /* Adjusted size */
      margin: auto; /* Center the section */
      padding: 20px; /* Optional: Adjust padding if needed */
    }
    .second .img-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    /* Specific logo size adjustment */
    .second .img-container img {
      width: 15%; /* Adjusted size */
    }
    .why-us h3 {
      margin-top: 30px; /* Adjust this value to control how far down the heading moves */
    }
    .why-us p {
      margin-top: 15px; /* Adjust this value to control how far down the paragraph moves */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-sm row container">
    <div class="col-12 col-md-12 col-lg-6 col-sm-4 text-right">
      <a class="navbar-brand" href="#">
        <img src="logo.jpg" alt="logo" style="width: 30%;">
      </a>
    </div>
    <div>
      <ul class="navbar-nav menu">
        <li class="nav-item">
          <a class="nav-link" href="am.html">AMENITIES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="team.html">| TEAM </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="roomf.php">| BOOKING </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="review.php">| REVIEW</a>
        </li>
           <li class="nav-item">
          <a class="nav-link" href="track3.php">| TRACKS
          </a>
          </li>
           <li class="nav-item">
          <a class="nav-link" href="history.php">| history
          </a></li>
           <li class="nav-item">
          <a class="nav-link" href="contact.php">| CONTACT
          </a>
          </li>
           <li class="nav-item">
          <a class="nav-link" href="logssession.php">| LOGOUT
          </a>
       
      </ul>
    </div>
  </nav>
  <div class="main">
    <div class="row jumbotron welcome-section">
      <div class="col-12 col-md-4 text text-center container">
        <h1><small>WELCOME</small></h1>
        <span><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></span>
        <h2><small>Crest Home Care<br> Your Home, Our Care</small></h2><br>
        <br>
        <br>
        <!-- The Modal -->
        <div class="modal" id="modalone">
          <div class="modal-dialog">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title text-center">What is Lorem Ipsum?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="modal-body text-justify">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <div class="row">
                  <div class="col-12 col-md-6 col-lg-6">
                    <img src="pic3.jpg" alt="Image">
                  </div>
                  <div class="col-12 col-md-6 col-lg-6">
                    <img src="pic3.jpg" alt="Image">
                  </div>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn w3-flat-sun-flower" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="second">
    <div style="height:450px;width:750px" class="container jumbotron text-center">
      <h2 class="text-center">Where does it come from</h2><br>
      <div class="img-container">
        <img src="logo1.png" alt="logo">
      </div>
      <br><br>
      <p class="text-center">
       The idea for the Crest home care management system evolved from the need to merge technology with comprehensive care services. It began with the goal of simplifying the process for users to find and manage care homes, while also offering robust tools for administrators to efficiently oversee operations and ensure personalized care.
      </p>
    </div>
  </div>
  <div class="row third">
    <div class="col-12 col-md-12 col-lg-3">
      <div class="img-container">
        <img src="homebox5.jpg" alt="Image">
      </div>
      <div class="container w3-flat-midnight-blue">
        <br>
        <h4 class="text-center text-uppercase"><small>Home Haven</small></h4>
        <br>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-3">
      <div class="img-container">
        <img src="homebox6.jpg" alt="Image">
      </div>
      <div class="container w3-flat-nephritis">
        <br>
        <h4 class="text-center text-uppercase"><small>Caring Comfort</small></h4>
        <br>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-3">
      <div class="img-container">
        <img src="homebox3.jpg" alt="Image">
      </div>
      <div class="container w3-flat-midnight-blue">
        <br>
        <h4 class="text-center text-uppercase"><small>Sweet Hospitality</small></h4>
        <br>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-3">
      <div class="img-container">
        <img src="homebox4.jpeg" alt="Image">
      </div>
      <div class="container w3-flat-nephritis">
        <br>
        <h4 class="text-center text-uppercase"><small>Artfull Adobe</small></h4>
        <br>
      </div>
    </div>
  </div>
  <div class="row why-us justify-content-center text-center">
    <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
      <div class="img-container">
        <img src="whyus5.jpg" style="width:70%">
        <img src="whyus4.jpg" style="width:70%">
        <img src="whyus6.jpeg" style="width:70%">
      </div>
    </div>
    <div class="col-12 col-md-4 text-center">
      <h3 style="color:#16a085!important">Why choose us?</h3>
      <p>
The Crest home care management system is a  platform designed to indulge in old dreams and discover new passion.
The crest provides seamless experience for the users to  effortlessly choose their  ideal apartments with just a tap.
The administrators manage and oversee facility operations effectively. We provide round-the-clock care and support including assistance
with tasks such as dressing ,medication management and meals. Ambulance on  call, doctor on call and 24 hour nursing support  highlights
Crest’s commitment in providing comprehensive wellness amenities. 
Long story short we prioritize user empowerment thus  ensuring a hassle-free and personalized experience 
      </p>
      <p>
At Crest Home Care, our team is committed to providing comprehensive wellness amenities, ensuring that your health, safety, and comfort are our top priorities. Our dedicated professionals offer expert care and support, tailored to meet your unique needs.
      </p>
    </div>
    <div class="col-12 col-md-4 d-flex justify-content-center align-items-center">
      <div class="img-container">
        <img src="whyus3.jpg" style="width:70%">
        <img src="whyus2.jpg" style="width:70%">
        <img src="whyus1.jpg" style="width:70%">
      </div>
    </div>
  </div>
</body>
</html>
