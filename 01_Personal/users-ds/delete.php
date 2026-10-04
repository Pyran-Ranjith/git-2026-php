<?php
// users/delete.php
require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/header-ds.php";
/** @var mysqli $conn */

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: dashboard.php?alert_type=Error&msg=" . urlencode("Invalid user ID."));
    exit;
}

// Prevent deleting yourself
if ($id === (int)$_SESSION['user_id']) {
    header("Location: dashboard.php?alert_type=Error&msg=" . urlencode("You cannot delete your own account."));
    exit;
}

// Handle POST — actually delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = mysqli_prepare($conn, "DELETE FROM `users` WHERE `id` = ?");
// ---- Handle prepare failure (e.g. table does not exist) ----
if (!$stmt) {
    $error_msg  = mysqli_error($conn);   // capture FIRST
    $error_line = __LINE__ - 2;
    $error_file = basename(__FILE__);
    $msg = "Prepare failed: $error_msg on file $error_file on line $error_line";
    header("Location: dashboard.php?alert_type=danger&msg=" . urlencode($msg));
    exit;
}
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $msg = "User deleted successfully.";
        header("Location: dashboard.php?alert_type=Success&msg=" . urlencode($msg));
    } else {
        $msg = "Delete failed: " . mysqli_error($conn);
        header("Location: dashboard.php?alert_type=Error&msg=" . urlencode($msg));
    }
    exit;
}

// GET — show confirmation
$stmt = mysqli_prepare($conn, "SELECT `id`, `username`, `created_at` FROM `users` WHERE `id` = ? LIMIT 1");
// ---- Handle prepare failure (e.g. table does not exist) ----
if (!$stmt) {
    $error_msg  = mysqli_error($conn);   // capture FIRST
    $error_line = __LINE__ - 2;
    $error_file = basename(__FILE__);
    $msg = "Prepare failed: $error_msg on file $error_file on line $error_line";
    header("Location: dashboard.php?alert_type=danger&msg=" . urlencode($msg));
    exit;
}
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: dashboard.php?alert_type=Error&msg=" . urlencode("User not found."));
    exit;
}
?>
  <title>Delete User</title>
</head>
<body class="bg-light">
<div class="container py-4" style="max-width: 520px;">

  <div class="card shadow-sm border-danger">
    <div class="card-header bg-danger text-white">
      <h4 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Confirm Delete</h4>
    </div>
    <div class="card-body">
      <p>Are you sure you want to delete this user?</p>
      <ul class="list-group mb-3">
        <li class="list-group-item"><strong>ID:</strong> <?= (int)$row['id'] ?></li>
        <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($row['username']) ?></li>
        <li class="list-group-item"><strong>Created:</strong> <?= htmlspecialchars($row['created_at']) ?></li>
      </ul>
      <p class="text-danger mb-3">This action cannot be undone.</p>

      <form method="post" class="d-inline">
        <button type="submit" class="btn btn-danger">
          <i class="bi bi-trash"></i> Yes, Delete
        </button>
      </form>
      <a href="dashboard.php" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </div>

</div>
</body>
</html>