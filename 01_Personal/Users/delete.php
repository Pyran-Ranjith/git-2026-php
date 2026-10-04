<!-- delete.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "header.php";
// session_start();
?>

<title>delete.php</title>
<!-- bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"></head>
</head>

<body class="bg-light">
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
  // Add this to avoid error intelephense(P1008)
  /** @var mysqli $conn */
  /** @var String $base_url_root */
  /** @var String $base_url_users */
  /** @var String $error_msg */
  ?>

  <?php

  $id = (int)($_GET['id'] ?? 0);
  if ($id <= 0) {
    header("Location: admin.php?alert_type=danger&msg=" . urlencode("Invalid user ID."));
    exit;
  }

  // Prevent deleting yourself
  // if ($id === (int)$_SESSION['user_id']) {
  //   header("Location: admin.php?alert_type=danger&msg=" . urlencode("You cannot delete your own account."));
  //   exit;
  // }

  // Handle POST — actually delete
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM `users` WHERE `id` = $id";

    if (mysqli_query($conn, $sql)) {
      $msg = "User deleted successfully for id = " . $id;
      header("Location: admin.php?alert_type=success&msg=" . urlencode($msg));
      exit;
    } else {
      $error_msg = mysqli_error($conn);   // capture FIRST
      $error_no  = mysqli_errno($conn);
      $msg = "Delete failed: " . mysqli_error($conn);
      header("Location: admin.php?alert_type=danger&msg=" . urlencode($msg));
      exit;
    }
  }

  // GET — show confirmation
  $sql = "SELECT `id`, `username`, `created_at` FROM `users` WHERE `id` = $id LIMIT 1";
  $result = mysqli_query($conn, $sql);
  if (mysqli_query($conn, $sql)) {
  } else {
    $error_msg = mysqli_error($conn);   // capture FIRST
    $error_no  = mysqli_errno($conn);
    $msg = "Select query failed: " . mysqli_error($conn);
    header("Location: admin.php?alert_type=danger&msg=" . urlencode($msg));
    exit;
  }
  $row = mysqli_fetch_assoc($result);

  if (!$row) {
    $msg = "User with id: " . $id . "not found. ";
    header("Location: admin.php?alert_type=danger&msg=" . urlencode($msg));
    exit;
  }
  ?>

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
        <a href="admin.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Cancel</a>
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