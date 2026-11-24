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


      <noscript>
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
                                      <i class="fas fa-arrow-left"></i> RRanjith's Personal
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <!-- <a class="nav-link" aria-current="page" href="<?= $base_url_users ?>/view.php"> -->
                                  <a class="nav-link" aria-current="page" href="#">
                                      <i class="fas fa-home"></i> HHome
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <!-- <a class="nav-link" aria-current="page" href="<?= $base_url_users ?>/view.php"> -->
                                  <a class="nav-link" aria-current="page" href="#">
                                      <i class="fas fa-home"></i> Next
                                  </a>
                              </li>

                              <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-1" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <div class="d-flex flex-column text-start">
                                          <span class="fw-semibold lh-1 small"><?= $_SESSION['currentuser']['username'] ?></span>
                                      </div>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenuDropdown">
                                      <li class="px-3 py-2 border-bottom text-muted small">
                                          Signed in as <br>
                                          <strong class="text-dark"><?= $_SESSION['currentuser']['username'] ?></strong>
                                      </li>
                                      <li>
                                          <a class="dropdown-item py-2" href="<?= BASE_URL ?>profile.php">
                                              <i class="bi bi-person me-2 text-primary"></i> My Profile
                                          </a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item py-2" href="<?= BASE_URL ?>user-create.php">
                                              <i class="bi bi-person-plus me-2 text-success"></i> Add New User
                                          </a>
                                      </li>
                                      <li>
                                          <hr class="dropdown-divider my-1">
                                      </li>
                                      <li>
                                          <a class="dropdown-item py-2 text-danger" href="<?= BASE_URL ?>logout.php">
                                              <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                          </a>
                                      </li>
                                  </ul>
                              </li>




                          </ul>
                      </div>
                  </div>
              </nav>
          </div>
      </noscript>

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

                          <!-- <noscript> -->
                              <!-- <li class="nav-item dropdown">
                                  <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-1" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      <div class="d-flex flex-column text-start">
                                          <span class="fw-semibold lh-1 small"><?= $_SESSION['currentuser']['username'] ?></span>
                                      </div>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenuDropdown">
                                      <li class="px-3 py-2 border-bottom text-muted small">
                                          Signed in as <br>
                                          <strong class="text-dark"><?= $_SESSION['currentuser']['username'] ?></strong>
                                      </li>
                                      <li>
                                          <a class="dropdown-item py-2" href="<?= BASE_URL ?>profile.php">
                                              <i class="bi bi-person me-2 text-primary"></i> My Profile
                                          </a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item py-2" href="<?= BASE_URL ?>user-create.php">
                                              <i class="bi bi-person-plus me-2 text-success"></i> Add New User
                                          </a>
                                      </li>
                                      <li>
                                          <hr class="dropdown-divider my-1">
                                      </li>
                                      <li>
                                          <a class="dropdown-item py-2 text-danger" href="<?= BASE_URL ?>logout.php">
                                              <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                          </a>
                                      </li>
                                  </ul>
                              </li> -->
                          <!-- </noscript> -->

                          <!-- <details class="dropdown">
                              <summary class="nav-link dropdown-toggle">
                                  <?= htmlspecialchars($_SESSION['currentuser']['username'] ?? 'User') ?>
                              </summary>
                              <ul class="dropdown-menu show position-static">
                                  <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile.php">My Profile</a></li>
                                  <li><a class="dropdown-item" href="<?= BASE_URL ?>/user-create.php">Add User</a></li>
                                  <li><a class="dropdown-item text-danger" href="logout.php">Sign Out</a></li>
                              </ul>
                          </details> -->




                      </ul>
                  </div>
              </div>
          </nav>
      </div>


      <!-- Top Navigation Bar -->
      <noscript>
          <div class="container mt-3" id="top">
              <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
                  <div class="container">
                      <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
                          <i class="bi bi-people-fill text-primary fs-4"></i>
                          <!-- <span><?= APP_NAME ?></span> -->
                      </a>

                      <button class="navbar-toggler" type="button" data-bs-auto-close="true" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                      </button>

                      <div class="collapse navbar-collapse" id="navbarMain">
                          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              <li class="nav-item">
                                  <a class="nav-link <?= is_active_page('index.php') ?>" href="../dashboard.php">
                                      <i class="bi bi-database me-1"></i> Ranjith's Personal
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link <?= is_active_page('index.php') ?>" href="<?= BASE_URL ?>index.php">
                                      <i class="bi bi-house-door me-1"></i> Home
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link <?= is_active_page('users.php') ?>" href="<?= BASE_URL ?>users.php">
                                      <i class="bi bi-person-lines-fill me-1"></i> Users Directory
                                  </a>
                              </li>
                              <?php if ($_SESSION['currentuser']): ?>
                                  <li class="nav-item">
                                      <a class="nav-link <?= is_active_page('user-create.php') ?>" href="<?= BASE_URL ?>user-create.php">
                                          <i class="bi bi-person-plus me-1"></i> Add User
                                      </a>
                                  </li>
                              <?php endif; ?>
                          </ul>

                          <ul class="navbar-nav ms-auto align-items-lg-center">
                              <?php if ($_SESSION['currentuser'] && $_SESSION['loggedIn']): ?>
                                  <li class="nav-item dropdown">
                                      <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-1" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                          <div class="d-flex flex-column text-start">
                                              <span class="fw-semibold lh-1 small"><?= $_SESSION['currentuser']['username'] ?></span>
                                          </div>
                                      </a>
                                      <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenuDropdown">
                                          <li class="px-3 py-2 border-bottom text-muted small">
                                              Signed in as <br>
                                              <strong class="text-dark"><?= $_SESSION['currentuser']['username'] ?></strong>
                                          </li>
                                          <li>
                                              <a class="dropdown-item py-2" href="<?= BASE_URL ?>profile.php">
                                                  <i class="bi bi-person me-2 text-primary"></i> My Profile
                                              </a>
                                          </li>
                                          <li>
                                              <a class="dropdown-item py-2" href="<?= BASE_URL ?>user-create.php">
                                                  <i class="bi bi-person-plus me-2 text-success"></i> Add New User
                                              </a>
                                          </li>
                                          <li>
                                              <hr class="dropdown-divider my-1">
                                          </li>
                                          <li>
                                              <a class="dropdown-item py-2 text-danger" href="<?= BASE_URL ?>logout.php">
                                                  <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                              </a>
                                          </li>
                                      </ul>
                                  </li>
                              <?php else: ?>
                                  <li class="nav-item">
                                      <a class="nav-link <?= is_active_page('login.php') ?>" href="<?= BASE_URL ?>login.php">
                                          <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                                      </a>
                                  </li>
                                  <li class="nav-item ms-lg-2">
                                      <a class="btn btn-primary btn-sm px-3" href="<?= BASE_URL ?>register.php">
                                          <i class="bi bi-person-plus me-1"></i> Register
                                      </a>
                                  </li>
                              <?php endif; ?>
                          </ul>
                      </div>
                  </div>
              </nav>
          </div>
      </noscript>


      <br><br>