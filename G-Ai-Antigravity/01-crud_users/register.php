<?php
/**
 * User Registration Page
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

// Guest only
require_guest();

$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$gender = 'other';
$errors = [];

if (is_post()) {
    $firstName = sanitize($_POST['first_name'] ?? '');
    $lastName  = sanitize($_POST['last_name'] ?? '');
    $email     = sanitize($_POST['email'] ?? '');
    $phone     = sanitize($_POST['phone'] ?? '');
    $gender    = sanitize($_POST['gender'] ?? 'other');
    $password  = $_POST['password'] ?? '';
    $confirmPass = $_POST['confirm_password'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    // Validate CSRF
    if (!verify_csrf_token($csrfToken)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    // Validation
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
        $errors[] = 'Please enter a valid email address.';
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

    // Check duplicate email
    if (empty($errors)) {
        try {
            $db = get_db();
            $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $checkStmt->execute([$email]);
            if ($checkStmt->fetch()) {
                $errors[] = 'This email address is already registered.';
            } else {
                // Insert user
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("
                    INSERT INTO users (first_name, last_name, email, password, role, phone, gender, status, created_at)
                    VALUES (?, ?, ?, ?, 'user', ?, ?, 'active', NOW())
                ");
                $stmt->execute([$firstName, $lastName, $email, $hash, $phone ?: null, $gender]);
                $newId = (int)$db->lastInsertId();

                // Log the newly registered user in automatically
                $newUser = [
                    'id'         => $newId,
                    'first_name' => $firstName,
                    'last_name'  => $lastName,
                    'email'      => $email,
                    'role'       => 'user'
                ];
                login_user($newUser, false);

                set_flash('success', 'Your account has been created successfully! Welcome to UserHub.');
                redirect('users.php');
            }
        } catch (Exception $e) {
            $errors[] = 'Registration failed: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Register Account';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center my-4">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary d-inline-flex p-3 rounded-circle mb-3">
                        <i class="bi bi-person-plus fs-2"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Create an Account</h3>
                    <p class="text-muted small">Join UserHub today and manage your profile</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?= e($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label fw-semibold small">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="firstName" name="first_name" 
                                   value="<?= e($firstName) ?>" placeholder="e.g. John" required>
                            <div class="invalid-feedback">First name is required.</div>
                        </div>
                        <div class="col-sm-6">
                            <label for="lastName" class="form-label fw-semibold small">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lastName" name="last_name" 
                                   value="<?= e($lastName) ?>" placeholder="e.g. Doe" required>
                            <div class="invalid-feedback">Last name is required.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= e($email) ?>" placeholder="john.doe@example.com" required>
                            <div class="invalid-feedback">A valid email is required.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label for="phone" class="form-label fw-semibold small">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="<?= e($phone) ?>" placeholder="+1 555-0100">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="gender" class="form-label fw-semibold small">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                                <option value="other" <?= $gender === 'other' ? 'selected' : '' ?>>Other / Rather not say</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label for="regPassword" class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="regPassword" name="password" 
                                       placeholder="Min 6 characters" minlength="6" required>
                                <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="regPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Password must be at least 6 characters.</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="confirmPassword" class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" class="form-control" id="confirmPassword" name="confirm_password" 
                                       placeholder="Repeat password" minlength="6" required>
                                <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="confirmPassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <div class="invalid-feedback">Please repeat your password.</div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> Register Account
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="small text-muted mb-0">
                        Already have an account? 
                        <a href="<?= BASE_URL ?>login.php" class="text-primary fw-semibold text-decoration-none">Sign In here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
