<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user inputs
    $pitchType = $_POST['pitchType'];
    $checkInDate = $_POST['checkInDate'];
    $checkOutDate = $_POST['checkOutDate'];

    // Connect to your database (use your existing database connection)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gwsc"; // Use your database name

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a SQL query to check availability
    $query = "SELECT * FROM availability WHERE 
              swimmingSlotsAvailability = '$pitchType' AND
              lastUpdatedTimeStamp <= '$checkInDate' AND
              lastUpdatedTimeStamp >= '$checkOutDate'";

    $result = $conn->query($query);

   
    // Close the database connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>GWSC</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- swiper css link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

    <!-- custom css file link -->
    <link rel="stylesheet" href="css/style.css">
    <style>
       

       select {
            padding: 10px; 
            font-size: 16px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            width: 100%; 
        }

        /* Style the h1 element */
        h1 {
            font-size: 24px; 
            margin-bottom: 20px; 
            color: #333; 
            text-align: center; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10vh; 
        }


        /* Style the form container */
        .form-container {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style the availability message */
        .availability-message {
            font-size: 18px;
            margin-top: 20px;
        
        }
    </style>
</head>

<body>

    <!-- header section starts -->
    <header class="header">
        <a href="#" class="logo"><i class="fas fa-campground"></i>GWSC</a>

        <nav class="navbar">
            <div id="close-navbar" class="fas fa-times"></div>
            <a href="index.html">home</a>
            <a href="#about">about</a>
            <a href="features.html">features</a>
            <a href="#about">infomation</a>
            <a href="pitch.html">pitchs</a>
            <a href="review.html">Reviews</a>
            <a href="contactus.html">contact</a>
        </nav>

        <div class="icons">
            <div id="account-btn" class="fas fa-user"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
        <form action="" class="search-form">
            <input type="search" name="" placeholder="search here..." id="search-box">
            <label for="search-box" class="fas fa-search"></label>
        </form>
    </header>

    <!-- account form section starts -->

    <div class="account-form">

        <div id="close-form" class="fas fa-times"></div>

        <div class="buttons">
            <a href="login.php" class="btn active login-btn">Login</a>
            <a href="register.php" class="btn register-btn">Register</a>
        </div>
        </div>

    <!-- account form section ends -->

    <h1>Pitch Types and Availability</h1>
    <div class="form-container">
        <form action="pitch.php" method="POST">
            <label for="pitchType">Select Pitch Type:</label>
            <select name="pitchType" id="pitchType" required>
                <option value="tent">Tent Pitch</option>
                <option value="caravan">Touring Caravan Pitch</option>
                <option value="motorhome">Motorhome Pitch</option>
            </select>

            <label for="checkInDate">Check-In Date:</label>
            <input type="date" name="checkInDate" id="checkInDate" required>

            <label for="checkOutDate">Check-Out Date:</label>
            <input type="date" name="checkOutDate" id="checkOutDate" required>

            <button type="submit">Check Availability</button>
            <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if any rows are returned (availability found)
        if ($result->num_rows > 0) {
            echo "<h2>Availability Confirmation</h2>";
            echo "<p>$pitchType pitch is available from $checkInDate to $checkOutDate.</p>";
        } else {
            echo "<h2>Availability Confirmation</h2>";
            echo "<p>$pitchType pitch is not available from $checkInDate to $checkOutDate.</p>";
        }
    }
    ?>
        </form>
    </div>






    <section class="footer">

        <div class="box-container">
    
            <div class="box">
                <h3><i class="fas fa-campground"></i> Global Wild Swimming and Camping</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque sequi deleniti mollitia.</p>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>
    
            <div class="box">
                <h3>quick links</h3>
                <a href="home.html" class="link">home</a>
                <a href="about.html" class="link">about</a>
                <a href="courses.html" class="link">courses</a>
                <a href="contact.html" class="link">contact</a>
            </div>
    
            <div class="box">
                <h3>useful links</h3>
                <a href="#" class="link">help center</a>
                <a href="#" class="link">ask questions</a>
                <a href="#" class="link">send feedback</a>
                <a href="#" class="link">private policy</a>
                <a href="#" class="link">terms of use</a>
            </div>
    
            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <form action="">
                    <input type="email" name="" placeholder="enter your email" id="" class="email">
                    <input type="submit" value="subscribe" class="btn">
                </form>
            </div>
    
        </div>
    
        <div class="credit"> Copyright | all rights reserved! </div>
    
    </section>
    <!-- footer section ends -->
    
    <!-- swiper js link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    
    <script>

        let searchForm = document.querySelector('.header .search-form');
        let searchBtn = document.querySelector('#search-btn');
        
        // Toggle the search form when the search button is clicked
        searchBtn.addEventListener('click', function () {
            searchForm.classList.toggle('active');
            searchForm.querySelector('input[type="search"]').focus(); // Focus on the search input
        });
        
        // Close the search form when clicking outside of it
        document.addEventListener('click', function (e) {
            if (!searchForm.contains(e.target) && e.target !== searchBtn) {
                searchForm.classList.remove('active');
            }
        });
        
        // Prevent the click event on the search form from propagating to the document
        searchForm.addEventListener('click', function (e) {
            e.stopPropagation();
        });
        
        // Add the 'active' class to the search form when the search input is focused
        searchForm.querySelector('input[type="search"]').addEventListener('focus', function () {
            searchForm.classList.add('active');
        });
        </script>
    <!-- custom js file link -->
    <script src="js/script.js"></script>
    </body>
    
    </html>
    
