<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Navbar with Submenu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php 
$page = $_GET['page'] ?? 'dashboard';
$subpage = $_GET['subpage'] ?? '';
?>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-3">
            <h4 class="text-center mb-4">
                <i class="fas fa-database"></i> My App
            </h4>
            <hr class="text-white">
            <ul class="nav flex-column">

                <!-- Dashboard -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white <?= $page == 'dashboard' ? 'active bg-primary rounded' : '' ?>" 
                       href="?page=dashboard">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>

                <!-- Users with Submenu -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $page == 'users' ? 'active bg-primary rounded' : '' ?>" 
                       data-bs-toggle="collapse" href="#usersMenu" role="button">
                        <span><i class="fas fa-users me-2"></i> Users</span>
                        <i class="fas fa-chevron-down small"></i>
                    </a>
                    <div class="collapse <?= $page == 'users' ? 'show' : '' ?>" id="usersMenu">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'list' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=users&subpage=list">
                                    <i class="fas fa-list me-2"></i> View All
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'add' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=users&subpage=add">
                                    <i class="fas fa-plus me-2"></i> Add New
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'archived' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=users&subpage=archived">
                                    <i class="fas fa-archive me-2"></i> Archived
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Products with Submenu -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $page == 'products' ? 'active bg-primary rounded' : '' ?>" 
                       data-bs-toggle="collapse" href="#productsMenu" role="button">
                        <span><i class="fas fa-box me-2"></i> Products</span>
                        <i class="fas fa-chevron-down small"></i>
                    </a>
                    <div class="collapse <?= $page == 'products' ? 'show' : '' ?>" id="productsMenu">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'list' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=products&subpage=list">
                                    <i class="fas fa-list me-2"></i> All Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'add' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=products&subpage=add">
                                    <i class="fas fa-plus me-2"></i> Add Product
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'categories' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=products&subpage=categories">
                                    <i class="fas fa-tags me-2"></i> Categories
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Orders with Submenu -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white d-flex justify-content-between align-items-center <?= $page == 'orders' ? 'active bg-primary rounded' : '' ?>" 
                       data-bs-toggle="collapse" href="#ordersMenu" role="button">
                        <span><i class="fas fa-shopping-cart me-2"></i> Orders</span>
                        <i class="fas fa-chevron-down small"></i>
                    </a>
                    <div class="collapse <?= $page == 'orders' ? 'show' : '' ?>" id="ordersMenu">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'pending' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=orders&subpage=pending">
                                    <i class="fas fa-clock me-2"></i> Pending
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'completed' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=orders&subpage=completed">
                                    <i class="fas fa-check me-2"></i> Completed
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-1 <?= $subpage == 'cancelled' ? 'text-warning fw-bold' : '' ?>" 
                                   href="?page=orders&subpage=cancelled">
                                    <i class="fas fa-times me-2"></i> Cancelled
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Settings (no submenu) -->
                <li class="nav-item mb-1">
                    <a class="nav-link text-white <?= $page == 'settings' ? 'active bg-primary rounded' : '' ?>" 
                       href="?page=settings">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item mt-4">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </li>

            </ul>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card">
                <div class="card-body">
                    <?php
                    switch ($page) {
                        case 'dashboard':
                            echo '<h2><i class="fas fa-home"></i> Dashboard</h2>';
                            echo '<p>Welcome to the dashboard.</p>';
                            break;

                        case 'users':
                            echo '<h2><i class="fas fa-users"></i> Users</h2>';
                            if ($subpage == 'list') {
                                echo '<p>Showing all users.</p>';
                            } elseif ($subpage == 'add') {
                                echo '<p>Add a new user.</p>';
                            } elseif ($subpage == 'archived') {
                                echo '<p>Archived users.</p>';
                            } else {
                                echo '<p>Select an option from the submenu.</p>';
                            }
                            break;

                        case 'products':
                            echo '<h2><i class="fas fa-box"></i> Products</h2>';
                            if ($subpage == 'list') {
                                echo '<p>All products.</p>';
                            } elseif ($subpage == 'add') {
                                echo '<p>Add a new product.</p>';
                            } elseif ($subpage == 'categories') {
                                echo '<p>Product categories.</p>';
                            } else {
                                echo '<p>Select an option from the submenu.</p>';
                            }
                            break;

                        case 'orders':
                            echo '<h2><i class="fas fa-shopping-cart"></i> Orders</h2>';
                            if ($subpage == 'pending') {
                                echo '<p>Pending orders.</p>';
                            } elseif ($subpage == 'completed') {
                                echo '<p>Completed orders.</p>';
                            } elseif ($subpage == 'cancelled') {
                                echo '<p>Cancelled orders.</p>';
                            } else {
                                echo '<p>Select an option from the submenu.</p>';
                            }
                            break;

                        case 'settings':
                            echo '<h2><i class="fas fa-cog"></i> Settings</h2>';
                            echo '<p>Manage settings here.</p>';
                            break;

                        default:
                            echo '<h2>404</h2><p>Page not found.</p>';
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>