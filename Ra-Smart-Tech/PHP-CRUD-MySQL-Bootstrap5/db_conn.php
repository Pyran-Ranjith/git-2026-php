<?php 
$setvername = "localhost";
$username = "root"; 
$password = "";
$dbname = "ra_smart_tech_curd"; 

$conn = mysqli_connect($setvername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";