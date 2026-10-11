<?php
/**
 * Edit User - CRUD Update
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

require_login();

$userId = (int)($_GET['id'] ?? 0);
if ($userId <= 0) {
    set_flash('danger', 'Invalid user ID.');
    redirect('users.php');
}

// Check permission: Only Admin or the User themselves can edit
if (!is_admin() && (int)$_SESSION['user_id'] !== $userId) {
    set_flash('danger', 'You do not have permission to edit this user account.');
    redirect('users.php');
}

$db = get_db();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    set_flash('danger', 'User not found.');
    redirect('users.php');
}

$firstName = $user['first_name'];
$lastName  = $user['last_name'];
$email     = $user['email'];
$phone     = $user['phone'] ?? '';
$gender    = $user['gender'] ?? 'other';
$role      = $user['role'];
$status    = $user['status'];
$bio       = $user['bio'] ?? '';
$avatar    = $user['avatar'];
$errors    = [];

if (is_post()) {
    $firstName   = sanitize($_POST['first_name'] ?? '');
    $lastName    = sanitize($_POST['last_name'] ?? '');
    $email       = sanitize($_POST['email'] ?? '');
    $phone       = sanitize($_POST['phone'] ?? '');
    $gender      = sanitize($_POST['gender'] ?? 'other');
    $bio         = sanitize($_POST['bio'] ?? '');
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';
    $csrfToken   = $_POST['csrf_token'] ?? '';

    // Only admin can update role and status
    if (is_admin()) {
        $role = sanitize($_POST['role'] ?? $user['role']);
        $status = sanitize($_POST['status'] ?? $user['status']);
    }

    // Validate CSRF
    if (!verify_csrf_token($csrfToken)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    if (empty($firstName)) {
        $errors[] = 'First name is required.';
    }

    if (empty($lastName)) {
        $errors[] = 'Last name is required.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    if (!empty($newPassword)) {
        if (strlen($newPassword) < 6) {
            $errors[] = 'New password must be at least 6 characters.';
        }
        if ($newPassword !== $confirmPass) {
            $errors[] = 'New passwords do not match.';
        }
    }

    // Check duplicate email (if changed)
    if ($email !== $user['email']) {
        $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1");
        $checkStmt->execute([$email, $userId]);
        if ($checkStmt->fetch()) {
            $errors[] = 'This email address is already in use by another account.';
        }
    }

    // Handle avatar upload
    $newAvatarFilename = $avatar;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['avatar'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Avatar upload error code: ' . $file['error'];
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $file['tmp_name']);
            finfo_close($fileInfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = 'Invalid avatar format. Allowed: JPG, PNG, WEBP, GIF.';
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $errors[] = 'Avatar file size must be less than 2MB.';
            } else {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $newAvatarFilename = 'avatar_' . uniqid() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);

                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }

                if (move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $newAvatarFilename)) {
                    // Remove previous avatar file from disk if exists
                    if (!empty($avatar) && file_exists(UPLOAD_DIR . $avatar)) {
                        @unlink(UPLOAD_DIR . $avatar);
                    }
                } else {
                    $errors[] = 'Failed to save uploaded avatar.';
                    $newAvatarFilename = $avatar;
                }
            }
        }
    }

    if (empty($errors)) {
        try {
            $updateSql = "UPDATE users SET 
                            first_name = ?, 
                            last_name = ?, 
                            email = ?, 
                            phone = ?, 
                            gender = ?, 
                            bio = ?, 
                            role = ?, 
                            status = ?, 
                            avatar = ?, 
                            updated_at = NOW()";
            $updateParams = [
                $firstName,
                $lastName,
                $email,
                $phone ?: null,
                $gender,
                $bio ?: null,
                $role,
                $status,
                $newAvatarFilename
            ];

            // If updating password
            if (!empty($newPassword)) {
                $updateSql .= ", password = ?";
                $updateParams[] = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            $updateSql .= " WHERE id = ?";
            $updateParams[] = $userId;

            $updateStmt = $db->prepare($updateSql);
            $updateStmt->execute($updateParams);

            // Update session cache if editing own profile
            if ((int)$_SESSION['user_id'] === $userId) {
                $_SESSION['user_name'] = $firstName . ' ' . $lastName;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $role;
            }

            set_flash('success', 'User account updated successfully!');
            redirect("user-view.php?id={$userId}");
        } catch (Exception $e) {
            $errors[] = 'Update failed: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Edit User - ' . $user['first_name'];
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-9 col-xl-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="<?= BASE_URL ?>user-view.php?id=<?= $user['id'] ?>" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left me-1"></i> Back to Profile
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">Edit User Account</h3>
            </div>
            <a href="<?= BASE_URL ?>users.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-people me-1"></i> Directory
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong class="d-block mb-1">Please correct the following:</strong>
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <!-- Avatar Preview & Upload -->
                    <div class="d-flex flex-column flex-sm-row align-items-center gap-4 mb-4 pb-3 border-bottom">
                        <img id="avatarPreview" 
                             src="<?= get_user_avatar($avatar, $firstName, $lastName) ?>" 
                             alt="Avatar Preview" 
                             class="avatar-img avatar-xl border">
                        <div>
                            <label for="avatarInput" class="form-label fw-bold text-dark mb-1">Change Profile Photo</label>
                            <input class="form-control form-control-sm" type="file" id="avatarInput" name="avatar" accept="image/png, image/jpeg, image/webp, image/gif">
                            <div class="form-text small">Accepted formats: JPG, PNG, WEBP, GIF. Max file size: 2MB. Leave blank to keep current image.</div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-person-vcard me-2 text-primary"></i> Personal Details
                    </h5>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label fw-semibold small">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="firstName" name="first_name" 
                                   value="<?= e($firstName) ?>" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label fw-semibold small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lastName" name="last_name" 
                                   value="<?= e($lastName) ?>" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= e($email) ?>" required>
                                <div class="invalid-feedback">A valid email is required.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold small">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="<?= e($phone) ?>" placeholder="+1 555-0199">
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="gender" class="form-label fw-semibold small">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                                <option value="other" <?= $gender === 'other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="role" class="form-label fw-semibold small">Account Role</label>
                            <select class="form-select" id="role" name="role" <?= !is_admin() ? 'disabled' : '' ?>>
                                <option value="user" <?= $role === 'user' ? 'selected' : '' ?>>Standard User</option>
                                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Administrator</option>
                            </select>
                            <?php if (!is_admin()): ?>
                                <div class="form-text small">Only administrators can modify roles.</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold small">Status</label>
                            <select class="form-select" id="status" name="status" <?= !is_admin() ? 'disabled' : '' ?>>
                                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <?php if (!is_admin()): ?>
                                <div class="form-text small">Only administrators can alter status.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-semibold small">Biography / Notes</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3"><?= e($bio) ?></textarea>
                    </div>

                    <!-- Change Password (Optional) -->
                    <h5 class="fw-bold text-dark mb-2 pt-3 border-top">
                        <i class="bi bi-shield-lock me-2 text-primary"></i> Change Password
                    </h5>
                    <p class="text-muted small mb-3">Leave both password fields blank if you do not want to change the password.</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="newPassword" class="form-label fw-semibold small">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="newPassword" name="new_password" 
                                       placeholder="Leave blank to keep current" minlength="6">
                                <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="newPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label fw-semibold small">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" 
                                       placeholder="Repeat new password" minlength="6">
                                <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="confirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= BASE_URL ?>user-view.php?id=<?= $user['id'] ?>" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="bi bi-check-lg me-1"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
