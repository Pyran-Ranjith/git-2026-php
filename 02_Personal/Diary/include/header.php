<?php
$current_file = basename($_SERVER['SCRIPT_NAME']);
// echo "<br><br><br>";
// echo "Current file:  " . $current_file . "";
// echo "<br>";

if ($current_file === 'dashboard.php') {
  $data_page = "dashboard";
} elseif ($current_file === 'products.php') {
  $data_page = "products";
} elseif ($current_file === 'edit-product.php') {
  $data_page = "edit-product";
} elseif ($current_file === 'view-product.php') {
  $data_page = "view-product";
} else {
  $data_page = "";
}
?>
<!DOCTYPE html>
<!-- <html lang="en"> -->
<html lang="en" data-bs-theme="light">

<!-- </html> -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if ($current_file === 'products.php') { ?>
    <title>Fragrance Catalog & Inventory | K-gi Perfume</title>
  <?php } elseif ($current_file === 'dashboard.php') { ?>
    <title>Dashboard | Diary</title>
  <?php } elseif ($current_file === 'add-product.php') { ?>
    <title>Add New Fragrance | K-gi Perfume CRUD</title>
  <?php } elseif ($current_file === 'edit-product.php') { ?>
    <title>Edit Fragrance Profile | K-gi Perfume CRUD</title>
  <?php } elseif ($current_file === 'view-product.php') { ?>
    <title>Fragrance Details & Olfactory Notes | K-gi Perfume</title>
  <?php } ?>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Custom Luxury Theme Stylesheet -->
  <link rel="stylesheet" href="css/style.css">
  <!-- ICO favicon (fallback) -->
  <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"> -->
  <!-- Favicon -->
  <link rel="shortcut icon" href="images/Ranjith_personal-1.png" type="">
</head>

<body data-page="<?php echo $data_page; ?>">

  <!-- Navbar -->
  <!-- <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3"> -->
  <nav class="navbar navbar-expand-lg navbar-green navbar-custom py-3">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">
        <!-- <i class="bi bi-database"></i> -->
        <img src="images/Ranjith_personal-1.png" alt="Ranjith's Personal Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
        <span>Diary</span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
              <i class="bi bi-database me-1"></i> Ranjith's Personal
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">
              <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="products.php">
              <i class="bi bi-collection-fill me-1"></i> Fragrance Catalog
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add-product.php">
              <i class="bi bi-plus-circle-fill me-1"></i> Add Fragrance
            </a>
          </li> -->
        </ul>
        <!-- <div class="d-flex align-items-center gap-2">
          <a href="products.php" class="btn btn-outline-gold btn-sm px-3">
            <i class="bi bi-table me-1"></i> Manage Catalog
          </a>
          <a href="add-product.php" class="btn btn-gold btn-sm px-3">
            <i class="bi bi-plus-lg me-1"></i> New Fragrance
          </a>
        </div> -->
      </div>
    </div>
  </nav>