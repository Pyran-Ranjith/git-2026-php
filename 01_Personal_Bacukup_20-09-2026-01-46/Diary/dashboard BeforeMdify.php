<!-- dashboard.php -->
<?php
require_once "header-dashboard.php";
// require_once "../config_db.php";
global $conn;
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
        <a href="dashboard.php" class="alert-link">Refresh</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    </div>
  <?php } ?>

  <!-- Boxes -->
  <section class="p-0" id="diary_cards">
    <div class="container mt-3 mb-2">
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h4 class="mb-0 text-center">Diary - Categories</h4>
        </div>
      </div>
    </div>
    <?php
    // Default filters
    $date_from    = $sql_date_from ?? '';
    $date_to    = $sql_date_to ?? '';
    $status    = $sql_status ?? '';
    $category  = $sql_categry ?? '';
    $sql_orderby = "DESC";
    ?>

    <div class="container">
      <div class="row g-4">

        <!-- Category: Bills monthly -->
        <?php
        $card_header = "Bills monthly";
        $card_bg = "bg-info";
        $sql_categry = "bill_monthly";
        $sql_orderby = "ASC";
        require "include/card_box_diary.php";
        ?>
        <noscript>
          <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 shadow-sm bg-info text-dark">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">Bills monthly</span>
                <!-- <span class="badge bg-success">Active</span> -->
              </div>
              <div class="card-body">
                <table class="table table-hover">
                  <thead class="table-dark">
                    <tr>
                      <!-- <th scope="col">ID</th>
            <th scope="col">Date</th> -->
                      <th scope="col">Status</th>
                      <!-- <th scope="col">Category</th> -->
                      <th scope="col">Event</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $conn_category = getConn1("ranjith_personal");
                    $sql = "SELECT * FROM `diary` WHERE category = 'bill_monthly'";
                    $result_category = mysqli_query($conn_category, $sql);

                    if (mysqli_num_rows($result_category) === 0) {
                      echo '<p class="text-muted mb-0">No records found.</p>';
                    }
                    while ($row = mysqli_fetch_assoc($result_category)) {
                    ?>
                      <tr>
                        <!-- <td><?= htmlspecialchars($row["id"]) ?></td>
              <td><?= htmlspecialchars($row["date"]) ?></td> -->
                        <td><?= htmlspecialchars($row["status"]) ?></td>
                        <!-- <td><?= htmlspecialchars($row["category"]) ?></td> -->
                        <td><?= htmlspecialchars($row["event"]) ?></td>
                        <td>
                          <!-- <a class="btn btn-success btn-sm me-0" href="diary/admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>" role="button">Manage</a> -->
                          <a class="btn btn-success btn-sm me-0" href="diary/admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a>
                        </td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </noscript>

        <!-- Category: Helth -->
        <?php
        $card_header = "Helth";
        $card_bg = "bg-success";
        $sql_categry = "helth";
        require "include/card_box_diary.php";
        ?>

        <!-- Category: Login -->
        <?php
        $card_header = "Login";
        $card_bg = "bg-primary";
        $sql_categry = "login";
        require "include/card_box_diary.php";
        ?>

        <!-- Category: Donation -->
        <?php
        $card_header = "Donation";
        $card_bg = "bg-info";
        $sql_categry = "donation";
        require "include/card_box_diary.php";
        ?>

        <!-- Category: Lending -->
        <?php
        $card_header = "Lending";
        $card_bg = "bg-success";
        $sql_categry = "lending";
        require "include/card_box_diary.php";
        ?>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <a href="#top" class="btn btn-warning mb-0">Jump Top</a>
        </div>
      </div>
  </section>

  <!-- Box Diary with search -->
  <section class="p-3" id="diary_with_search">
    <div class="container">
      <div class="row text-center g-4">
        <div class="col-md">
          <div class="card bg-dark text-light">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-laptop"></i>
              </div>
              <h3 class="card-title mb-3">Diary with Search</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Search Form -->
    <div class="container mt-4">
      <div class="card">
        <div class="card-header bg-secondary text-light">
          <h5 class="mb-0">Search Diary</h5>
        </div>
        <div class="card-body">
          <form method="GET" action="" class="row g-3 align-items-end">
            <div class="col-md-3">
              <label for="date_from" class="form-label">Date From</label>
              <input type="date" class="form-control" id="date_from" name="date_from"
                value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
            </div>
            <div class="col-md-3">
              <label for="date_to" class="form-label">Date To</label>
              <input type="date" class="form-control" id="date_to" name="date_to"
                value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
            </div>
            <div class="col-md-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="">-- All --</option>
                <?php
                // Fetch distinct statuses for the dropdown
                $conn_status = getConn1("ranjith_personal");
                $status_sql = "SELECT DISTINCT `status` FROM `diary` ORDER BY `status` ASC";
                $status_result = mysqli_query($conn_status, $status_sql);
                $selected_status = $_GET['status'] ?? '';
                while ($srow = mysqli_fetch_assoc($status_result)) {
                  $sel = ($selected_status == $srow['status']) ? 'selected' : '';
                  echo '<option value="' . htmlspecialchars($srow['status']) . '" ' . $sel . '>'
                    . htmlspecialchars($srow['status']) . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-md-3">
              <label for="category" class="form-label">Category</label>
              <select class="form-select" id="category" name="category">
                <option value="">-- All --</option>
                <?php
                // Fetch distinct categorys for the dropdown
                $conn_category = getConn1("ranjith_personal");
                $category_sql = "SELECT DISTINCT `category` FROM `diary` ORDER BY `category` ASC";
                $category_result = mysqli_query($conn_category, $category_sql);
                $selected_category = $_GET['category'] ?? '';
                while ($srow = mysqli_fetch_assoc($category_result)) {
                  $sel = ($selected_category == $srow['category']) ? 'selected' : '';
                  echo '<option value="' . htmlspecialchars($srow['category']) . '" ' . $sel . '>'
                    . htmlspecialchars($srow['category']) . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Search
              </button>
              <a href="dashboard.php" class="btn btn-outline-dark w-100">Reset</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="container mt-3">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="diary/admin.php" class="btn btn-success mb-3">Manage All</a>
      </div>
      <table class="table table-hover text-center ">
        <thead class="table-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col">Category</th>
            <th scope="col">Event</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- BM-2 -->




          <?php
          $conn = getConn1("ranjith_personal");

          // Build query with optional filters
          $date_from = $_GET['date_from'] ?? '';
          $date_to   = $_GET['date_to'] ?? '';
          $status    = $_GET['status'] ?? '';
          $category    = $_GET['category'] ?? '';

          $conditions = [];
          $params = [];
          $types = '';

          if ($date_from !== '') {
            $conditions[] = "`date` >= ?";
            $params[] = $date_from;
            $types .= 's';
          }
          if ($date_to !== '') {
            $conditions[] = "`date` <= ?";
            $params[] = $date_to;
            $types .= 's';
          }
          if ($status !== '') {
            $conditions[] = "`status` = ?";
            $params[] = $status;
            $types .= 's';
          }
          if ($category !== '') {
            $conditions[] = "`category` = ?";
            $params[] = $category;
            $types .= 's';
          }

          $sql = "SELECT * FROM `diary`";
          if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
          }
          $sql .= " ORDER BY `date` DESC";

          if (!empty($params)) {
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          } else {
            $result = mysqli_query($conn, $sql);
          }

          if (mysqli_num_rows($result) === 0) {
            echo '<tr><td colspan="4" class="text-muted">No records found.</td></tr>';
          }

          while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <tr>
              <td><?= htmlspecialchars($row["id"]) ?></td>
              <td><?= htmlspecialchars($row["date"]) ?></td>
              <td><?= htmlspecialchars($row["status"]) ?></td>
              <td><?= htmlspecialchars($row["category"]) ?></td>
              <td><?= htmlspecialchars($row["event"]) ?></td>
              <td>
                <a class="btn btn-success btn-sm me-0" href="diary/admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>" role="button">Manage</a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="#top" class="btn btn-warning mb-3">Jump Top</a>
        <!-- <i class="fas fa-arrow-up fas-warning"></i> -->
      </div>

    </div>

  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>