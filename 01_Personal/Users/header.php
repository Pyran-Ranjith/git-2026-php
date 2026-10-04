  <?php
  // Include config first
  require_once "../config_db.php";
  require_once __DIR__ . '/config.php';
  // global $conn;

  ?>
  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap 5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
      integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
      crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/<?= $g_app_favicon ?>" type="">

    <div class="container mt-3" id="top">
      <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary" data-aos="fade-down">
        <div class="container">
          <a class="navbar-brand" href="<?= $base_url_users ?>/admin.php">
            <i class="fas fa-database"></i> Users-Admin
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <!-- <a class="nav-link " aria-current="page" href="<?= $base_url_users ?>/admin.php">
                  <i class="fas fa-arrow-left"></i> Users
                </a> -->
                <a class="nav-link" aria-current="page" href="<?= $base_url_root ?>/dashboard.php">
                  <i class="fas fa-arrow-left"></i> Ranjith's Personal
                </a>
              </li>
              <li class="nav-item">
                <!-- <a class="nav-link" aria-current="page" href="<?= $base_url_users ?>/view.php"> -->
                <a class="nav-link" aria-current="page" href="#">
                  <i class="fas fa-home"></i> Home
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <br><br>