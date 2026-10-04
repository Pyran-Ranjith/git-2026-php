<!-- delete.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header.php";
// session_start();
?>
<?php
  // Add this to avoid error intelephense(P1008)
/** @var mysqli $conn */
/** @var String $base_url_root */
/** @var String $base_url_users */
/** @var String $error_msg */
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
  header("Location: " . $base_url_users . "/index.php?msg_type=Delete&msg=" . $msg . urlencode($id));
} else {
  echo "Failed: " . mysqli_error($conn);
  if (!mysqli_query($conn, $sql)) {
    $error_no = mysqli_errno($conn);
    $error_msg = mysqli_error($conn);
    $err = true;
  }
  $msg = "Record not deleted,. Error: " . $error_msg;
  header("Location: " . $base_url_users . "/index.php?msg_type=Error&msg=" . urlencode($msg));
}
