<!DOCTYPE html>
<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Test/05.php</title>
</head>

<body>
  <?php
  $msg_type = "Update";
  $msg = "Record updated successfully!";
  ?>

  <!-- Corrected code: -->
  <section>
    <div class="container mt-3">
      <h4>Corrected code:</h4>
    </div>
    <?php if ($msg_type == "Update" && $msg) { ?>
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($msg) ?>
        <a href="#" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php } elseif ($msg_type == "Error" && $msg) { ?>
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($msg) ?>
        <a href="#" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php } ?>
  </section>>

  <!-- Or simplified with a function: -->
  <section>>
    <div class="container mt-3">
      <h4>Or simplified with a function:</h4>
    </div>
    <?php
    if ($msg && in_array($msg_type, ['Update', 'Error'])) {
      $alert_class = ($msg_type == 'Update') ? 'success' : 'danger';
    ?>
    <div class="container mt-3">
      <div class="alert alert-<?= $alert_class ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="index-work.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php } ?>
  </section>>

  <!-- Even cleaner with a function: -->
  <section>>
    <div class="container mt-3">
      <h4>Even cleaner with a function:</h4>
    </div>
    <?php
    function showAlert($msg_type, $msg)
    {
      if (empty($msg)) return '';

      $alert_class = match ($msg_type) {
        'Update' => 'success',
        'Error' => 'danger',
        default => 'info'
      };

      return '
        <div class="container mt-3">
            <div class="alert alert-' . $alert_class . ' alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($msg) . '
                <a href="index-work.php" class="alert-link">Refresh</a>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    ';
    }

    echo showAlert($msg_type, $msg);
    ?>
  </section>>

  <!-- Or with dynamic alert type: -->
  <section>>
    <div class="container mt-3">
      <h4>Or with dynamic alert type:</h4>
    </div>
    <?php if ($msg) {
      $alert_type = ($msg_type == 'Update') ? 'success' : (($msg_type == 'Error') ? 'danger' : 'info');
    ?>
    <div class="container mt-3">
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="index-work.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php } ?>
  </section>>

  <!-- -------------------------------------------------------------- -->

  <!--  -->
  <section>>
  </section>>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>