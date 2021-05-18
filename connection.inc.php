<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "nitinsharma";

// Create connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
$db=mysqli_select_db($con,"e_commerce");
?>