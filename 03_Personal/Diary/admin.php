<!-- Diary/admin.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "../config_db.php";
require_once "include/header.php";
// session_start();
?>
<?php
$conn = getConn1("ranjith_personal");
?>
<title> Admin | Diary</title>
</head>

<body>
  <?php
  // Add this to avoid error intelephense(P1008)
  /** @var mysqli $conn */
  /** @var String $base_url_root */
  /** @var String $base_url_diary */
  /** @var String $error_msg */
  $return_url = $_GET['return_url'] ?? 'admin.php';
  ?>

  <!-- Parameter Alert -->
  <secction>
    <?php
    $msg = ($_GET["msg"] ?? "");
    if ($msg) {
      $alert_type = ($_GET["alert_type"] ?? "info");
      // $confirm  = $_POST['confirm']  ?? '';
    ?>
      <div class="container mt-3">
        <br><br>
        <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($msg) ?>
          <a href="admin.php" class="alert-link">Refresh</a>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
    <?php } ?>
  </secction>

  <?php

  $err = false;

  // Disable MySQLi exceptions
  mysqli_report(MYSQLI_REPORT_OFF);

  // Enable error reporting for development
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  $id = ($_GET["id"] ?? "");
  $rec_filter = ($_GET["rec_filter"] ?? "");
  $msg_type = ($_GET["msg_type"] ?? "");
  $msg = ($_GET["msg"] ?? "");
  ?>
  <?php if ($msg) {
    $alert_type = ($msg_type == 'Error') ? 'danger' : 'success';
  ?>
    <!-- <div class="container mt-3">
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="admin.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div> -->
  <?php } ?>

  <!-- Main Content Container -->

  <!-- Page Header -->
  <header class="py-4 border-bottom border-secondary border-opacity-10 mb-4">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
          <li class="breadcrumb-item"><a href="dashboard.php" class="text-gold text-decoration-none">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="admin.php" class="text-gold text-decoration-none">Admin</a></li>
          <li class="breadcrumb-item active text-muted" aria-current="page">Add Record</li>
        </ol>
      </nav>
      <h1 class="brand-font h2 fw-bold text-white mb-0">Manage Diary Entries</h1>
      <p class="text-muted mb-0">Manage Add, Edit and Delete Diary entries.</p>
    </div>
  </header>

  <main class="container mb-5">
    <!-- <div class="container mt-3"> -->

    <!-- Table Card -->
    <div class="luxury-card p-3 p-md-4 mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Manage Diary</h3>
        <a href="add_new.php" class="btn btn-success">Add new record</a>
      </div>

      <div class="table-responsive">
        <table class="table table-luxury table-hover text-center">
          <!-- <thead class="table-dark"> -->
          <thead">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Date</th>
              <th scope="col">Status</th>
              <th scope="col">Category</th>
              <th scope="col">Event</th>
              <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
              <?php
              if ($rec_filter == "Manage") {
                $return_url = $_GET['return_url'] ?? 'admin.php';
                $sql = "SELECT * FROM `diary` WHERE id = $id LIMIT 1";
              } else {
                $return_url = $_GET['return_url'] ?? 'admin.php';
                // $sql = "SELECT * FROM `diary` ORDER BY `date` DESC LIMIT 5";
                $sql = "SELECT * FROM `diary` ORDER BY `date` DESC";
              }

              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <!-- <td><?= $row["id"] ?></td> -->
                  <td><?= $row["id"] ?></td>
                  <td><?= $row["date"] ?></td>
                  <td><?= $row["status"] ?></td>
                  <td><?= $row["category"] ?></td>
                  <td><?= $row["event"] ?></td>
                  <!-- With With buttons -->
                  <td>
                    <!-- <a class="btn btn-primary btn-sm me-0" href="view.php?id=<?php echo $row["id"] ?>" role="button">View</a> -->
                    <!-- <a class="btn btn-success btn-sm me-0" href="edit.php?id=<?php echo $row["id"] ?>" role="button">Edit</a> -->
                    <a class="btn btn-success btn-sm me-0" href="edit.php?id=<?php echo $row["id"] ?>&return_url=<?php echo $return_url ?>" role="button">Edit</a>
                    <!-- Delete Button to load the Delete Model-->
                    <a class="btn btn-danger btn-sm me-0" data-bs-toggle="modal"
                      data-bs-target="#deleteModal" data-id="<?= $row["id"] ?>">
                      Delete
                    </a>
                  </td>

                  <!-- With Font Awesome Icons -->
                  <!-- <td> 
              <a href="edit.php?id=<?php echo $row["id"] ?>" class="link-primay"><i
                  class="fa-solid fa-pen-to-square fs-6 me-3"></i></a>
              <a href="edit.php?id=<?php echo $row["id"] ?>" class="link-success"><i
                  class="fa-solid fa-pen-to-square fs-6 me-3"></i></a>
              <a href="dxelete.php?id=<?= $row["id"] ?>" class="link-danger"><i class="fa-solid fa-trash fs-6"></i></a>
            </td> -->
                </tr>
              <?php
              }
              ?>
            </tbody>
        </table>
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="#top" class="btn btn-warning mb-3">Jump Top</a>
      </div>
    </div>
  </main>

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
        confirmLink.href = 'delete.php?id=' + id '&return_url=<?= $return_url ?>';
      });
    });
  </script>


  <?php
  require_once "include/footer.php";
  ?>