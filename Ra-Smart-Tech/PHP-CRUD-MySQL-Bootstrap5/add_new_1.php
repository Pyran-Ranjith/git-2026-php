<?php
require_once "db_conn.php";

// if (!isset($conn) || !$conn) {
//    die("Database connection failed.");
// }

if (isset($_POST["submit"])) {
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   $email = $_POST['email'];
   $gender = $_POST['gender'];

   $sql = "INSERT INTO `crud`(`id`, `first_name`, `last_name`, `email`, `gender`) VALUES (NULL,'$first_name','$last_name','$email','$gender')";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      header("Location: index-work.php?msg=New record created successfully");
   } else {
      echo "Failed: " . mysqli_error($conn);
   }
}
include_once "header.php";
?>

<title>add_new_1.php</title>
</head>

<body>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Add New User</h3>
      <p class="text-muted">Compleate the form to add a new user</p>
    </div>
  </div>

  <div class="contaner d-flex justify-content-center">
    <form action="add_new_1.php" method="post" style="width: 50vw; min-width: 300px">
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

</html>