<!-- Diary/error_page.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "../config_db.php";
require_once "include/header.php";
?>
<?php
// $conn = getConn1("ranjith_personal");
?>
<title> Error_Page</title>
</head>

<body>
  <?php
  // Add this to avoid error intelephense(P1008)
  /** @var String $error_msg */
  $return_url = $_GET['return_url'] ?? 'admin.php';
  ?>

  <!-- Parameter Alert -->
  <secction>
    <?php
    $msg = ($_GET["msg"] ?? "xxx");
    if ($msg) {
      $alert_type = ($_GET["alert_type"] ?? "info");
      // $confirm  = $_POST['confirm']  ?? '';
    ?>
      <div class="container mt-3">
        <br><br>
        <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($msg) ?>
          <a href="<?= $return_url ?>" class="alert-link">Go back</a>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
    <?php } ?>
  </secction>

  <?php
  require_once "include/footer.php";
  ?>