<?php
/**
 * One-Click Database Setup & Reset Tool
 */
require_once __DIR__ . '/config/config.php';

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install_db'])) {
    try {
        $rootDsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
        $pdo = new PDO($rootDsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $sqlFile = __DIR__ . '/database.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("database.sql file not found!");
        }

        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);

        $status = 'success';
        $message = 'Database and tables created and seeded successfully!';
    } catch (Exception $e) {
        $status = 'danger';
        $message = 'Setup Error: ' . $e->getMessage();
    }
}

$pageTitle = 'Database Setup';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white border-0 text-center pt-4">
                <i class="bi bi-database-check text-primary display-4"></i>
                <h3 class="fw-bold mt-2">Database Setup & Installer</h3>
                <p class="text-muted small">Configure or re-initialize MySQL database <code><?= DB_NAME ?></code></p>
            </div>
            <div class="card-body p-4">
                <?php if ($message): ?>
                    <div class="alert alert-<?= $status ?> alert-dismissible fade show" role="alert">
                        <i class="bi <?= $status === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?> me-2"></i>
                        <?= htmlspecialchars($message) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="bg-light p-3 rounded-3 mb-4">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-gear-fill me-2 text-secondary"></i>Current Configuration</h6>
                    <ul class="list-unstyled mb-0 small text-muted">
                        <li><strong>Host:</strong> <?= DB_HOST ?>:<?= DB_PORT ?></li>
                        <li><strong>Database:</strong> <?= DB_NAME ?></li>
                        <li><strong>User:</strong> <?= DB_USER ?></li>
                    </ul>
                </div>

                <div class="alert alert-info small mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Running this installer creates the <code>users</code> and <code>user_tokens</code> tables and seeds sample admin and test users.
                </div>

                <form method="POST" class="d-grid mb-4">
                    <button type="submit" name="install_db" value="1" class="btn btn-primary py-2 fw-semibold">
                        <i class="bi bi-play-circle-fill me-2"></i> Run Setup / Re-seed Database
                    </button>
                </form>

                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h6 class="fw-bold mb-2"><i class="bi bi-key-fill text-warning me-2"></i>Default Credentials</h6>
                        <table class="table table-sm table-borderless mb-0 small">
                            <tbody>
                                <tr>
                                    <td><strong>Admin:</strong></td>
                                    <td><code>admin@example.com</code></td>
                                    <td>Pass: <code>admin123</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Standard User:</strong></td>
                                    <td><code>john@example.com</code></td>
                                    <td>Pass: <code>password123</code></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>login.php" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Go to Sign In
                    </a>
                    <a href="<?= BASE_URL ?>users.php" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-people me-1"></i> View Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
