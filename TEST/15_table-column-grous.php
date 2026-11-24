<?php
require_once "../03_Personal/config_db.php";
// require_once "include/header.php";
?>
<!DOCTYPE html>
<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Test/05.php</title>
</head>

<body>
  <?php
  $msg_type = "Update";
  $msg = "Record updated successfully!";
  ?>

  <!--  -->
  <section>
    <div class="container mt-3">
      <h4>Table column group:</h4>
    </div>
    <div class="container mt-3">
      <!-- <table class="table-luxury table table-hover  "> -->

      <table class="table-luxury table table-hover" style="table-layout: fixed; width: 100%;">
        <colgroup>
          <col style="width: 10%;">
          <col style="width: 90%;">
        </colgroup>

        <thead class="table-dark">
          <tr>
            <!-- <th scope="col">ID</th>
            <th scope="col">Date</th> -->
            <th scope="col">Status</th>
            <!-- <th scope="col">Category</th> -->
            <th scope="col">Event</th>
            <!-- <th scope="col">Action</th> -->
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
              <!-- <td><?= htmlspecialchars($row["id"]) ?></td>
              <td><?= htmlspecialchars($row["date"]) ?></td> -->
              <td><?= htmlspecialchars($row["status"]) ?></td>
              <!-- <td><?= htmlspecialchars($row["category"]) ?></td> -->
              <td><?= htmlspecialchars($row["event"]) ?></td>
              <!-- <td>
                <a class="btn btn-success btn-sm me-0" href="admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>&return_url=<?php echo $cur_pgmname ?>" role="button">Manage</a>
              </td> -->
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>>

  <!-- -------------------------------------------------------------- -->

  <!--  -->
  <section>>
  </section>>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>