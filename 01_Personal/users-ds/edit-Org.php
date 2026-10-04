<?php
// users/edit.php
require_once __DIR__ . "/auth.php";
/** @var mysqli $conn */

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: index.php?msg_type=Error&msg=" . urlencode("Invalid user ID."));
    exit;
}

$error = "";

// Handle POST — update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm']  ?? '';

    if ($username === '') {
        $error = "Username is required.";
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = "Username must be 3–50 characters.";
    } else {
        // Duplicate check (excluding self)
        $stmt = mysqli_prepare($conn, "SELECT id FROM `users` WHERE `username` = ? AND `id` <> ?");
        mysqli_stmt_bind_param($stmt, "si", $username, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Username already taken.";
        } else {
            // If a new password was entered, validate and update it too
            if ($password !== '' || $confirm !== '') {
                if (strlen($password) < 6) {
                    $error = "Password must be at least 6 characters.";
                } elseif ($password !== $confirm) {
                    $error = "Passwords do not match.";
                }
            }

            if ($error === '') {
                if ($password !== '') {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = mysqli_prepare($conn, "UPDATE `users` SET `username`=?, `password_hash`=? WHERE `id`=?");
                    mysqli_stmt_bind_param($stmt, "ssi", $username, $hash, $id);
                } else {
                    $stmt = mysqli_prepare($conn, "UPDATE `users` SET `username`=? WHERE `id`=?");
                    mysqli_stmt_bind_param($stmt, "si", $username, $id);
                }

                if (mysqli_stmt_execute($stmt)) {
                    $msg = "User updated successfully.";
                    header("Location: index.php?msg_type=Success&msg=" . urlencode($msg));
                    exit;
                } else {
                    $error = "Update failed: " . mysqli_error($conn);
                }
            }
        }
    }
}

// Fetch current row
$stmt = mysqli_prepare($conn, "SELECT `id`, `username` FROM `users` WHERE `id` = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: index.php?msg_type=Error&msg=" . urlencode("User not found."));
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 520px;">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Edit User #<?= (int)$row['id'] ?></h3>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">
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
                 value="<?= htmlspecialchars($_POST['username'] ?? $row['username']) ?>"
                 minlength="3" maxlength="50" required autofocus>
        </div>
        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" name="password" class="form-control">
          <div class="form-text">Leave blank to keep the current password.</div>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm New Password</label>
          <input type="password" name="confirm" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check2-circle"></i> Update
        </button>
        <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
      </form>
    </div>
  </div>

</div>
</body>
</html>