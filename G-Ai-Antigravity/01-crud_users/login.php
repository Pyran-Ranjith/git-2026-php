<?php
/**
 * User Login Page (Session + Cookie Remember Me)
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

// Redirect if already logged in
require_guest();

$email = '';
$errors = [];
$redirectUrl = sanitize($_GET['redirect'] ?? '');

if (is_post()) {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = !empty($_POST['remember']);
    $csrfToken = $_POST['csrf_token'] ?? '';

    // CSRF verification
    if (!verify_csrf_token($csrfToken)) {
        $errors[] = 'Invalid security token. Please try again.';
    }

    if (empty($email)) {
        $errors[] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if (empty($password)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        try {
            $db = get_db();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] !== 'active') {
                    $errors[] = 'Your account is inactive. Please contact an administrator.';
                } else {
                    // Successful login!
                    login_user($user, $remember);
                    set_flash('success', 'Welcome back, ' . $user['first_name'] . '!');

                    if (!empty($redirectUrl) && filter_var($redirectUrl, FILTER_VALIDATE_URL) === false) {
                        // Prevent open redirect; ensure local path
                        redirect(ltrim($redirectUrl, '/'));
                    } else {
                        redirect('users.php');
                    }
                }
            } else {
                $errors[] = 'Invalid email address or password.';
            }
        } catch (Exception $e) {
            $errors[] = 'An error occurred during sign in. Please try again.';
        }
    }
}

$pageTitle = 'Sign In';
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-sm-5">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary d-inline-flex p-3 rounded-circle mb-3">
                        <i class="bi bi-shield-lock fs-2"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Sign In</h3>
                    <p class="text-muted small">Enter your credentials to access your account</p>
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
                    
                    <div class="mb-3">
                        <label for="emailInput" class="form-label fw-semibold small">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="emailInput" name="email" 
                                   value="<?= e($email) ?>" placeholder="name@example.com" required autofocus>
                            <div class="invalid-feedback">Please provide a valid email.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="passwordInput" class="form-label fw-semibold small mb-0">Password</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="passwordInput" name="password" 
                                   placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="passwordInput">
                                <i class="bi bi-eye"></i>
                            </button>
                            <div class="invalid-feedback">Password is required.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMeCheck" value="1">
                            <label class="form-check-label small text-muted" for="rememberMeCheck">
                                Remember me (Cookie)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                </form>

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="small text-muted mb-0">
                        Don't have an account? 
                        <a href="<?= BASE_URL ?>register.php" class="text-primary fw-semibold text-decoration-none">Create one</a>
                    </p>
                </div>

                <!-- Quick Demo Fill Helpers -->
                <div class="mt-4 p-3 bg-light rounded-3">
                    <div class="small fw-bold text-muted mb-2 text-center text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                        Quick Demo Auto-Fill
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary w-50" onclick="fillCredentials('admin@example.com', 'admin123')">
                            Admin Demo
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary w-50" onclick="fillCredentials('john@example.com', 'password123')">
                            User Demo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillCredentials(email, pass) {
    document.getElementById('emailInput').value = email;
    document.getElementById('passwordInput').value = pass;
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
