<?php
// /** @var String $tag_id */
?>
     <style>
       .container-searchbox {
         font-size: 12px;
       }

       .container-searchbox * {
         font-size: inherit;
       }
     </style>

     <div id=<?= $card_bg ?> col-md-6 col-lg-4 mb-3>
       <div class="card h-100 shadow-sm text-dark">
         <div class="card-header d-flex justify-content-center align-items-center">
           <span class="fw-bold fs-4 text-center"><?= $card_header ?></span>
         </div>
         <div class="card-body" style="max-height: 400px; overflow-y: auto;">
           <table class="table table-luxury table-hover text-center">
             <thead class="table-dark">
               <tr>
                 <th scope="col">Status</th>
                 <th scope="col">Event</th>
                 <th scope="col">Action</th>
               </tr>
             </thead>
             <tbody>
               <?php
                $conn = getConn1();
                // Build query with optional filters
                $date_from    = $sql_date_from ?? '';
                $date_to    = $sql_date_to ?? '';
                $status    = $sql_status ?? '';
                $category  = $sql_categry ?? '';
                $event  = $sql_event ?? '';

                $conditions = [];
                $params = [];
                $types = '';

                $event     = $_GET['event'] ?? '';;
                $category_event     = $_GET['category_event'] ?? '';

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
                $event = $_GET['event'] ?? '';
                if ($event !== '' && $category_event === $category) {
                  $conditions[] = "`event` LIKE ?";
                  $params[] = '%' . $event . '%';
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
                   <td>
                     <?php if ($row["status"] === "completed"): ?>
                       <span class="badge bg-success"><?= htmlspecialchars($row["status"]) ?></span>
                     <?php else: ?>
                       <span class="badge bg-danger text-dark"><?= htmlspecialchars($row["status"]) ?></span>
                     <?php endif; ?>
                   </td> <!-- <td><?= htmlspecialchars($row["category"]) ?></td> -->
                   <td><?= htmlspecialchars($row["event"]) ?></td>
                   <td>
                     <!-- <a class="btn btn-dark btn-sm me-5" href="./admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a> -->
                     <a class="btn btn-secondary btn-sm me-5" href="./admin.php?rec_filter=Manage&id=<?php echo $row["id"] ?>"><i class="bi bi-arrow-right"></i></a>
                   </td>
                 </tr>
               <?php
                }
                ?>
             </tbody>
           </table>

           <?php
            $value0 = '';
            $value0 = '';
            $category1 = $_GET['category1'] ?? '';
            $event0     = $_GET['event'] ?? '';
            // Initialize to empty string so it's always defined
            $search_input_bg_color = "white";

            // Only keep the event value if the category matches
            if ($event0 !== '' && isset($category_event) && $category_event === $category) {
              $value0 = htmlspecialchars($event0);
              $value0     = $category1 ?? $value0;
              $search_input_bg_color = "#9bf2a2";  // Light green
            } else {
              $value0     = $category1;
            }
            ?>
           <!-- Search Form -->
           <!-- <div class="container mt-3"> -->
           <div class="container container-searchbox mt-3 p-0">
             <form method="GET" action="" class="row g-2 align-items-center justify-content-center">
               <input type="hidden" name="category_event" value="<?= $category ?? '' ?>">

               <div class="col-auto">
                 <label for="event" class="form-label mb-0 small fw-bold">Event</label>
               </div>

               <div class="col">
                 <input type="text" class="form-control form-control-sm" id="event" name="event"
                   placeholder="Search event..."
                   value="<?= $value0 ?>" style="background-color: <?= $search_input_bg_color ?>;">
               </div>

               <div class="col-auto">
                 <button type="submit" class="btn btn-primary btn-sm">
                   <i class="bi bi-search"></i> Search
                 </button>
               </div>

               <div class="col-auto">
                 <a href="dashboard.php" class="btn btn-outline-dark btn-sm">Reset</a>
               </div>

               <?php if (isset($sql_categry) && $sql_categry === 'genaral') { ?>
                 <div class="container d-flex justify-content-left mt-2">
                   <div class="row mb-3">
                     <div class="form-group mb-3">
                       <div>
                         <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="category1" id="cricket1" value="cricket" />
                           <label class="form-check-label fw-bold" for="cricket1"> Cricket </label>
                         </div>

                         <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="category1" id="tv1" value="tv" />
                           <label class="form-check-label fw-bold" for="tv1"> Tv </label>
                           <button type="submit" class="btn  btn-outline-dark btn-sm">
                             Submit
                           </button>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
               <?php } ?>
             </form>
           </div>
         </div>
       </div>
     </div>