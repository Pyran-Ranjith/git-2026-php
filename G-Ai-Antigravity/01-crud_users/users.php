<?php
/**
 * Users Directory - CRUD Read & List
 */
$pageTitle = 'Users Directory';
require_once __DIR__ . '/includes/header.php';

// Search and filter parameters
$search = sanitize($_GET['search'] ?? '');
$role = sanitize($_GET['role'] ?? '');
$status = sanitize($_GET['status'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 6;
$offset = ($page - 1) * $perPage;

$whereClauses = [];
$params = [];

if ($search !== '') {
    $whereClauses[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $searchWildcard = "%{$search}%";
    $params[] = $searchWildcard;
    $params[] = $searchWildcard;
    $params[] = $searchWildcard;
    $params[] = $searchWildcard;
}

if ($role !== '' && in_array($role, ['admin', 'user'])) {
    $whereClauses[] = "role = ?";
    $params[] = $role;
}

if ($status !== '' && in_array($status, ['active', 'inactive'])) {
    $whereClauses[] = "status = ?";
    $params[] = $status;
}

$whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

$users = [];
$totalUsers = 0;
$totalPages = 1;

try {
    $db = get_db();

    // Count total matching records for pagination
    $countStmt = $db->prepare("SELECT COUNT(*) FROM users {$whereSql}");
    $countStmt->execute($params);
    $totalUsers = (int)$countStmt->fetchColumn();
    $totalPages = max(1, ceil($totalUsers / $perPage));

    // Fetch paginated records
    $query = "SELECT id, first_name, last_name, email, role, phone, gender, avatar, status, created_at 
              FROM users {$whereSql} 
              ORDER BY id DESC 
              LIMIT {$perPage} OFFSET {$offset}";
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    set_flash('danger', 'Database query error: ' . $e->getMessage());
}

// Build query string helper for pagination links
function pagination_url(int $targetPage, array $params = []): string {
    $query = array_merge($_GET, ['page' => $targetPage]);
    return '?' . http_build_query($query);
}
?>

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-people-fill text-primary me-2"></i> Users Directory
        </h2>
        <p class="text-muted small mb-0">Browse, filter, search, and manage registered system accounts</p>
    </div>
    <div class="d-flex gap-2">
        <?php if (is_logged_in()): ?>
            <a href="<?= BASE_URL ?>user-create.php" class="btn btn-primary d-flex align-items-center">
                <i class="bi bi-person-plus-fill me-2"></i> Add New User
            </a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>login.php" class="btn btn-outline-primary">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Manage
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Search & Filters Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <form method="GET" action="" class="row g-2 align-items-center">
            <div class="col-md-5 col-lg-6">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Search by name, email, or phone..." 
                           value="<?= e($search) ?>">
                </div>
            </div>

            <div class="col-sm-6 col-md-3 col-lg-2">
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>Standard User</option>
                </select>
            </div>

            <div class="col-sm-6 col-md-2 col-lg-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="col-md-2 col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                <?php if ($search !== '' || $role !== '' || $status !== ''): ?>
                    <a href="<?= BASE_URL ?>users.php" class="btn btn-outline-secondary" title="Reset Filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Users Table Card -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($users)): ?>
            <div class="text-center py-5">
                <div class="text-muted mb-3">
                    <i class="bi bi-search text-secondary display-5"></i>
                </div>
                <h5 class="fw-bold text-dark">No Users Found</h5>
                <p class="text-muted small mb-3">Try adjusting your search criteria or clearing active filters.</p>
                <a href="<?= BASE_URL ?>users.php" class="btn btn-sm btn-outline-primary">Reset Filters</a>
                <?php if (is_logged_in()): ?>
                    <a href="<?= BASE_URL ?>user-create.php" class="btn btn-sm btn-primary ms-2">
                        <i class="bi bi-person-plus me-1"></i> Add First User
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">#ID</th>
                            <th>User Profile</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-end" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td class="text-muted fw-semibold">#<?= $u['id'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= get_user_avatar($u['avatar'], $u['first_name'], $u['last_name']) ?>" 
                                             alt="<?= e($u['first_name']) ?>" 
                                             class="avatar-img avatar-md">
                                        <div>
                                            <a href="<?= BASE_URL ?>user-view.php?id=<?= $u['id'] ?>" class="fw-bold text-dark text-decoration-none">
                                                <?= e($u['first_name'] . ' ' . $u['last_name']) ?>
                                            </a>
                                            <div class="text-muted small"><?= e($u['email']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small text-muted">
                                    <?= e($u['phone']) ?: '<span class="text-black-50">—</span>' ?>
                                </td>
                                <td>
                                    <span class="badge-role-<?= e($u['role']) ?>">
                                        <?= ucfirst($u['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge-status-<?= e($u['status']) ?>">
                                        <?= ucfirst($u['status']) ?>
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <?= format_date($u['created_at'], 'M d, Y') ?>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= BASE_URL ?>user-view.php?id=<?= $u['id'] ?>" class="btn btn-outline-secondary" title="View details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if (is_logged_in()): ?>
                                            <a href="<?= BASE_URL ?>user-edit.php?id=<?= $u['id'] ?>" class="btn btn-outline-primary" title="Edit user">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <?php if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] !== (int)$u['id']): ?>
                                                <button type="button" class="btn btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteUserModal"
                                                        data-user-id="<?= $u['id'] ?>"
                                                        data-user-name="<?= e($u['first_name'] . ' ' . $u['last_name']) ?>"
                                                        title="Delete user">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-top gap-2">
                <div class="small text-muted">
                    Showing <strong><?= min($totalUsers, $offset + 1) ?></strong> to 
                    <strong><?= min($totalUsers, $offset + count($users)) ?></strong> of 
                    <strong><?= $totalUsers ?></strong> users
                </div>

                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Users pagination">
                        <ul class="pagination pagination-sm mb-0">
                            <!-- Prev -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= pagination_url($page - 1) ?>">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($page === $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= pagination_url($i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next -->
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= pagination_url($page + 1) ?>">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
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
                <p class="mb-1">Are you sure you want to delete <strong id="deleteUserName">this user</strong>?</p>
                <p class="small text-muted mb-0">This action will permanently delete the user account and associated session tokens. This cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="<?= BASE_URL ?>user-delete.php" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" id="deleteUserId" value="">
                    <button type="submit" class="btn btn-danger btn-sm px-3 fw-semibold">
                        <i class="bi bi-trash-fill me-1"></i> Yes, Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
