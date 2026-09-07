<?php
require_once "../header.php"; //To load base_path_root
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
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];

  $sql = "UPDATE `crud` SET `first_name`='$first_name',`last_name`='$last_name',`email`='$email',`gender`='$gender' WHERE id = $id";

  $result = mysqli_query($conn, $sql);

  if ($result) {
  $msg = "Record updated successfully for ";
  header("Location: " . $base_url_root . "/index-work.php?msg_type=Update&msg=" . $msg . urlencode($first_name) . " " . urlencode($last_name));
  } else {
    echo "Failed: " . mysqli_error($conn);
    if (!mysqli_query($conn, $sql)) {
      $error_no = mysqli_errno($conn);
      $error_msg = mysqli_error($conn);
      $err = true;
    }
  $msg = "Record not be updated,. Error: " . $error_msg;
  header("Location: " . $base_url_root . "/index-work.php?msg_type=Error&msg=" . urlencode($msg));
  }
}
?>

<title>edit.php</title>
</head>

<body>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit User Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>
  </div>

  <?php
  $sql = "SELECT * FROM `crud` WHERE id = $id LIMIT 1";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  ?>

  <div class="contaner d-flex justify-content-center">
    <form action="" method="post" style="width: 50vw; min-width: 300px">
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">First Name:</label>
          <input type="text" class="form-control" name="first_name" placeholder="First Name"
            value="<?php echo $row['first_name'] ?>">
        </div>

        <div class="col">
          <label class="form-label">Last Name:</label>
          <input type="text" class="form-control" name="last_name" placeholder="Last Name"
            value="<?php echo $row['last_name'] ?>">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>" placeholder="
          ame@email.com" />
      </div>

      <div class="form-group mb-3">
        <label class="form-label">Gender:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="male" value="male"
            <?php echo ($row["gender"] == 'male') ? "checked" : ""; ?>>
          <label class="form-check-label" for="male"> Male </label>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="female" value="female"
            <?php echo ($row["gender"] == 'female') ? "checked" : ""; ?>>
          <label class="form-check-label" for="female"> Female </label>

        </div>
      </div>

      <div>
        <button type="submit" class="btn btn-success" name="submit">
          Update
        </button>
          <a href="<?= $base_url_root ?>/index-work.php" class="btn btn-primary">Cancel</a>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>