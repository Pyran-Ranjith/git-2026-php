<!-- add_new.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header.php";
// session_start();
?>

<!-- bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
</head>

<title>add_new.php</title>
</head>

<body class="bg-light">
  <?php
  // Add this to avoid error intelephense(P1008)
  /** @var mysqli $conn */
  /** @var String $base_url_root */
  /** @var String $base_url_users */
  /** @var String $error_msg */
  ?>

  <!-- Parameter Alert -->
  <secction>
    <?php
    // Disable MySQLi exceptions
    mysqli_report(MYSQLI_REPORT_OFF);
    // Enable error reporting for development
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

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

  <!-- Main Content Begin --------------------------------------- -->
  <?php
  $error = "";
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';
    if ($username === '' || $password === '') {
      $error = "Username and password are required.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
      $error = "Username must be 3–50 characters.";
    } elseif (strlen($password) < 6) {
      $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
      $error = "Passwords do not match.";
    } else {
      // Check duplicate
      $username_esc = mysqli_real_escape_string($conn, $username);
      // $sql = "SELECT id FROM `users` WHERE `username` = $username_esc";
      $username_esc = mysqli_real_escape_string($conn, $username);
      $sql = "SELECT id FROM `users` WHERE `username` = '$username_esc' ";
      // $sql = "INSERT INTO `users` (`username`, `password_hash`) VALUES (?, ?)";
      $result = mysqli_query($conn, $sql);
      if ($result) {
        $row = mysqli_fetch_assoc($result);
        $row_count = mysqli_num_rows($result);
        if ($row_count > 0) {
          $error = "Username already taken.";
        }
      } else {
        $error_msg = mysqli_error($conn);   // capture FIRST
        $error_no  = mysqli_errno($conn);
        $error_line = __LINE__ - 2;  // Adjust offset to point to the query line
        $error_file = __FILE__;              // Full path of current file
        $error_file = basename(__FILE__);    // Just "dashboard.php"        $msg = "Select failed: " . mysqli_error($conn) . " at line " . $error_line;
        header("Location: admin.php?alert_type=danger&msg=" . urlencode($msg));
        exit;
      }

      // Insert new record
      if ($error === '') {
        $username_esc = mysqli_real_escape_string($conn, $username);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $hash_esc = mysqli_real_escape_string($conn, $hash);
        $sql = "INSERT INTO `users` (`username`, `password_hash`) VALUES ('$username_esc', '$hash_esc')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $msg = "User " . $username . " created successfully.";
          header("Location: admin.php?alert_type=success&msg=" . urlencode($msg));
          exit;
        } else {
          $error_msg = mysqli_error($conn);   // capture FIRST
          $error_no  = mysqli_errno($conn);
          $error_line = __LINE__ - 2;  // Adjust offset to point to the query line
          $msg = "Insert failed: " . mysqli_error($conn) . " at line " . $error_line;
          header("Location: admin.php?alert_type=danger&msg=" . urlencode($msg));
          exit;
        }
      }
    }
  }
  ?>

  <body class="bg-light">
    <div class="container py-4" style="max-width: 520px;">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Add New User</h3>
        <a href="admin.php" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-arrow-left"></i> Back
        </a>
      </div>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-body">
          <form method="post" autocomplete="off">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control"
                value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                minlength="3" maxlength="50" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control"
                minlength="6" required>
              <div class="form-text">At least 6 characters.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="confirm" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">
              <i class="bi bi-plus-circle"></i> </i> Add User
            </button>
            <a href="admin.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
          </form>
        </div>
      </div>

    </div>
    <!-- Main Content End --------------------------------------- -->

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
  </body>

  </html>