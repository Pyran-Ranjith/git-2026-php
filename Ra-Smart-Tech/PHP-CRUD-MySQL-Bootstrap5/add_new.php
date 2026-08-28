<?php
require_once "db_conn.php";
global $conn;
global  $error_no;
global  $error_msg;
$err = false;

// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];

  $sql = "INSERT INTO `crudd`(`id`, `first_name`, `last_name`, `email`, `gender`) VALUES (NULL,'$first_name','$last_name','$email','$gender')";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    header("Location: index-work.php?msg=New record created successfully for " . urlencode($first_name) . " " . urlencode($last_name));
  } else {
    // echo "Failed: " . mysqli_error($conn);
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
    header("Location: index-work.php?msg=Error occured: " . urlencode($error_msg));
  }
}
include_once "header.php";
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
      <h3>Add New User</h3>
      <p class="text-muted">Compleate the form to add a new user</p>
    </div>
  </div>

  <div class="contaner d-flex justify-content-center">
    <form action="add_new.php" method="post" style="width: 50vw; min-width: 300px">
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">First Name:</label>
          <input type="text" class="form-control" name="first_name" placeholder="First Name" />
        </div>

        <div class="col">
          <label class="form-label">Last Name:</label>
          <input type="text" class="form-control" name="last_name" placeholder="Last Name" />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="name@email.com" />
      </div>

      <div class="form-group mb-3">
        <label class="form-label">Gender:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="male" checked />
          <label class="form-check-label" for="male"> Male </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="female" />
          <label class="form-check-label" for="female"> Female </label>
        </div>
      </div>

      <div>
        <button type="submit" class="btn btn-success" name="submit">
          Save
        </button>
        <a href="index-work.php" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>