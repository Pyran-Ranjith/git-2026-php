<?php
// users/add.php
require_once __DIR__ . "/auth.php";
/** @var mysqli $conn */

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
    // ---- Handle prepare failure (e.g. table does not exist) ----
    if (!$stmt) {
      $error_msg  = mysqli_error($conn);   // capture FIRST
      $error_line = __LINE__ - 2;
      $error_file = basename(__FILE__);
      $msg = "Prepare failed: $error_msg on file $error_file on line $error_line";
      header("Location: dashboard.php?alert_type=danger&msg=" . urlencode($msg));
      exit;
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
      $error = "Username already taken.";
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = mysqli_prepare($conn, "INSERT INTO `users` (`username`, `password_hash`) VALUES (?, ?)");
    // ---- Handle prepare failure (e.g. table does not exist) ----
    if (!$stmt) {
      $error_msg  = mysqli_error($conn);   // capture FIRST
      $error_line = __LINE__ - 2;
      $error_file = basename(__FILE__);
      $msg = "Insert failed: $error_msg on file $error_file on line $error_line";
      header("Location: dashboard.php?alert_type=danger&msg=" . urlencode($msg));
      exit;
    }
      mysqli_stmt_bind_param($stmt, "ss", $username, $hash);

      if (mysqli_stmt_execute($stmt)) {
        $msg = "User '" . $username . "' created successfully.";
        header("Location: dashboard.php?msg_type=Success&msg=" . urlencode($msg));
        exit;
      } else {
        $error = "Insert failed: " . mysqli_error($conn);
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container py-4" style="max-width: 520px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Add New User</h3>
      <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
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
            <i class="bi bi-check2-circle"></i> Create User
          </button>
          <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
        </form>
      </div>
    </div>

  </div>
</body>

</html>