<!-- edit.php -->
<?php
require_once "header.php"; //To load base_path_root
global $conn;
global  $error_no;
global  $error_msg;
$err = false;

$id = ($_GET["id"] ?? "");
// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
  $date = $_POST['date'];
  $status = $_POST['status'];
  $category = $_POST['category'];
  $event = $_POST['event'];

$sql = "UPDATE `diary` SET `date`='$date', `status`='$status', `category`='$category', `event`='$event' WHERE id = $id";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $msg = "Record updated successfully for ";
    header("Location: " . $base_url_diary . "/index.php?msg_type=Update&msg=" . $msg . urlencode($date) . " " . urlencode($event));
  } else {
    echo "Failed: " . mysqli_error($conn);
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
    $msg = "Record not be updated,. Error: " . $error_msg;
    header("Location: " . $base_url_diary . "/index.php?msg_type=Error&msg=" . urlencode($msg));
  }
}
?>

<title>edit.php</title>
</head>

<body>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Manage Diary | Edit Record</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>
  </div>

  <?php
  $sql = "SELECT * FROM `diary` WHERE id = $id LIMIT 1";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  ?>

  <div class="contaner d-flex justify-content-center">
    <form action="" method="post" style="width: 50vw; min-width: 300px">
      <div class="row mb-3">

        <div class="col">
          <label class="form-label">Date:</label>
          <input type="date" class="form-control" name="date" placeholder="Date"
            value="<?php echo $row['date'] ?>">
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Status:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="info" value="info" checked
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
              <?= ($row['status'] == 'info') ? 'checked' : '' ?> />
            <label class="form-check-label" for="info"> Info </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="login" value="login" 
              <?= ($row['status'] == 'login') ? 'checked' : '' ?> />
            <label class="form-check-label" for="login"> Login </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="helth" value="helth"
              <?= ($row['status'] == 'helth') ? 'checked' : '' ?> />
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
        </div>

        <div class="col">
          <label class="form-label">Event:</label>
          <input type="text" class="form-control" name="event" placeholder="Event"
            value="<?php echo $row['event'] ?>">
        </div>
      </div>


      <div>
        <button type="submit" class="btn btn-success" name="submit">
          Update
        </button>
        <a href="<?= $base_url_diary ?>/index.php" class="btn btn-primary">Cancel</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>