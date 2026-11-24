<!-- Diary/edit.php -->
<?php
ob_start();  // ← Add this as FIRST line to avoid 
require_once "../config_db.php";
require_once "include/header.php";
// session_start();

/* others */
$cur_pgmname = basename($_SERVER['SCRIPT_NAME']);
/* parameters */
$return_url = ($_GET["return_url"] ?? "admin.php");
$id = ($_GET["id"] ?? "");

$conn = getConn1("ranjith_personal");
?>

<title> Edit | Diary</title>
</head>
<?php
  // Add this to avoid error intelephense(P1008)
/** @var mysqli $conn */
/** @var String $base_url_root */
/** @var String $base_url_diary */
/** @var String $error_msg */
/** @var int $error_no */
?>

<?php

if (!isset($base_url_diary)) {
  $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https://' : 'http://';
  $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
  $base_url_diary = $protocol . $host . rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
}

$err = false;

$sql = "SELECT * FROM `diary` WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result) {
  $row = mysqli_fetch_assoc($result);
} else {
  if (!mysqli_query($conn, $sql)) {
    $error_no = mysqli_errno($conn);
    $error_msg = mysqli_error($conn);
    $err = true;
  }
  $msg = "Record not updated,. Error: " . $error_msg;
  header("Location: <?= $return_url ?>?alert_type=danger&msg=" . urlencode($msg));
  exit;
}


// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
  $date = $_POST['date'];
  $event = $_POST['event'];
  $status = $_POST['status'];
  $category = $_POST['category'];

  // $return_url  ?? "admin.php";
  $sql = "UPDATE `diary` SET `date`='$date', `status`='$status', `category`='$category', `event`='$event' WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $msg = "Record updated successfully for ";
    // header("Location: " . $base_url_diary . "/" . $return_url?alert_type=success&msg=" . $msg . urlencode($date) . " " . urlencode($event));
    $query = http_build_query([
      'alert_type' => 'success',
      'msg'        => $msg . ' ' . $date . ' ' . $event,
    ]);

    header("Location: " . $base_url_diary . "/" . $return_url . "?" . $query);
    exit();
  } else {
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
    $msg = "Record not updated,. Error: " . $error_msg;
    header("Location: <?= $return_url ?>?alert_type=danger&msg=" . urlencode($msg));
    exit;
  }
}
?>

<title>Edit | Diary</title>
</head>

<body>

  <?php if ($err) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <h4 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Database Error</h4>
      <hr>
      <p><strong>Error Number:</strong> <code><?= $error_no ?></code></p>
      <p><strong>Error Description:</strong> <?= htmlspecialchars($error_msg) ?></p>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php } ?>

  <!-- Page Header -->
  <header class="py-4 border-bottom border-secondary border-opacity-10 mb-4">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-1 small">
          <li class="breadcrumb-item"><a href="dashboard.php" class="text-gold text-decoration-none">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="admin.php" class="text-gold text-decoration-none">Admin</a></li>
          <li class="breadcrumb-item active text-muted" aria-current="page">Edit Record</li>
        </ol>
      </nav>
      <h1 class="brand-font h2 fw-bold text-white mb-0">Edit Diary Entry</h1>
      <p class="text-muted mb-0">Update a existig record with status and event.</p>
    </div>
  </header>

  <!-- <div class="container">
    <div class="text-center mb-4">
      <h3>Manage Diary | Add New Record</h3>
      <p class="text-muted">Compleate the form to add a new record</p>
    </div>
  </div> -->

  <!-- Main Container -->
  <!-- <main class="container mb-5"> -->
  <div class="contaner d-flex justify-content-center">
    <form action="" method="post" style="width: 50vw; min-width: 300px">
      <div class="row mb-3">
        <!-- <td><?= $row["id"] ?></td>
                <td><?= $row["date"] ?></td>
                <td><?= $row["status"] ?></td>
                <td><?= $row["category"] ?></td>
                <td><?= $row["event"] ?></td> -->

        <div class="col">
          <label class="form-label">Date:</label>
          <input type="date" class="form-control" name="date" placeholder="Date" value="<?= $row["date"] ?>" />
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Status:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="info" value="info"
              <?= ($row['status'] == 'info') ? 'checked' : '' ?> />
            <label class="form-check-label" for="info"> Info </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="pending" value="pending"
              <?= ($row['status'] == 'pending') ? 'checked' : '' ?> />
            <label class="form-check-label" for="pending"> Pending </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="compleated" value="completed"
              <?= ($row['status'] == 'completed') ? 'checked' : '' ?> />
            <label class="form-check-label" for="compleated"> Compleated </label>
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Category:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="info" value="info" checked
              <?= ($row['category'] == 'info') ? 'checked' : '' ?> />
            <label class="form-check-label" for="info"> Info </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="login" value="login"
              <?= ($row['category'] == 'login') ? 'checked' : '' ?> />
            <label class="form-check-label" for="login"> Login </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="helth" value="helth"
              <?= ($row['category'] == 'helth') ? 'checked' : '' ?> />
            <label class="form-check-label" for="helth"> Helth </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="donation" value="donation"
              <?= ($row['category'] == 'donation') ? 'checked' : '' ?> />
            <label class="form-check-label" for="donation"> Donation </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="bill_monthly" value="bill_monthly"
              <?= ($row['category'] == 'bill_monthly') ? 'checked' : '' ?> />
            <label class="form-check-label" for="bill_monthly"> Bill_monthly </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="lending" value="lending"
              <?= ($row['category'] == 'lending') ? 'checked' : '' ?> />
            <label class="form-check-label" for="lending"> Lending </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="tv" value="tv"
              <?= ($row['category'] == 'tv') ? 'checked' : '' ?> />
            <label class="form-check-label" for="tv"> Tv </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="guarantee" value="guarantee"
              <?= ($row['category'] == 'guarantee') ? 'checked' : '' ?> />
            <label class="form-check-label" for="guarantee"> Guarantee </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="taskrepeated" value="taskrepeated"
              <?= ($row['category'] == 'taskrepeated') ? 'checked' : '' ?> />
            <label class="form-check-label" for="taskrepeated"> Task Repeated </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="genaral" value="genaral"
              <?= ($row['category'] == 'genaral') ? 'checked' : '' ?> />
            <label class="form-check-label" for="genaral"> Genaral </label>
          </div>
        </div>

        <div class="col">

          <label class="form-label">Event:</label>
          <input type="text" class="form-control" name="event" placeholder="Event" value="<?= $row["event"] ?>" />
        </div>

      </div>
      <div>
        <button type="submit" class="btn btn-success" name="submit">
          Save
        </button>
        <a href="<?= $base_url_diary ?>/<?= $return_url ?>" class="btn btn-primary">Cancel</a>
      </div>

  </div>

  <!-- </div> -->

  <!-- <div class="container"> -->
  <!-- </div> -->
  </form>
  </div>
  <!-- </main> -->

  <?php
  require_once "include/footer.php";
  ?>