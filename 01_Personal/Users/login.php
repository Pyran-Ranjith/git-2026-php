<?php
ob_start();  // ← Add this as FIRST line to avoid 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "header-dashboard.php";

// if (!isset($_SESSION['username'])) {
//   header("Location: login.php");
//   exit();
// }
?>

<title>Login</title>
</head>

<body>
  <!-- Debug section -->
  <noscript>
    <section>
      <div class="container mt-3 mt-5">
        <H1>Debug section</H1>
      </div>
    </section>
  </noscript>

  <?php

// Add this to avoid error intelephense(P1008)
  /** @var mysqli $conn */
  /** @var String $base_url_root */
  /** @var String $error_msg */
  /** @var String $base_url_users */
  $msg = ($_GET["msg"] ?? "");
  ?>

  <!-- Parameter Alert -->
  <secction>
    <?php
    $msg = ($_GET["msg"] ?? "");
    if ($msg) {
      $alert_type = ($_GET["alert_type"] ?? "info");
      $confirm  = $_POST['confirm']  ?? '';
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

  <!-- Boxes -->
  <noscript>
    <section class="p-0" id="diary_cards">
      <div class="container mt-3 mb-2">
        <div class="card">
          <div class="card-header bg-dark text-light">
            <h4 class="mb-0 text-center">Diary - Categories</h4>
          </div>
        </div>
      </div>
      <?php
      // Default filters
      $date_from    = $sql_date_from ?? '';
      $date_to    = $sql_date_to ?? '';
      $status    = $sql_status ?? '';
      $category  = $sql_categry ?? '';
      // $event     = $_GET['event'] ?? '';   // ✅ add this
      $event  = $sql_event ?? '';
      $sql_orderby = "DESC";
      ?>

      <div class="container">
        <div class="row g-4">

          <!-- Category: Bills monthly -->
          <?php
          $card_header = "Bills monthly";
          $card_bg = "bg-info";
          $sql_categry = "bill_monthly";
          $sql_event = "634.75";
          $sql_orderby = "ASC";
          require "include/card_box_diary.php";
          ?>
        </div>
  </noscript>
  <!-- --------------- Main Content BEGIN --------------------------- -->
  <?php
  $msg = ($_GET["msg"] ?? "");
  if ($msg) {
    $alert_type = ($_GET["alert_type"] ?? "info");
  }
  ?>

  <?php if ($msg) { ?>
    <div class="container mt-3">
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="dashboard.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php } ?>

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
        // $_SESSION['user_id']  = $user['id'];
        // $_SESSION['username'] = $username;
        $_SESSION['loggedIn'] = true;
        $_SESSION['currentuser'] = [
          'user_id'  => $user['id'],
          'username' => $username
        ];

        // echo "<br><br>";
        // echo "<pre>";
        // print_r($_SESSION);
        // echo "</pre>";
        // exit();


        header("Location: admin.php");
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
        <h4 class="mb-0">User Login</h4>
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


  <!-- --------------- Main Content END --------------------------- -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>