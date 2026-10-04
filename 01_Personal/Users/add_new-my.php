<!-- Users/add_new.php -->
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
/** @var String $error_no */
?>

<?php
if (!isset($base_url_users)) {
  $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $base_url_users = $protocol . $host . rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
}

// global $conn;
// global  $error_no;
// global  $error_msg;
$conn = getConn1("ranjith_personal");
$err = false;

// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
  $username = $_POST['username'];
  $password_hash = $_POST['password_hash'];

  $sql = "INSERT INTO `users`(`id`, `username`, `password_hash`) VALUES (NULL,'$username','$password_hash')";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    $msg = "New record created successfully for username : ";
    header("Location: " . $base_url_users . "/admin.php?msg_type=Add&msg=" . $msg . urlencode($username));
    exit;
  } else {
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
    $msg = "Record not be added,. Error: " . $error_msg;
    header("Location: " . $base_url_users . "/admin.php?alert_type=danger&msg=" . urlencode($msg));
    exit;
  }
}
?>

<title>add_new.php</title>
</head>

<body>

  <!-- Parameter Alert -->
  <secction>
    <?php
    $msg = ($_GET["msg"] ?? "");
    if ($msg) {
      $alert_type = ($_GET["alert_type"] ?? "info");
      // $confirm  = $_POST['confirm']  ?? '';
    ?>
      <div class="container mt-3">
        <br><br>
        <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($msg) ?>
          <a href="register.php" class="alert-link">Refresh</a>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
    <?php } ?>
  </secction>

  <?php if ($err) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <h4 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Database Error</h4>
      <hr>
      <p><strong>Error Number:</strong> <code><?= $error_no ?></code></p>
      <p><strong>Error Description:</strong> <?= htmlspecialchars($error_msg) ?></p>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php } ?>



  <div class="container">
    <div class="text-center mb-4">
      <h3>Manage Users | Add New Record</h3>
      <p class="text-muted">Compleate the form to add a new record</p>
    </div>
  </div>

  <div class="contaner d-flex justify-content-center">
    <form action="" method="post" style="width: 50vw; min-width: 300px">
      <div class="row mb-3">

        <noscript>
          <div class="col">
            <label class="form-label">Date:</label>
            <input type="date" class="form-control" name="date" placeholder="Date" />
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Status:</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="status" id="info" value="info" checked />
              <label class="form-check-label" for="info"> Info </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="status" id="pending" value="pending" />
              <label class="form-check-label" for="pending"> Pending </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="status" id="compleated" value="completed" />
              <label class="form-check-label" for="compleated"> Compleated </label>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Category:</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="info" value="info" checked />
              <label class="form-check-label" for="info"> Info </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="login" value="login" />
              <label class="form-check-label" for="login"> Login </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="helth" value="helth" />
              <label class="form-check-label" for="helth"> Helth </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="donation" value="donation" />
              <label class="form-check-label" for="donation"> Donation </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="bill_monthly" value="bill_monthly" />
              <label class="form-check-label" for="bill_monthly"> Bill_monthly </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="lending" value="lending" />
              <label class="form-check-label" for="lending"> Lending </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="tv" value="tv" />
              <label class="form-check-label" for="tv"> Tv </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="guarantee" value="guarantee" />
              <label class="form-check-label" for="guarantee"> Guarantee </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="category" id="taskrepeated" value="taskrepeated" />
              <label class="form-check-label" for="taskrepeated"> Task Repeated </label>
            </div>
          </div>
        </noscript>

        <div class="col">
          <label class="form-label">Usename:</label>
          <input type="text" class="form-control" name="usename" placeholder="Usename" />
        </div>

      </div>
      <div>
        <button type="submit" class="btn btn-success" name="submit">
          Save
        </button>
        <a href="<?= $base_url_users ?>/index.php" class="btn btn-primary">Cancel</a>
      </div>

  </div>

  <!-- </div> -->

  <!-- <div class="container"> -->
  <!-- </div> -->
  </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>