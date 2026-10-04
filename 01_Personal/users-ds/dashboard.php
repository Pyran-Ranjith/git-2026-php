<?php
// users/dashboard.php
require_once __DIR__ . "/auth.php";
require_once __DIR__ . "/header-ds.php";
/** @var mysqli $conn */
/** @var bool $local_error */
/** @var string $alert_type */
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
        <a href="dashboard.php" class="alert-link">Refresh parameters</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php } else {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (isset($_SESSION['msg'])) {
      $msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
      $alert_type = "danger";
    }
  ?>
    <div class="container mt-3">
      <br><br>
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
      </div>
    </div>
  <?php } ?>
</secction>

<?php
$local_error = false;

$msg_type = $_GET['msg_type'] ?? '';
$msg      = $_GET['msg']      ?? '';

// Search
$q = trim($_GET['q'] ?? '');

$sql = "SELECT `id`, `username`, `created_at` FROM `users`";
$params = [];
$types  = '';

if ($q !== '') {
  $sql .= " WHERE `username` LIKE ?";
  $params[] = '%' . $q . '%';
  $types .= 's';
}
$sql .= " ORDER BY `id` ASC";

if ($params) {
  $stmt = mysqli_prepare($conn, $sql);
  // ---- Handle execute failure ----
  if (!$stmt) {
    $error_msg  = mysqli_error($conn);   // capture FIRST
    $error_line = __LINE__ - 2;
    $error_file = basename(__FILE__);
    $msg = "Execute failed: $error_msg on file $error_file on line $error_line";
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION['msg'] = $msg;
    // header("Location: dashboard.php");
    $local_error = true;
    exit;
  }
  mysqli_stmt_bind_param($stmt, $types, ...$params);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
} else {
  $result = mysqli_query($conn, $sql);
  // ---- Handle execute failure ----
  if (!$result) {
    $error_msg  = mysqli_error($conn);   // capture FIRST
    $error_line = __LINE__ - 2;
    $error_file = basename(__FILE__);
    $msg = "Execute failed: $error_msg on file $error_file on line $error_line";
    // header("Location: dashboard.php?alert_type=danger&msg=" . urlencode($msg));
    // exit;
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    $_SESSION['msg'] = $msg;
    $local_error = true;
    exit;
  }
}
?>
<title>users-ds/Manage Users</title>
</head>

<body class="bg-light">
  <div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Manage Users</h2>
      <div>
        <a href="<?= $base_url_root ?>/dashboard.php" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <a href="add.php" class="btn btn-success">
          <i class="bi bi-plus-circle"></i> Add User
        </a>
      </div>
    </div>

      <!-- Search -->
      <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
          <input type="text" name="q" class="form-control"
            placeholder="Search by username..."
            value="<?= htmlspecialchars($q) ?>">
        </div>
        <div class="col-auto">
          <button class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
        </div>
        <div class="col-auto">
          <a href="../dashboard.php" class="btn btn-outline-dark">Reset</a>
        </div>
      </form>

    <!-- <?php if (!$local_error) { ?> -->
      <div class="card shadow-sm">
        <div class="card-body p-0">
          <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($result) === 0): ?>
                <tr>
                  <td colspan="4" class="text-center text-muted py-3">No users found.</td>
                </tr>
              <?php else: ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?= (int)$row['id'] ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td class="text-center">
                      <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                      </a>
                      <a href="delete.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete user <?= htmlspecialchars($row['username'], ENT_QUOTES) ?>?');">
                        <i class="bi bi-trash"></i> Delete
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    <!-- <?php }  ?> -->

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>