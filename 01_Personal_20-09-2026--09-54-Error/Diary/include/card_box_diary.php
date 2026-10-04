        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card h-100 shadow-sm <?= $card_bg ?> text-dark">
            <div class="card-header d-flex justify-content-center align-items-center">
              <span class="fw-bold fs-4 text-center"><?= $card_header ?></span>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
              <table class="table table-hover">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">Status</th>
                    <th scope="col">Event</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $conn = getConn1("ranjith_personal");
                  // Build query with optional filters
                  $date_from    = $sql_date_from ?? '';
                  $date_to    = $sql_date_to ?? '';
                  $status    = $sql_status ?? '';
                  $category  = $sql_categry ?? '';
                  $event  = $sql_event ?? '';
                  $box_event = $category;
                  $box_event = $_GET[$box_event] ?? '';

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
                  if ($event !== '') {
                    $conditions[] = "`event` LIKE ?";
                    $params[] = '%' . $event . '%';
                    // $params[] = '%' . $box_event . '%';
                    $types .= 's';
                  }

                  $sql = "SELECT * FROM `diary`";
                  if (!empty($conditions)) {
                    $sql .= " WHERE " . implode(" AND ", $conditions);
                  }
                  $sql .= " ORDER BY `date` $sql_orderby";

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
                  ?>

                  <?php
                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <tr>
                      <!-- <td><?= htmlspecialchars($row["id"]) ?></td> -->
                      <!-- <td><?= htmlspecialchars($row["date"]) ?></td> -->
                      <td>
                        <?php if ($row["status"] === "completed"): ?>
                          <span class="badge bg-success"><?= htmlspecialchars($row["status"]) ?></span>
                        <?php else: ?>
                          <span class="badge bg-danger text-dark"><?= htmlspecialchars($row["status"]) ?></span>
                        <?php endif; ?>
                      </td> <!-- <td><?= htmlspecialchars($row["category"]) ?></td> -->
                      <td><?= htmlspecialchars($row["event"]) ?></td>
                      <td>
                        <!-- <a class="btn btn-success btn-sm me-0" href="diary/dashboard.php?rec_filter=Manage&id=<?php echo $row["id"] ?>" role="button">Manage</a> -->
                        <a class="btn btn-success btn-sm me-0" href="./admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a>
                      </td>
                    </tr>
                  <?php
                  }
                  $box_event = $category;
                  ?>
                </tbody>
              </table>
              <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-3">
                  <label for="event" class="form-label">Event Search</label>
                  <input type="text" class="form-control" id="<?= $box_event ?>" name="<?= $box_event ?>"
                    value="<?= htmlspecialchars($_GET[$box_event] ?? '') ?>">
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