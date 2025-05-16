<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "base1-in-out";

// Create connection
$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con) {


  die("Connection failed: " . mysqli_connect_error());
}
?>