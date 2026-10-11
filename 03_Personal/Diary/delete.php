<!-- Diary/delete.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "../config_db.php";
require_once "include/header.php";
// session_start();
$conn = getConn1("ranjith_personal");
?>

<title> Delete | Diary</title>
</head>
<?php
  // Add this to avoid error intelephense(P1008)
/** @var mysqli $conn */
/** @var String $base_url_root */
/** @var String $base_url_diary */
/** @var String $error_msg */
/** @var int $error_no */
?>

<?php
$err = false;

$id = ($_GET["id"] ?? "");
// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "DELETE FROM `diary` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
  $msg = "Record deleted successfully for id ";
  header("Location: admin.php?msg_type=danger&msg=" . $msg . urlencode($id));
} else {
  // echo "Failed: " . mysqli_error($conn);
  if (!mysqli_query($conn, $sql)) {
    $error_no = mysqli_errno($conn);
    $error_msg = mysqli_error($conn);
    $err = true;
  }
  $msg = "Record not deleted,. Error: " . $error_msg;
  header("Location: admin.php?alert_type=danger&msg=" . urlencode($msg));
}
