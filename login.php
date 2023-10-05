<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Login Form</title>
    <style>
        /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Apply a background color to the whole page */
body {
    background-color: #f0f0f0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Style the login form container */
.login-form {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 9px;
    padding: 20px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.login-form h1 {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
}

.login-form .field {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.login-form .flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    font-size: 14px;
    color: #555;
}

.login-form .flex label {
    cursor: pointer;
}

.login-form .button {
    width: 100%;
    padding: 10px;
    background-color: green;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.login-form .button:hover {
    background-color: #0056b3;
}

.login-form p {
    text-align: center;
    margin-top: 10px;
}

.login-form a {
    color: #007bff;
    text-decoration: none;
}

.login-form a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>

<?php

require 'config.php';

session_start();

if(isset($_SESSION["locked"])) {
    $difference = time() - $_SESSION["locked"];
    if($difference > 10) { // Lock for 10 minutes (600 seconds)
        unset($_SESSION["locked"]);
        unset($_SESSION["login_attempts"]);
    }
}

// Initialize login_attempts if it does not exist in the session
if(!isset($_SESSION["login_attempts"])) {
    $_SESSION["login_attempts"] = 0;
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password']; // Don't use md5 here

    $select = mysqli_query($connection, "SELECT id, passwords FROM `users` WHERE email='$email'");
    
    if(!$select) {
        $message[] = 'Query error: ' . mysqli_error($connection);
    } else {
        if(mysqli_num_rows($select) > 0) {
            $row = mysqli_fetch_assoc($select);
            $hashed_password = $row['passwords'];

            // Verify the hashed password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $row['id'];
                header('location:./pitch.php');
            } else {
                $_SESSION["login_attempts"]++;
                $message[] = 'Incorrect email or password';

                if ($_SESSION["login_attempts"] > 2) {
                    $_SESSION["locked"] = time();
                    $message[] = "Too many failed attempts. Please refresh the page after 10 minutes";
                }
            }
        } else {
            $_SESSION["login_attempts"]++;
            $message[] = 'Incorrect email or password';

            if ($_SESSION["login_attempts"] > 2) {
                $_SESSION["locked"] = time();
                $message[] = "Too many failed attempts. Please refresh the page after 10 minutes";
            }
        }
    }
}

?>

<section class="login-form">
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Login</h1>

        <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo '<div class="message">' . $msg . '</div>';
            }
        }
        ?>

        <input type="email" name="email" placeholder="Enter your email" class="field" required>
        <input type="password" name="password" placeholder="Enter your password" class="field" required>

        <div class="flex">
            <input type="checkbox" name="" id="remember-me">
            <label for="remember-me">Remember me</label>
            <a href="#">Forgot password?</a>
        </div>

        <?php
        if ($_SESSION["login_attempts"] > 2) {
            echo "<p>Please wait for 10 seconds</p>";
        } else {
            ?>
            <input type="submit" name="submit" value="Login" class="button">
            <?php
        }
        ?>

        <p>Don't have an account? <a href="register.php">Register Now</a></p>

        <br>
    <p><a href="index.html">Home Page</a></p>
    </form>
</section>

</body>
</html>
