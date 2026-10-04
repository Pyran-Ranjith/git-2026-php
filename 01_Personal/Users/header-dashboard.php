  <?php
  // Include config first
  global $conn;
  require_once '../include/parameters.php';
  require_once '../config_db.php';
  require_once __DIR__ . '/config.php';

  ?>
  <!doctype html>
  <html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap 5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
      integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/<?= $g_app_favicon ?>" type="">

    <div class="container mt-3" id="top">
      <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-success" data-aos="fade-down">
        <div class="container">

          <a class="navbar-brand" href="<?= $base_url_users ?>/dashboard.php">
            <!-- <a class="navbar-brand" href="dashboard.php"> -->
            <i class="fas fa-database"></i> Users
          </a>
          <!-- <noscript> -->
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="<?= $base_url_root ?>/dashboard.php">
                  <i class="fas fa-arrow-left"></i>
                  <?= $g_app_name ?>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="<?= $base_url_users ?>/dashboard.php">
                  <i class="fas fa-home"></i> Home
                </a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Jump to</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#diary_cards">Users Cards</a></li>
                  <li><a class="dropdown-item" href="#diary_with_search">Users with Search</a></li>
                  <!-- <li><a class="dropdown-item" href="#crud">PHP Complete CRUD Application</a></li> -->
                  <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Separated link</a></li> -->
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Manage</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?= $base_url_users ?>/admin.php">Users-Admin</a></li>
                  <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li><a class="dropdown-item" href="#">Separated link</a></li> -->
                </ul>
              </li>

            </ul>
          </div>
          <!-- </noscript>           -->
        </div>
      </nav>
    </div>