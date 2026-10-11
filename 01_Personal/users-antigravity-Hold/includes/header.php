<?php
/**
 * Common Application Header
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/flash.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/csrf.php';

$loggedIn = is_logged_in();
$currentUser = $loggedIn ? current_user() : null;
$pageTitle = isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME . ' - ' . APP_TAGLINE;
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Application CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="d-flex flex-column h-100">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
                <i class="bi bi-people-fill text-primary fs-4"></i>
                <span><?= APP_NAME ?></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-auto-close="true" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <?php if ($loggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= is_active_page('user-create.php') ?>" href="<?= BASE_URL ?>user-create.php">
                                <i class="bi bi-person-plus me-1"></i> Add User
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <?php if ($loggedIn && $currentUser): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-1" href="#" id="userMenuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?= get_user_avatar($currentUser['avatar'], $currentUser['first_name'], $currentUser['last_name']) ?>" 
                                     alt="<?= e($currentUser['first_name']) ?>" 
                                     class="avatar-img avatar-sm">
                                <div class="d-flex flex-column text-start">
                                    <span class="fw-semibold lh-1 small"><?= e($currentUser['first_name'] . ' ' . $currentUser['last_name']) ?></span>
                                    <span class="text-muted" style="font-size: 0.72rem;"><?= ucfirst($currentUser['role']) ?></span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenuDropdown">
                                <li class="px-3 py-2 border-bottom text-muted small">
                                    Signed in as <br>
                                    <strong class="text-dark"><?= e($currentUser['email']) ?></strong>
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
                                <li><hr class="dropdown-divider my-1"></li>
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

    <!-- Main Content Wrapper -->
    <main class="py-4">
        <div class="container">
            <?php render_flash(); ?>
