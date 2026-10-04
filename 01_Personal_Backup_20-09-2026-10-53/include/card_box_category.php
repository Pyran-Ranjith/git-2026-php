        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card h-100 shadow-sm <?= $card_bg ?> text-dark">
            <div class="card-header d-flex justify-content-center align-items-center">
              <span class="fw-bold fs-4 text-center"><?= $card_header ?></span>
            </div>
            <!-- <div class="card-body"> -->
    <!-- <div class="card-body" style="max-height: 200px; overflow-y: auto;"> -->
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
                  $conn_category = getConn1("ranjith_personal");
                  $sql = "SELECT * FROM `diary` WHERE category = '$sql_categry'";
                  $result_category = mysqli_query($conn_category, $sql);

                  if (mysqli_num_rows($result_category) === 0) {
                    echo '<p class="text-muted mb-0">No records found.</p>';
                  }
                  while ($row = mysqli_fetch_assoc($result_category)) {
                  ?>
                    <tr>
                      <td><?= htmlspecialchars($row["status"]) ?></td>
                      <td><?= htmlspecialchars($row["event"]) ?></td>
                      <td>
                        <a class="btn btn-success btn-sm me-0" href="diary/index.php?rec_filter=Manage&id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a>
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
