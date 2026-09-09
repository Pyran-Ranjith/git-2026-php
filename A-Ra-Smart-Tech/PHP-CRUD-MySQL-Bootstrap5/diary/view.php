<?php
require_once "header.php"; //To load base_path_root

global $conn;
global  $error_no;
global  $error_msg;
$err = false;

// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET["id"] ?? "";

// Validate ID
if (empty($id) || !is_numeric($id)) {
  // header("Location:  " . $base_url_root . "/index-work.php?msg_type=Error&msg=Invalid ID provided");
  $msg = "Invalid ID provided,. Error: " . $error_msg;
  header("Location: " . $base_url_diary . "/index.php?msg_type=Error&msg=" . urlencode($msg));
  exit();
}

// Query the database
$sql = "SELECT * FROM `diary` WHERE id = $id LIMIT 1";
$result = mysqli_query($conn, $sql);

// Check if query was successful
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
} else {
  // Get error details
  $error_no = mysqli_errno($conn);
  $error_msg = mysqli_error($conn);

  // Log error
  error_log("View Error: $error_no - $error_msg | SQL: $sql");

  // Redirect with error message
  $msg = "Record cannot be viewed. Error: " . $error_msg;
  header("Location: " . $base_url_diary . "/index.php?msg_type=Error&msg=" . urlencode($msg));

  exit();
}
?>

<title>View User</title>
</head>

<body>

  <div class="container mt-5">
    <div class="text-center mb-4">
      <h3>View Diary Information</h3>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width: 50vw; min-width: 300px">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Date:</label>
            <input type="text" class="form-control" name="date" disabled
              value="<?= htmlspecialchars($row['date'] ?? '') ?>">
          </div>

          <div class="col">
            <label class="form-label">Event:</label>
            <input type="text" class="form-control" name="event" disabled
              value="<?= htmlspecialchars($row['event'] ?? '') ?>">
          </div>
        </div>

        <div>
          <a href="<?= $base_url_diary ?>/index.php" class="btn btn-primary">Back</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>