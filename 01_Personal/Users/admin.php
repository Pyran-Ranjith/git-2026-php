<!-- Users/admin.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header.php";
// session_start();
?>
<?php
// $conn = getConn1("ranjith_personal");
?>
<title>admin-users</title>
<!-- bootstrap -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"> -->
</head>

<body class="bg-light">
  <?php
  // Add this to avoid error intelephense(P1008)
  /** @var mysqli $conn */
  /** @var String $base_url_root */
  /** @var String $base_url_users */
  // /** @var String $error_msg */
  // /** @var int $row_count */
  // /** @var String $username */
  // /** @var bool $local_error */
  // /** @var String $q */
?>

  <!-- Parameter Alert -->
  <secction>
    <?php
    // // Disable MySQLi exceptions
    // mysqli_report(MYSQLI_REPORT_OFF);
    // // Enable error reporting for development
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $msg = ($_GET["msg"] ?? "");
    if ($msg) {
      $alert_type = ($_GET["alert_type"] ?? "info");
    }
    ?>


      <div class="container mt-3">
        <!-- <br><br>
        <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($msg) ?>
          <a href="admin.php" class="alert-link">      <div class="container mt-3"> -->


        <!-- <br><br>
    <br><br> -->
    <?php if (!empty($msg)): ?>
        <div class="alert alert-<?= htmlspecialchars($alert_type) ?> alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
            <div>
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= htmlspecialchars($msg) ?>
                <a href="admin.php" class="alert-link fw-bold ms-3 text-decoration-underline">
                    <i class="bi bi-arrow-clockwise"></i> Refresh parameters
                </a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <!-- }     -->
</div>
  </secction>

  <!-- Main Content Begin --------------------------------------- -->

    <?php
$local_error = false;

$alert_type = $_GET['alert_type'] ?? '';
$msg      = $_GET['msg']      ?? '';

// Search
$q = trim($_GET['q'] ?? '');

$sql = "SELECT `id`, `username`, `created_at` FROM `userss`";
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
    // header("Location: dashboard.php?alert_type=danger&msg=" . urlencode($msg));
    // exit;
    $local_error = true;
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
    $local_error = true;
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

    <?php if ($msg): ?>
      <div class="alert alert-<?= $alert_type === 'Error' ? 'danger' : 'success' ?> alert-dismissible fade show">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <?php if (!$local_error) { ?>
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
    <?php }  ?>

  </div>

  <!-- Main Content End --------------------------------------- -->

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true bg-danger">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
          <p class="text-danger"><strong>This action cannot be undone!</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Pass the ID to the delete link
    document.addEventListener('DOMContentLoaded', function() {
      var deleteModal = document.getElementById('deleteModal');
      deleteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var confirmLink = document.getElementById('confirmDelete');
        confirmLink.href = 'delete.php?id=' + id;
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>