<?php
require_once "db_conn.php";
global $conn;
global  $error_no;
global  $error_msg;
$err = false;

$id = ($_GET["id"] ?? "");
// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "DELETE FROM `crud` WHERE id = $id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
        header("Location: index-work.php?msg_type=Delete&msg=Record deleted successfully for id " . urlencode($id) );
  } else {
    echo "Failed: " . mysqli_error($conn);
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
    header("Location: index-work.php?msg_type=Error&msg=Record not deleted, Error occured deleting for id " . urlencode($error_msg));
  }