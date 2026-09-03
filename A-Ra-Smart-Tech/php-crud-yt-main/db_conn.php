<?php
$servername = "localhost";
$username = "root";
$password = "";
// $dbname = "php-crud";
$dbname = "ra_smart_tech_curd";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";