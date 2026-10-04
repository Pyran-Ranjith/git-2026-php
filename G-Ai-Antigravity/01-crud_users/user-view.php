<?php
/**
 * View Single User Details - CRUD Read Detail
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

$userId = (int)($_GET['id'] ?? 0);
if ($userId <= 0) {
    set_flash('danger', 'Invalid user ID specified.');
    redirect('users.php');
}

$user = null;
try {
    $db = get_db();
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
} catch (Exception $e) {
    set_flash('danger', 'Database error: ' . $e->getMessage());
    redirect('users.php');
}

if (!$user) {
    set_flash('danger', 'The requested user was not found.');
    redirect('users.php');
}

$pageTitle = $user['first_name'] . ' ' . $user['last_name'] . ' - Profile';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Top Navigation / Breadcrumb -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="<?= BASE_URL ?>users.php" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left me-1"></i> Back to Users Directory
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">User Profile Details</h3>
            </div>
            <div class="d-flex gap-2">
                <?php if (is_logged_in()): ?>
                    <a href="<?= BASE_URL ?>user-edit.php?id=<?= $user['id'] ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i> Edit Profile
                    </a>
                    <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$user['id']): ?>
                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteUserModal">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main Profile Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-4 pb-4 border-bottom">
                    <img src="<?= get_user_avatar($user['avatar'], $user['first_name'], $user['last_name']) ?>" 
                         alt="<?= e($user['first_name']) ?>" 
                         class="avatar-img avatar-xl shadow-sm">
                    <div class="text-center text-md-start flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start gap-2 mb-2">
                            <h3 class="fw-bold mb-0 text-dark"><?= e($user['first_name'] . ' ' . $user['last_name']) ?></h3>
                            <span class="badge-role-<?= e($user['role']) ?>"><?= ucfirst($user['role']) ?></span>
                            <span class="badge-status-<?= e($user['status']) ?>"><?= ucfirst($user['status']) ?></span>
                        </div>
                        <p class="text-muted mb-2">
                            <i class="bi bi-envelope me-1"></i> <a href="mailto:<?= e($user['email']) ?>" class="text-decoration-none text-muted"><?= e($user['email']) ?></a>
                        </p>
                        <?php if (!empty($user['bio'])): ?>
                            <p class="text-secondary small mb-0 mt-2 bg-light p-3 rounded">
                                <?= nl2br(e($user['bio'])) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row g-4 pt-4">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.72rem;">User ID</small>
                            <span class="fw-bold text-dark fs-6">#<?= e($user['id']) ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.72rem;">Phone Number</small>
                            <span class="fw-bold text-dark fs-6"><?= e($user['phone']) ?: 'Not Provided' ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.72rem;">Gender</small>
                            <span class="fw-bold text-dark fs-6"><?= ucfirst($user['gender'] ?? 'Other') ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.72rem;">Member Since</small>
                            <span class="fw-bold text-dark fs-6"><?= format_date($user['created_at']) ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.72rem;">Last Updated</small>
                            <span class="fw-bold text-dark fs-6"><?= format_date($user['updated_at']) ?></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.72rem;">Account Status</small>
                            <span class="fw-bold <?= $user['status'] === 'active' ? 'text-success' : 'text-danger' ?> fs-6">
                                <i class="bi <?= $user['status'] === 'active' ? 'bi-check-circle-fill' : 'bi-x-circle-fill' ?> me-1"></i>
                                <?= ucfirst($user['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<?php if (is_logged_in() && isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$user['id']): ?>
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="deleteUserModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm User Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <p class="mb-1">Are you sure you want to delete user <strong><?= e($user['first_name'] . ' ' . $user['last_name']) ?></strong>?</p>
                <p class="small text-muted mb-0">This operation cannot be undone and will delete all user data.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="<?= BASE_URL ?>user-delete.php" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm px-3 fw-semibold">
                        <i class="bi bi-trash-fill me-1"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
