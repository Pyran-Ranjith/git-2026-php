<?php
require_once "header.php";
global $conn;
?>
<title>Dashboard</title>
</head>

<body>
  <?php
  $msg_type = ($_GET["msg_type"] ?? "");
  $msg = ($_GET["msg"] ?? "");
  ?>
  <?php if ($msg) {
    $alert_type = ($msg_type == 'Error') ? 'danger' : 'success';
  ?>
    <div class="container mt-3">
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="index-work.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php } ?>


  <!-- Content -->
  <div class="container mt-3">

  </div>

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
        confirmLink.href = 'Pages/delete.php?id=' + id;
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>