<!-- add_new.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header.php";
// session_start();
?>

<!-- bootstrap -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"> -->
</head>

<title>add_new.php</title>
</head>

<body class="bg-light">
  <?php
  // Add this to avoid error intelephense(P1008)
  /** @var mysqli $conn */
  /** @var String $base_url_root */
  /** @var String $base_url_users */
  // /** @var String $error_msg */
  ?>

  <!-- Parameter Alert -->
  <secction>
    <?php
    $msg = ($_GET["msg"] ?? "");
    if ($msg) {
      $alert_type = ($_GET["alert_type"] ?? "info");
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
        $stmt = mysqli_prepare($conn, "SELECT id FROM `users` WHERE `username` = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Username already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO `users` (`username`, `password_hash`) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $username, $hash);

            if (mysqli_stmt_execute($stmt)) {
                $msg = "User '" . $username . "' created successfully.";
                header("Location: index.php?msg_type=Success&msg=" . urlencode($msg));
                exit;
            } else {
                $error = "Insert failed: " . mysqli_error($conn);
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