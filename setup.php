<?php
//creation of connection

$servername= "localhost";

$database= "gwsc";

$password="";

$username="root";

$connection= mysqli_connect($servername,$username, $password);

if(!$connection){

    die("connection failed" . mysqli_connect_error());

}
 else {
    echo"Connection Successful";
}

//create database

$sql= "CREATE DATABASE IF NOT EXISTS gwsc";
$ret= mysqli_query($connection, $sql);
$gwsc= $database;

if($ret){
    echo"Database Created Successfully <br>";

}

 else {
    echo"Error Creation of Database!". mysqli_error($connection)."<br>";
}

mysqli_select_db($connection, $gwsc);

//create table

$table="CREATE TABLE IF NOT EXISTS users(id INT AUTO_INCREMENT PRIMARY KEY,
 firstname VARCHAR(50) NOT NULL, surname VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL, passwords VARCHAR (200) NOT NULL)";

$tableRet= mysqli_query($connection, $table);

if($tableRet){

    echo"Table created successfully <br>";
}

 else{
  
    echo "Creation failed!" . mysqli_error($connection)."<br>";
 }

 $tableAvailability="CREATE TABLE IF NOT EXISTS availability(
    siteID INT AUTO_INCREMENT PRIMARY KEY,
    swimmingSlotsAvailability VARCHAR(255) NOT NULL,
    campingPitchesAvailability VARCHAR(255) NOT NULL,
    lastUpdatedTimeStamp VARCHAR(50) NOT NULL

 )";

$tableRetAvailability= mysqli_query($connection, $tableAvailability);

if($tableRetAvailability){

    echo"Table created successfully <br>";
}

 else{
  
    echo "Creation failed for Availabity Table!" . mysqli_error($connection)."<br>";
 }

 header("Refresh: 5; URL = register.php"); //redirect to register.php

echo"Redirecting to register.php in 5 seconds.....";

exit;
?>