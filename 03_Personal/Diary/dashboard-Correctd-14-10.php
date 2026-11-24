<!-- dashboard.php -->
<?php
/** @var String $cat */
$cat = trim($_POST['cat'] ?? '');
?>
<?php
require_once "../config_db.php";
require_once "include/header.php";
?>

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


<!-- Page Header -->
<header class="py-4 border-bottom border-secondary border-opacity-10 mb-4">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-1 small">
        <li class="breadcrumb-item"><a href="dashboard.php" class="text-gold text-decoration-none">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="admin.php" class="text-gold text-decoration-none">Manage</a></li>
        <li class="breadcrumb-item active text-muted" aria-current="page">Add Record</li>
      </ol>
    </nav>
    <h1 class="brand-font h2 fw-bold text-white mb-0">Dashboard Diary Entries</h1>
    <p class="text-muted mb-0">View Diary entries in card view and navigate to manage them.</p>
  </div>
</header>

<!-- Boxes -->
<section class="p-0" id="diary_cards">
  <?php
  // Default filters
  $date_from    = $sql_date_from ?? '';
  $date_to    = $sql_date_to ?? '';
  $status    = $sql_status ?? '';
  $category  = $sql_categry ?? '';
  // $event     = $_GET['event'] ?? '';   // ✅ add this
  $event  = $sql_event ?? '';
  $sql_orderby = "DESC";
  $srch_event_placeholder = "Search event...";
  ?>

  <div class="container">
    <div class="row g-4">

      <!-- Category: Bills monthly -->
      <?php
      $card_header = "Bills monthly";
      $card_bg = "bg-info";
      $sql_categry = "bill_monthly";
      $sql_event = "634.75";
      $sql_orderby = "ASC";
      $srch_event_placeholder = "Search event...";
      require "include/card_box_diary.php";
      ?>

      <!-- Category: Helth -->
      <?php
      $card_header = "Helth";
      $card_bg = "bg-success";
      $sql_categry = "helth";
      $srch_event_placeholder = "Search event...";
      require "include/card_box_diary.php";
      ?>

      <!-- Category: General -->
      <?php
      $card_header = "Genaral";
      $card_bg = "bg-primary";
      $sql_categry = "genaral";
      $srch_event_placeholder = "Cricket,Tv or Type event...";
      require "include/card_box_diary.php";
      ?>

      <!-- Category: Donation -->
      <?php
      $card_header = "Donation";
      $card_bg = "bg-info";
      $sql_categry = "donation";
      $srch_event_placeholder = "Search event...";
      require "include/card_box_diary.php";
      ?>

      <!-- Category: Lending -->
      <?php
      $card_header = "Lending";
      $card_bg = "bg-success";
      $sql_categry = "lending";
      $srch_event_placeholder = "Search event...";
      require "include/card_box_diary.php";
      ?>

      <!-- Category: Login -->
      <?php
      $card_header = "Login";
      $card_bg = "bg-primary";
      $sql_categry = "login";
      $srch_event_placeholder = "Search event...";
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
    <div class="luxury-card p-4 mb-4">
      <div class="luxury-card p-4 mb-4">
        <h5 class="brand-font text-gold mb-3">
          <i class="bi bi-tag me-2"></i> Search Diary
        </h5>
        <div class="card-body">
          <form method="GET" action="" class="row g-3 align-items-end">

            <div class="col-md-2">
              <label for="date_from" class="form-label">Date From</label>
              <input type="date" class="form-control" id="date_from" name="date_from"
                value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
            </div>

            <div class="col-md-2">
              <label for="date_to" class="form-label">Date To</label>
              <input type="date" class="form-control" id="date_to" name="date_to"
                value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
            </div>

            <div class="col-md-2">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="">-- All --</option>
                <?php
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

            <div class="col-md-2">
              <label for="category" class="form-label">Category</label>
              <select class="form-select" id="category" name="category">
                <option value="">-- All --</option>
                <?php
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

            <div class="col-md-2">
              <label for="event" class="form-label">Event</label>
              <input type="text" class="form-control" id="event" name="event"
                placeholder="Search event..."
                value="<?= htmlspecialchars($_GET['event'] ?? '') ?>">
            </div>

            <div class="col-md-2 d-flex gap-2">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Search
              </button>
              <a href="dashboard.php" class="btn btn-outline-dark w-100">Reset</a>
            </div>

          </form>
        </div>
      </div>
    </div>


    <noscript>
      <!-- Search Form -->
      <div class="container mt-4">
        <div class="luxury-card p-4 mb-4">
          <div class="luxury-card p-4 mb-4">
            <h5 class="brand-font text-gold mb-3">
              <i class="bi bi-tag me-2"></i> Search Diary
            </h5>
            <div class="card-body">

              <form>
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

                <!-- ✅ NEW: Event search field -->
                <div class="col-md-3">
                  <label for="event" class="form-label">Event</label>
                  <input type="text" class="form-control" id="event" name="event"
                    placeholder="Search event..."
                    value="<?= htmlspecialchars($_GET['event'] ?? '') ?>">
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
      </div>
    </noscript>




    <div class="container mt-3">
      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="admin.php" class="btn btn-success mb-3">Manage All</a>
      </div>
      <table class="table-luxury table table-hover  ">
        <thead>
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

          // ✅ NEW: Event filter (partial match, case-insensitive)
          $event = $_GET['event'] ?? '';
          if ($event !== '') {
            $conditions[] = "`event` LIKE ?";
            $params[] = '%' . $event . '%';
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
            echo '<tr><td colspan="6" class="text-muted">No records found.</td></tr>';
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
                <a class="btn btn-success btn-sm me-0" href="admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>" role="button">Manage</a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="#top" class="btn btn-warning mb-3">Jump Top</a>
      </div>

    </div>
  </div>
</section>

<script>
  document.getElementById('eventSelect').addEventListener('change', function() {
    if (this.value !== '') {
      document.getElementById('event').value = this.value;
    }
  });
</script>

<?php
require_once "include/footer.php";
?>