<?php
/**
 * Logged-in User Profile & Account Settings
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

require_login();

$user = current_user();
if (!$user) {
    logout_user();
    redirect('login.php');
}

$errors = [];
$activeTab = 'info';

if (is_post()) {
    $action = $_POST['action'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!verify_csrf_token($csrfToken)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    $db = get_db();

    // 1. Update Profile Info
    if ($action === 'update_profile' && empty($errors)) {
        $activeTab = 'info';
        $firstName = sanitize($_POST['first_name'] ?? '');
        $lastName  = sanitize($_POST['last_name'] ?? '');
        $email     = sanitize($_POST['email'] ?? '');
        $phone     = sanitize($_POST['phone'] ?? '');
        $gender    = sanitize($_POST['gender'] ?? 'other');
        $bio       = sanitize($_POST['bio'] ?? '');

        if (empty($firstName)) $errors[] = 'First name is required.';
        if (empty($lastName)) $errors[] = 'Last name is required.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';

        // Check duplicate email
        if ($email !== $user['email']) {
            $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1");
            $checkStmt->execute([$email, $user['id']]);
            if ($checkStmt->fetch()) {
                $errors[] = 'This email address is already in use by another account.';
            }
        }

        // Handle Avatar Upload
        $avatarFilename = $user['avatar'];
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['avatar'];
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'Avatar upload error: ' . $file['error'];
            } else {
                $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if (!in_array($mime, $allowed)) {
                    $errors[] = 'Only JPG, PNG, WEBP, and GIF images are permitted.';
                } elseif ($file['size'] > 2 * 1024 * 1024) {
                    $errors[] = 'Avatar size must be less than 2MB.';
                } else {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $newFile = 'avatar_' . uniqid() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);

                    if (!is_dir(UPLOAD_DIR)) {
                        mkdir(UPLOAD_DIR, 0755, true);
                    }

                    if (move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $newFile)) {
                        if (!empty($user['avatar']) && file_exists(UPLOAD_DIR . $user['avatar'])) {
                            @unlink(UPLOAD_DIR . $user['avatar']);
                        }
                        $avatarFilename = $newFile;
                    }
                }
            }
        }

        if (empty($errors)) {
            try {
                $stmt = $db->prepare("
                    UPDATE users SET 
                        first_name = ?, 
                        last_name = ?, 
                        email = ?, 
                        phone = ?, 
                        gender = ?, 
                        bio = ?, 
                        avatar = ?, 
                        updated_at = NOW() 
                    WHERE id = ?
                ");
                $stmt->execute([
                    $firstName,
                    $lastName,
                    $email,
                    $phone ?: null,
                    $gender,
                    $bio ?: null,
                    $avatarFilename,
                    $user['id']
                ]);

                $_SESSION['user_name'] = $firstName . ' ' . $lastName;
                $_SESSION['user_email'] = $email;

                set_flash('success', 'Your profile details have been updated.');
                redirect('profile.php');
            } catch (Exception $e) {
                $errors[] = 'Failed to update profile: ' . $e->getMessage();
            }
        }
    }

    // 2. Change Password
    if ($action === 'change_password' && empty($errors)) {
        $activeTab = 'security';
        $currentPass = $_POST['current_password'] ?? '';
        $newPass     = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if (empty($currentPass)) {
            $errors[] = 'Current password is required.';
        } elseif (!password_verify($currentPass, $user['password'])) {
            $errors[] = 'Current password is incorrect.';
        }

        if (empty($newPass)) {
            $errors[] = 'New password is required.';
        } elseif (strlen($newPass) < 6) {
            $errors[] = 'New password must be at least 6 characters.';
        }

        if ($newPass !== $confirmPass) {
            $errors[] = 'New passwords do not match.';
        }

        if (empty($errors)) {
            try {
                $newHash = password_hash($newPass, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$newHash, $user['id']]);

                set_flash('success', 'Your password has been changed successfully.');
                redirect('profile.php');
            } catch (Exception $e) {
                $errors[] = 'Failed to update password: ' . $e->getMessage();
            }
        }
    }
}

$pageTitle = 'My Profile';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">
                    <i class="bi bi-person-circle text-primary me-2"></i> Account Settings
                </h2>
                <p class="text-muted small mb-0">Manage your profile information and account security</p>
            </div>
            <a href="<?= BASE_URL ?>users.php" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-people me-1"></i> Users Directory
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

        <div class="row g-4">
            <!-- Left Column: User Summary Card -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center p-4">
                    <div class="position-relative d-inline-block mx-auto mb-3">
                        <img src="<?= get_user_avatar($user['avatar'], $user['first_name'], $user['last_name']) ?>" 
                             alt="<?= e($user['first_name']) ?>" 
                             class="avatar-img avatar-xl shadow-sm">
                    </div>
                    <h5 class="fw-bold text-dark mb-1"><?= e($user['first_name'] . ' ' . $user['last_name']) ?></h5>
                    <p class="text-muted small mb-2"><?= e($user['email']) ?></p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <span class="badge-role-<?= e($user['role']) ?>"><?= ucfirst($user['role']) ?></span>
                        <span class="badge-status-<?= e($user['status']) ?>"><?= ucfirst($user['status']) ?></span>
                    </div>

                    <hr class="my-3 text-muted">

                    <div class="text-start small">
                        <div class="mb-2 text-muted">
                            <i class="bi bi-calendar-event me-2"></i> Member since <?= format_date($user['created_at'], 'M d, Y') ?>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-clock-history me-2"></i> Last update <?= time_ago($user['updated_at']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings Tabs -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom p-0">
                        <ul class="nav nav-tabs card-header-tabs px-3 pt-2" id="profileTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link <?= $activeTab === 'info' ? 'active' : '' ?>" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-pane" type="button" role="tab">
                                    <i class="bi bi-person me-1"></i> Edit Profile
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link <?= $activeTab === 'security' ? 'active' : '' ?>" id="security-tab" data-bs-toggle="tab" data-bs-target="#security-pane" type="button" role="tab">
                                    <i class="bi bi-shield-lock me-1"></i> Security & Password
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content" id="profileTabsContent">
                            <!-- Tab 1: Info -->
                            <div class="tab-pane fade <?= $activeTab === 'info' ? 'show active' : '' ?>" id="info-pane" role="tabpanel">
                                <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="update_profile">

                                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                                        <img id="avatarPreview" 
                                             src="<?= get_user_avatar($user['avatar'], $user['first_name'], $user['last_name']) ?>" 
                                             alt="Preview" 
                                             class="avatar-img avatar-lg">
                                        <div>
                                            <label for="avatarInput" class="form-label fw-bold text-dark mb-1">Update Profile Picture</label>
                                            <input class="form-control form-control-sm" type="file" id="avatarInput" name="avatar" accept="image/*">
                                            <div class="form-text small">Max 2MB (JPG, PNG, WEBP).</div>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-6">
                                            <label for="profFirst" class="form-label fw-semibold small">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="profFirst" name="first_name" 
                                                   value="<?= e($user['first_name']) ?>" required>
                                            <div class="invalid-feedback">First name is required.</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="profLast" class="form-label fw-semibold small">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="profLast" name="last_name" 
                                                   value="<?= e($user['last_name']) ?>" required>
                                            <div class="invalid-feedback">Last name is required.</div>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-6">
                                            <label for="profEmail" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="profEmail" name="email" 
                                                   value="<?= e($user['email']) ?>" required>
                                            <div class="invalid-feedback">Valid email is required.</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="profPhone" class="form-label fw-semibold small">Phone Number</label>
                                            <input type="text" class="form-control" id="profPhone" name="phone" 
                                                   value="<?= e($user['phone']) ?>" placeholder="+1 555-0100">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="profGender" class="form-label fw-semibold small">Gender</label>
                                        <select class="form-select" id="profGender" name="gender">
                                            <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                                            <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                                            <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="profBio" class="form-label fw-semibold small">About Me / Bio</label>
                                        <textarea class="form-control" id="profBio" name="bio" rows="3"><?= e($user['bio']) ?></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                        <i class="bi bi-check-lg me-1"></i> Save Changes
                                    </button>
                                </form>
                            </div>

                            <!-- Tab 2: Security -->
                            <div class="tab-pane fade <?= $activeTab === 'security' ? 'show active' : '' ?>" id="security-pane" role="tabpanel">
                                <form method="POST" action="" class="needs-validation" novalidate>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="action" value="change_password">

                                    <div class="mb-3">
                                        <label for="curPass" class="form-label fw-semibold small">Current Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                            <input type="password" class="form-control" id="curPass" name="current_password" required>
                                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="curPass">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">Current password is required.</div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="newPass" class="form-label fw-semibold small">New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                            <input type="password" class="form-control" id="newPass" name="new_password" minlength="6" required>
                                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="newPass">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">Password must be at least 6 characters.</div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="confPass" class="form-label fw-semibold small">Confirm New Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi bi-check2-circle"></i></span>
                                            <input type="password" class="form-control" id="confPass" name="confirm_password" minlength="6" required>
                                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="confPass">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">Please confirm your new password.</div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                        <i class="bi bi-shield-check me-1"></i> Update Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
