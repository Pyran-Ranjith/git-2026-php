<?php
/**
 * UserHub - Homepage / Dashboard
 */
$pageTitle = 'Home';
require_once __DIR__ . '/includes/header.php';

// Fetch quick statistics
$stats = [
    'total'    => 0,
    'active'   => 0,
    'inactive' => 0,
    'admins'   => 0,
];

$recentUsers = [];

try {
    $db = get_db();
    
    // Overall stats
    $stats['total'] = (int)$db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $stats['active'] = (int)$db->query("SELECT COUNT(*) FROM users WHERE status = 'active'")->fetchColumn();
    $stats['inactive'] = (int)$db->query("SELECT COUNT(*) FROM users WHERE status = 'inactive'")->fetchColumn();
    $stats['admins'] = (int)$db->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();

    // Recent 5 users
    $stmt = $db->query("SELECT id, first_name, last_name, email, role, status, avatar, created_at FROM users ORDER BY id DESC LIMIT 5");
    $recentUsers = $stmt->fetchAll();
} catch (Exception $e) {
    // In case DB is not yet set up
}
?>

<!-- Hero Banner -->
<div class="hero-section shadow-sm mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <span class="badge bg-white text-primary mb-2 px-3 py-2 fw-semibold">
                <i class="bi bi-shield-lock-fill me-1"></i> PHP 8.2 &bull; MySQL &bull; Bootstrap 5
            </span>
            <h1 class="display-5 fw-bold mb-3">User Management & Authentication System</h1>
            <p class="lead mb-4 opacity-90">
                A clean, secure multi-page web application featuring full CRUD capabilities, persistent authentication with Sessions & Cookies, role management, and responsive UI design.
            </p>
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= BASE_URL ?>users.php" class="btn btn-light text-primary fw-semibold px-4 py-2">
                    <i class="bi bi-people-fill me-2"></i> Browse Users
                </a>
                <?php if (is_logged_in()): ?>
                    <a href="<?= BASE_URL ?>user-create.php" class="btn btn-outline-light px-4 py-2">
                        <i class="bi bi-person-plus-fill me-2"></i> Add New User
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>login.php" class="btn btn-outline-light px-4 py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </a>
                    <a href="<?= BASE_URL ?>register.php" class="btn btn-warning text-dark fw-semibold px-4 py-2">
                        <i class="bi bi-person-plus me-2"></i> Create Account
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-block text-center">
            <i class="bi bi-person-gear text-white-50" style="font-size: 9rem;"></i>
        </div>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-muted fw-normal mb-1 small text-uppercase">Total Users</h6>
                    <h3 class="fw-bold mb-0 text-dark"><?= $stats['total'] ?></h3>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                    <i class="bi bi-people fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-success border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-muted fw-normal mb-1 small text-uppercase">Active Users</h6>
                    <h3 class="fw-bold mb-0 text-success"><?= $stats['active'] ?></h3>
                </div>
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                    <i class="bi bi-check-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-warning border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-muted fw-normal mb-1 small text-uppercase">Inactive Users</h6>
                    <h3 class="fw-bold mb-0 text-warning"><?= $stats['inactive'] ?></h3>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
                    <i class="bi bi-pause-circle fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card stat-info border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-muted fw-normal mb-1 small text-uppercase">Administrators</h6>
                    <h3 class="fw-bold mb-0 text-info"><?= $stats['admins'] ?></h3>
                </div>
                <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Users Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="bi bi-clock-history me-2 text-primary"></i> Recently Added Users
                </h5>
                <a href="<?= BASE_URL ?>users.php" class="btn btn-sm btn-outline-primary">
                    View All <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentUsers)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted display-4"></i>
                        <p class="text-muted mt-2">No users found in database.</p>
                        <a href="<?= BASE_URL ?>setup.php" class="btn btn-sm btn-primary">Run Database Setup</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentUsers as $user): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="<?= get_user_avatar($user['avatar'], $user['first_name'], $user['last_name']) ?>" 
                                                     alt="<?= e($user['first_name']) ?>" 
                                                     class="avatar-img avatar-sm">
                                                <div>
                                                    <div class="fw-semibold text-dark">
                                                        <?= e($user['first_name'] . ' ' . $user['last_name']) ?>
                                                    </div>
                                                    <small class="text-muted"><?= e($user['email']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-role-<?= e($user['role']) ?>">
                                                <?= ucfirst($user['role']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge-status-<?= e($user['status']) ?>">
                                                <?= ucfirst($user['status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            <?= time_ago($user['created_at']) ?>
                                        </td>
                                        <td class="text-end">
                                            <a href="<?= BASE_URL ?>user-view.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-light text-primary" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if (is_logged_in()): ?>
                                                <a href="<?= BASE_URL ?>user-edit.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-light text-secondary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Features & Info -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-bold text-dark">
                    <i class="bi bi-stars me-2 text-warning"></i> Key Features
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 py-2 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        <span><strong>Full CRUD Operations</strong> (Create, Read, Update, Delete)</span>
                    </li>
                    <li class="list-group-item px-0 py-2 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        <span><strong>Session & Cookie Auth</strong> with Remember Me feature</span>
                    </li>
                    <li class="list-group-item px-0 py-2 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        <span><strong>CSRF Protection & Sanitization</strong> built-in</span>
                    </li>
                    <li class="list-group-item px-0 py-2 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        <span><strong>Modular Architecture</strong> with header and footer templates</span>
                    </li>
                    <li class="list-group-item px-0 py-2 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                        <span><strong>Bootstrap 5 UI</strong> responsive and modern design</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card bg-light border-0 shadow-sm">
            <div class="card-body p-3">
                <h6 class="fw-bold mb-2"><i class="bi bi-info-circle text-primary me-2"></i>Quick Access Demo</h6>
                <p class="small text-muted mb-2">You can quickly sign in using the pre-seeded admin account:</p>
                <div class="bg-white p-2 rounded border small">
                    <div><strong>Email:</strong> <code>admin@example.com</code></div>
                    <div><strong>Password:</strong> <code>admin123</code></div>
                </div>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>setup.php" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> Database Setup & Reset Tool
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
