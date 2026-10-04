<?php
require_once 'include/parameters.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$setservertype  = $_SERVER['HTTP_HOST'] ?? 'infinityfree';
if ($setservertype == "localhost") {
  $development = true;
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  mysqli_report(MYSQLI_REPORT_OFF);   // so mysqli_query returns false instead of throwing
} else {
  $development = false;
}
function getConn1Blocked($g_server_localhost_1, $g_server_infinityfree_1)
{
  $setservertype  = $_SERVER['HTTP_HOST'] ?? 'infinityfree';
  if ($setservertype == "localhost") {
    $setvername = $g_server_localhost_1["host"];
    $username = $g_server_localhost_1["user"];
    $password = $g_server_localhost_1["pass"];
    $dbname = $g_server_localhost_1["name"];
    $development = true;
  } else {
    $setvername = "sql312.infinityfree.com";
    $username = "if0_34821597";
    $password = "q6CJCIvgPj9zjh5";
    $dbname = "if0_34821597_ranjith_personal";
    $development = false;
  }
  $conn = mysqli_connect($setvername, $username, $password, $dbname);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  // echo "Connected successfully";
  return $conn;
}

function getConn1()
{
  $setservertype  = $_SERVER['HTTP_HOST'] ?? 'infinityfree';
  if ($setservertype == "localhost") {
    $setvername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ranjith_personal";
  } else {
    $setvername = "sql312.infinityfree.com";
    $username = "if0_34821597";
    $password = "q6CJCIvgPj9zjh5";
    $dbname = "if0_34821597_ranjith_personal";
  }
  $conn = mysqli_connect($setvername, $username, $password, $dbname);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  // echo "Connected successfully";
  return $conn;
}
