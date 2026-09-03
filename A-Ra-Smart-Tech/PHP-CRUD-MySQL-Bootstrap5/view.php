<?php
require_once "db_conn.php";
include_once "header.php";
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
  header("Location: " . BASE_URL . "/index-work.php?msg_type=Error&msg=Invalid ID provided");
  exit();
}

// Query the database
$sql = "SELECT * FROM `crudd` WHERE id = $id LIMIT 1";
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
  header("Location: " . BASE_URL . "/index-work.php?msg_type=Error&msg=" . urlencode($msg));
  exit();
}
?>

<title>View User</title>
</head>

<body>

  <div class="container mt-5">
    <div class="text-center mb-4">
      <h3>View User Information</h3>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width: 50vw; min-width: 300px">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="first_name" disabled
              value="<?= htmlspecialchars($row['first_name'] ?? '') ?>">
          </div>

          <div class="col">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="last_name" disabled
              value="<?= htmlspecialchars($row['last_name'] ?? '') ?>">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" name="email" disabled
            value="<?= htmlspecialchars($row['email'] ?? '') ?>">
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Gender:</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="male" value="male" disabled
              <?= ($row['gender'] ?? '') == 'male' ? 'checked' : '' ?>>
            <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="female" value="female" disabled
              <?= ($row['gender'] ?? '') == 'female' ? 'checked' : '' ?>>
            <label class="form-check-label" for="female">Female</label>
          </div>
        </div>

        <div>
          <a href="<?= BASE_URL ?>/index-work.php" class="btn btn-primary">Back</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>