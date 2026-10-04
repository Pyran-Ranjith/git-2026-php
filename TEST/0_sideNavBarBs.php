<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-3 col-lg-2 bg-dark text-white min-vh-100 p-3">
            <h4 class="text-center mb-4">My App</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white active bg-primary rounded" href="?page=dashboard">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="?page=users">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="?page=products">
                        <i class="fas fa-box"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="?page=orders">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="?page=settings">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9 col-lg-10 p-4">
            <?php
            $page = $_GET['page'] ?? 'dashboard';

            switch ($page) {
                case 'dashboard':
                    echo '<h2>Dashboard</h2><p>Welcome to the dashboard.</p>';
                    break;
                case 'users':
                    echo '<h2>Users</h2><p>Manage users here.</p>';
                    break;
                case 'products':
                    echo '<h2>Products</h2><p>Manage products here.</p>';
                    break;
                case 'orders':
                    echo '<h2>Orders</h2><p>Manage orders here.</p>';
                    break;
                case 'settings':
                    echo '<h2>Settings</h2><p>Manage settings here.</p>';
                    break;
                default:
                    echo '<h2>404</h2><p>Page not found.</p>';
                    break;
            }
            ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>