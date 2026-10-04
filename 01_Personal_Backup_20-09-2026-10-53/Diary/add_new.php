<?php
require_once "../config_db.php";
require_once "header.php"; //To load base_path_root
global $conn;
global  $error_no;
global  $error_msg;
global  $base_url_diary;
$conn = getConn1("ranjith_personal");
$err = false;

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

  $sql = "INSERT INTO `diary`(`id`, `date`, `status`, `category`, `event`) VALUES (NULL,'$date','$status','$category','$event')";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    $msg = "New record created successfully for date: ";
    header("Location: " . $base_url_diary . "/index.php?msg_type=Add&msg=" . $msg . urlencode($date));
  } else {
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
    $msg = "Record not be added,. Error: " . $error_msg;
    header("Location: " . $base_url_diary . "/index.php?msg_type=Error&msg=" . urlencode($msg));
  }
}
?>

<title>add_new.php</title>
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



  <div class="container">
    <div class="text-center mb-4">
      <h3>Manage Diary | Add New Record</h3>
      <p class="text-muted">Compleate the form to add a new record</p>
    </div>
  </div>

  <div class="contaner d-flex justify-content-center">
    <form action="" method="post" style="width: 50vw; min-width: 300px">
      <div class="row mb-3">

        <div class="col">
          <label class="form-label">Date:</label>
          <input type="date" class="form-control" name="date" placeholder="Date" />
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Status:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="info" value="info" checked />
            <label class="form-check-label" for="info"> Info </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="pending" value="pending"/>
            <label class="form-check-label" for="pending"> Pending </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="compleated" value="completed" />
            <label class="form-check-label" for="compleated"> Compleated </label>
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Category:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="info" value="info" checked />
            <label class="form-check-label" for="info"> Info </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="login" value="login"/>
            <label class="form-check-label" for="login"> Login </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="helth" value="helth" />
            <label class="form-check-label" for="helth"> Helth </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="donation" value="donation" />
            <label class="form-check-label" for="donation"> Donation </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="bill_monthly" value="bill_monthly" />
            <label class="form-check-label" for="bill_monthly"> Bill_monthly </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="lending" value="lending" />
            <label class="form-check-label" for="lending"> Lending </label>
          </div>
        </div>
        <div class="col">
          <label class="form-label">Event:</label>
          <input type="text" class="form-control" name="event" placeholder="Event" />
        </div>

      </div>
    <div>
      <button type="submit" class="btn btn-success" name="submit">
        Save
      </button>
      <a href="<?= $base_url_diary ?>/index.php" class="btn btn-primary">Cancel</a>
    </div>

  </div>

  <!-- </div> -->

  <!-- <div class="container"> -->
  <!-- </div> -->
  </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>