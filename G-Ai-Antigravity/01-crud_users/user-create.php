<?php
/**
 * Create New User - CRUD Create
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

// Must be logged in to create users
require_login();

$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$gender = 'other';
$role = 'user';
$status = 'active';
$bio = '';
$errors = [];

if (is_post()) {
    $firstName   = sanitize($_POST['first_name'] ?? '');
    $lastName    = sanitize($_POST['last_name'] ?? '');
    $email       = sanitize($_POST['email'] ?? '');
    $phone       = sanitize($_POST['phone'] ?? '');
    $gender      = sanitize($_POST['gender'] ?? 'other');
    $status      = sanitize($_POST['status'] ?? 'active');
    $bio         = sanitize($_POST['bio'] ?? '');
    $password    = $_POST['password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';
    $csrfToken   = $_POST['csrf_token'] ?? '';

    // Only admins can assign role 'admin'; regular users create 'user'
    if (is_admin() && isset($_POST['role']) && in_array($_POST['role'], ['admin', 'user'])) {
        $role = $_POST['role'];
    } else {
        $role = 'user';
    }

    // CSRF verification
    if (!verify_csrf_token($csrfToken)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    // Validations
    if (empty($firstName)) {
        $errors[] = 'First name is required.';
    } elseif (strlen($firstName) < 2) {
        $errors[] = 'First name must be at least 2 characters.';
    }

    if (empty($lastName)) {
        $errors[] = 'Last name is required.';
    } elseif (strlen($lastName) < 2) {
        $errors[] = 'Last name must be at least 2 characters.';
    }

    if (empty($email)) {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($password !== $confirmPass) {
        $errors[] = 'Passwords do not match.';
    }

    if (!in_array($gender, ['male', 'female', 'other'])) {
        $gender = 'other';
    }

    if (!in_array($status, ['active', 'inactive'])) {
        $status = 'active';
    }

    // Check avatar upload
    $avatarFilename = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['avatar'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload failed with error code: ' . $file['error'];
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $file['tmp_name']);
            finfo_close($fileInfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = 'Invalid avatar image type. Only JPG, PNG, WEBP, and GIF are allowed.';
            } elseif ($file['size'] > 2 * 1024 * 1024) {
                $errors[] = 'Avatar image size must be less than 2MB.';
            } else {
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $avatarFilename = 'avatar_' . uniqid() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($extension);
                
                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $avatarFilename)) {
                    $errors[] = 'Failed to save uploaded avatar image.';
                    $avatarFilename = null;
                }
            }
        }
    }

    // Database insertion
    if (empty($errors)) {
        try {
            $db = get_db();
            
            // Check email uniqueness
            $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $checkStmt->execute([$email]);
            if ($checkStmt->fetch()) {
                $errors[] = 'This email address is already in use by another user.';
                // Delete uploaded avatar if email is duplicate
                if ($avatarFilename && file_exists(UPLOAD_DIR . $avatarFilename)) {
                    unlink(UPLOAD_DIR . $avatarFilename);
                }
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("
                    INSERT INTO users (first_name, last_name, email, password, role, phone, gender, bio, avatar, status, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([
                    $firstName,
                    $lastName,
                    $email,
                    $hashedPassword,
                    $role,
                    $phone ?: null,
                    $gender,
                    $bio ?: null,
                    $avatarFilename,
                    $status
                ]);

                $newUserId = (int)$db->lastInsertId();
                set_flash('success', "User '{$firstName} {$lastName}' created successfully!");
                redirect("user-view.php?id={$newUserId}");
            }
        } catch (Exception $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
            if ($avatarFilename && file_exists(UPLOAD_DIR . $avatarFilename)) {
                unlink(UPLOAD_DIR . $avatarFilename);
            }
        }
    }
}

$pageTitle = 'Add New User';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-9 col-xl-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">
                    <i class="bi bi-person-plus-fill text-primary me-2"></i> Add New User
                </h2>
                <p class="text-muted small mb-0">Create a new user account with personal details and permissions</p>
            </div>
            <a href="<?= BASE_URL ?>users.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Users
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong class="d-block mb-1">Please correct the following errors:</strong>
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <!-- Avatar Preview & Upload -->
                    <div class="d-flex flex-column flex-sm-row align-items-center gap-4 mb-4 pb-3 border-bottom">
                        <img id="avatarPreview" 
                             src="https://ui-avatars.com/api/?name=New+User&background=E0E7FF&color=4338CA&size=128" 
                             alt="Avatar Preview" 
                             class="avatar-img avatar-xl border">
                        <div>
                            <label for="avatarInput" class="form-label fw-bold text-dark mb-1">Profile Photo / Avatar</label>
                            <input class="form-control form-control-sm" type="file" id="avatarInput" name="avatar" accept="image/png, image/jpeg, image/webp, image/gif">
                            <div class="form-text small">Accepted formats: JPG, PNG, WEBP, GIF. Max file size: 2MB.</div>
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
                                   value="<?= e($firstName) ?>" placeholder="e.g. Robert" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label fw-semibold small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lastName" name="last_name" 
                                   value="<?= e($lastName) ?>" placeholder="e.g. Taylor" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= e($email) ?>" placeholder="user@example.com" required>
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
                                <div class="form-text small">Only administrators can grant admin privileges.</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <label for="status" class="form-label fw-semibold small">Account Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label fw-semibold small">Biography / Notes</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Brief note about the user..."><?= e($bio) ?></textarea>
                    </div>

                    <!-- Security & Password -->
                    <h5 class="fw-bold text-dark mb-3 pt-3 border-top">
                        <i class="bi bi-shield-lock me-2 text-primary"></i> Account Credentials
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="password" name="password" 
                                       placeholder="Min 6 characters" minlength="6" required>
                                <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Password is required (min 6 characters).</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="confirmPassword" class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" 
                                       placeholder="Repeat password" minlength="6" required>
                                <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="confirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Password confirmation is required.</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= BASE_URL ?>users.php" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="bi bi-check-lg me-1"></i> Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
