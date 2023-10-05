<?php

require 'config.php';

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $surname = mysqli_real_escape_string($connection, $_POST['surname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

    // Validate password
    if (
        strlen($password) < 8 ||
        !preg_match("/[A-Z]/", $password) || // Uppercase letter check
        !preg_match("/[0-9]/", $password)  // Number check
       // Symbol check
    ) {
        $message[] = 'Password must have at least 8 characters and contain at least one uppercase letter, one number, and one symbol';
    } else {
        // Hash the password securely
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = mysqli_prepare($connection, "SELECT * FROM `users` WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message[] = 'User already exists';
        } else {
            if (password_verify($cpassword, $password_hash)) {
                $insert = mysqli_query($connection, "INSERT INTO `users` (firstname, surname, email, passwords) VALUES('$firstname', '$surname', '$email', '$password_hash')");

                if ($insert) {
                    $message[] = 'Registration Successful';
                    header('location:login.php');
                } else {
                    $message[] = 'Registration failed!';
                }
            } else {
                $message[] = 'Passwords do not match!';
            }
        }
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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

/* Style the registration form container */
.form-container {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 9px;
    padding: 20px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.form-container h1 {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
}

.form-container .field {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.form-container .button {
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

.form-container .button:hover {
    background-color: #0056b3;
}

.form-container p {
    text-align: center;
    margin-top: 10px;
}

.form-container a {
    color: #007bff;
    text-decoration: none;
}

.form-container a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    
</body>
</html>

<div class="form-container">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <h1>Register Now</h1>

        <?php
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo'<div class="message">' .$msg.'</div>';
                }
            }

        ?>
        
    <input type="text" name="firstname" placeholder="Firstname" class="field" required>
   
    <input type="text" name="surname" placeholder="Surname" class="field" required>
   
    <input type="email" name="email" placeholder="Email" class="field" required>
   
    <input type="password" name="password" placeholder="Password" class="field" required>
   
    <input type="password" name="confirmpassword" placeholder="Confirmpassword" class="field" required>
   
    <input type="submit" name="submit" placeholder="Register" class="button" >

    <p>Already have an account? <a href="login.php">Login Now</a></p>
<br>
    <p><a href="index.html">Home Page</a></p>
   
</form>


    
</body>
</html>
