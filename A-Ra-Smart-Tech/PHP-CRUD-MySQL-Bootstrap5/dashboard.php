<?php
require_once "header-dashboard.php";
global $conn;
// global $setvername1;
function getConn1($db_name)
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = $db_name;

  $conn1 = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn1) {
    die("Connection failed: " . mysqli_connect_error());
  }
  // echo "Connected successfully";
  return $conn1;
}
?>
<title>Dashboard</title>
</head>

<body>
  <?php
  $msg_type = ($_GET["msg_type"] ?? "");
  $msg = ($_GET["msg"] ?? "");
  ?>
  <?php if ($msg) {
    $alert_type = ($msg_type == 'Error') ? 'danger' : 'success';
  ?>
    <div class="container mt-3">
      <div class="alert alert-<?= $alert_type ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <a href="index-work.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php } ?>


  <!-- Content -->
  <!-- <div class="container mt-3"> -->
  <!-- </div> container mt-3 -->

  <!-- Boxes -->
  <section class="p-5" id="diary">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-md">
          <div class="card bg-primary text-light">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-laptop"></i>
              </div>
              <h3 class="card-title mb-3">Diary</h3>
              <!-- <p class="card-text">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Iure, quas quidem possimus dolorum esse eligendi?
              </p> -->
              <!-- <a href="#" class="btn btn-primary">Read More</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container mt-3">

      <table class="table table-hover text-center ">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col">Event</th>
            <!-- <th scope="col">Action</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
          $conn = getConn1("ranjith_personal");
          $sql = "SELECT * FROM `diary` ORDER BY `date` DESC";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr>
              <!-- <td><?= $row["id"] ?></td> -->
              <td><?= $row["id"] ?></td>
              <td><?= $row["date"] ?></td>
              <td><?= $row["status"] ?></td>
              <td><?= $row["event"] ?></td>
              <!-- With With buttons -->
              <td>
                <!-- <a class="btn btn-primary btn-sm me-0" href="view.php?id=<?php echo $row["id"] ?>" role="button">View</a>
                <a class="btn btn-success btn-sm me-0" href="edit.php?id=<?php echo $row["id"] ?>" role="button">Edit</a> -->
                <!-- Delete Button to load the Delete Model-->
                <!-- <a class="btn btn-danger btn-sm me-0" data-bs-toggle="modal"
                  data-bs-target="#deleteModal" data-id="<?= $row["id"] ?>">
                  Delete
                </a> -->
              </td>

              <!-- With Font Awesome Icons -->
              <!-- <td> 
              <a href="edit.php?id=<?php echo $row["id"] ?>" class="link-primay"><i
                  class="fa-solid fa-pen-to-square fs-6 me-3"></i></a>
              <a href="edit.php?id=<?php echo $row["id"] ?>" class="link-success"><i
                  class="fa-solid fa-pen-to-square fs-6 me-3"></i></a>
              <a href="dxelete.php?id=<?= $row["id"] ?>" class="link-danger"><i class="fa-solid fa-trash fs-6"></i></a>
            </td> -->
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>



  </section>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true bg-danger">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this record?</p>
          <p class="text-danger"><strong>This action cannot be undone!</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
        </div>
      </div>
    </div>
  </div>



  <script>
    // Pass the ID to the delete link
    document.addEventListener('DOMContentLoaded', function() {
      var deleteModal = document.getElementById('deleteModal');
      deleteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var confirmLink = document.getElementById('confirmDelete');
        confirmLink.href = 'Pages/delete.php?id=' + id;
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>