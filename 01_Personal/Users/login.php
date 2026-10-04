<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header-dashboard.php";
?>
<?php
// Add this to avoid error intelephense(P1008)
/** @var mysqli $conn */
/** @var String $base_url_root */
/** @var String $error_msg */
/** @var String $base_url_users */
?>

<title>Login</title>
</head>

<body class="bg-light">

<?php
// If already logged in, go to dashboard
// if (!empty($_SESSION['user_id'])) {
//   header("Location: " . $base_url_root . "/register.php");
//   exit;
// }

if (!empty($_SESSION['user_id'])) {
  $msg = "username not found Please Login or Register ";
  header("Location: " . $base_url_users . "./register.php?alert_type=danger&msg=" . urlencode($msg));
} else {
  // echo "Failed: " . mysqli_error($conn);
  // if (!mysqli_query($conn, $sql)) {
  //   $error_no = mysqli_errno($conn);
  //   $error_msg = mysqli_error($conn);
  //   $err = true;
  // }
  // $msg = "Record not be updated,. Error: " . $error_msg;
  // header("Location: " . $base_url_root . "/index.php?alert_type=danger&msg=" . urlencode($msg));
}
?>
  <!-- --------------------------------------------------------------------------------------------------- -->
  <?php
  // $msg_type = ($_GET["msg_type"] ?? "");
  $msg = ($_GET["msg"] ?? "");
  ?>
  <?php if ($msg) {
    $alert_type = ($_GET["alert_type"] ?? "info");
  ?>

    <div class="container mt-3">
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="dashboard.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php } ?>
  <!-- --------------------------------Main Content Begin -------------------------- -->
  <?php

  $error = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
      $error = "Please enter both username and password.";
    } else {
      $stmt = mysqli_prepare($conn, "SELECT `id`, `password_hash` FROM `users` WHERE `username` = ? LIMIT 1");
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $user = mysqli_fetch_assoc($result);

      if ($user && password_verify($password, $user['password_hash'])) {
        // ✅ Login success
        session_regenerate_id(true); // prevents session fixation
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
      } else {
        $error = "Invalid username or password.";
      }
    }
  }
  ?>

  <div class="container" style="max-width: 420px; margin-top: 80px;">
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white text-center">
        <h4 class="mb-0">Diary Login</h4>
      </div>
      <div class="card-body">
        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
              value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Log In</button>
        </form>
        <p class="text-center mt-3 mb-0">
          New here? <a href="register.php">Create an account</a>
        </p>
      </div>
    </div>
  </div>

  <!-- --------------------------------Main Content End -------------------------------------------------- -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>