/* db_connect_error.php */?
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error = $_SESSION['db_error'] ?? 'Unknown database error';
unset($_SESSION['db_error']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Modal -->
<div class="modal fade" id="dbErrorModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Database Connection Error
                </h5>
            </div>
            <div class="modal-body">
                <p>The application could not connect to the database.</p>
                <div class="alert alert-danger mb-0">
                    <code><?= htmlspecialchars($error) ?></code>
                </div>
                <small class="text-muted d-block mt-2">Please contact the administrator.</small>
            </div>
            <div class="modal-footer">
                <a href="index.php" class="btn btn-secondary">Go Back</a>
                <a href="login.php" class="btn btn-primary">Retry</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var modal = new bootstrap.Modal(document.getElementById('dbErrorModal'));
    modal.show();
</script>
</body>
</html>