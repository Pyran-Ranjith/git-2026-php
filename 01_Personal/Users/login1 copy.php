<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header-dashboard.php";
if (session_status() === PHP_SESSION_NONE) {
  session_start();
} 

// if (!isset($_SESSION['username'])) {
//   header("Location: login.php");
//   exit();
// }
?>

<title>Login</title>
</head>

<!-- <body class="bg-light"> -->
<body>
<?php
// Add this to avoid error intelephense(P1008)
// /** @var mysqli $conn */
// /** @var String $base_url_root */
// /** @var String $error_msg */
// /** @var String $base_url_users */
?>
<H1>tEST</H1>
  <?php
  // If already logged in, go to dashboard
  // if (!empty($_SESSION['user_id'])) {
  //   header("Location: " . $base_url_root . "/register.php");
  //   exit;
  // }

  // if (empty($_SESSION['user_id'])) {
  // if (!$_SESSION['user_id']) {
  //   $msg = "username not found Please Login or Register ";
  //   header("Location: " . $base_url_users . "./register.php?alert_type=danger&msg=" . urlencode($msg));
  // } else {
  // echo "Failed: " . mysqli_error($conn);
  // if (!mysqli_query($conn, $sql)) {
  //   $error_no = mysqli_errno($conn);
  //   $error_msg = mysqli_error($conn);
  //   $err = true;
  // }
  // $msg = "Record not be updated,. Error: " . $error_msg;
  // header("Location: " . $base_url_root . "/index.php?alert_type=danger&msg=" . urlencode($msg));
  // }
  ?>
  <!-- --------------------------------------------------------------------------------------------------- -->
  <?php
  // $msg_type = ($_GET["msg_type"] ?? "");
  // $msg = ($_GET["msg"] ?? "");
  // if ($msg) {
  //   $alert_type = ($_GET["alert_type"] ?? "info");
  // }
?>

  <!-- --------------------------------Main Content End -------------------------------------------------- -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>