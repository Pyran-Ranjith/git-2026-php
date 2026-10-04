<?php
/**
 * Authentication and Session Management with Cookies
 */
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/flash.php';

const REMEMBER_COOKIE = 'userhub_remember';

/**
 * Check if the user is currently logged in (via session or cookie)
 */
function is_logged_in(): bool {
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return attempt_cookie_login();
}

/**
 * Attempt to restore login session using remember-me cookie
 */
function attempt_cookie_login(): bool {
    if (!isset($_COOKIE[REMEMBER_COOKIE])) {
        return false;
    }

    $cookieVal = $_COOKIE[REMEMBER_COOKIE];
    $parts = explode(':', $cookieVal, 2);
    if (count($parts) !== 2) {
        clear_remember_cookie();
        return false;
    }

    [$selector, $validator] = $parts;

    try {
        $db = get_db();
        $stmt = $db->prepare("SELECT * FROM user_tokens WHERE selector = ? AND expiry > NOW() LIMIT 1");
        $stmt->execute([$selector]);
        $token = $stmt->fetch();

        if (!$token) {
            clear_remember_cookie();
            return false;
        }

        if (hash_equals($token['hashed_validator'], hash('sha256', $validator))) {
            // Token is valid! Fetch user
            $userStmt = $db->prepare("SELECT * FROM users WHERE id = ? AND status = 'active' LIMIT 1");
            $userStmt->execute([$token['user_id']]);
            $user = $userStmt->fetch();

            if ($user) {
                // Refresh session
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                return true;
            }
        }
    } catch (Exception $e) {
        error_log("Error in attempt_cookie_login: " . $e->getMessage());
    }

    clear_remember_cookie();
    return false;
}

/**
 * Log the user in, initialize session, and optionally set persistent remember cookie
 */
function login_user(array $user, bool $remember = false): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'];

    if ($remember) {
        create_remember_cookie((int)$user['id']);
    }
}

/**
 * Create remember-me token and cookie
 */
function create_remember_cookie(int $userId): void {
    try {
        $selector = bin2hex(random_bytes(12));
        $validator = bin2hex(random_bytes(32));
        $hashedValidator = hash('sha256', $validator);
        $expiryTime = time() + (86400 * 30); // 30 days
        $expiryDate = date('Y-m-d H:i:s', $expiryTime);

        $db = get_db();
        // Remove existing expired tokens for this user
        $cleanStmt = $db->prepare("DELETE FROM user_tokens WHERE user_id = ? OR expiry <= NOW()");
        $cleanStmt->execute([$userId]);

        // Insert new token
        $stmt = $db->prepare("INSERT INTO user_tokens (user_id, selector, hashed_validator, expiry) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $selector, $hashedValidator, $expiryDate]);

        // Set secure HTTP-only cookie
        setcookie(
            REMEMBER_COOKIE,
            $selector . ':' . $validator,
            [
                'expires'  => $expiryTime,
                'path'     => '/',
                'domain'   => '',
                'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );
    } catch (Exception $e) {
        error_log("Error creating remember token: " . $e->getMessage());
    }
}

/**
 * Remove remember cookie and associated DB record
 */
function clear_remember_cookie(): void {
    if (isset($_COOKIE[REMEMBER_COOKIE])) {
        $parts = explode(':', $_COOKIE[REMEMBER_COOKIE], 2);
        if (count($parts) === 2) {
            try {
                $db = get_db();
                $stmt = $db->prepare("DELETE FROM user_tokens WHERE selector = ?");
                $stmt->execute([$parts[0]]);
            } catch (Exception $e) {
                // Ignore failure
            }
        }

        setcookie(
            REMEMBER_COOKIE,
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'domain'   => '',
                'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );
        unset($_COOKIE[REMEMBER_COOKIE]);
    }
}

/**
 * Log the user out and clean up session and cookies
 */
function logout_user(): void {
    clear_remember_cookie();
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

/**
 * Get current user data from database
 */
function current_user(): ?array {
    static $cachedUser = null;
    if ($cachedUser !== null) {
        return $cachedUser;
    }

    if (!is_logged_in()) {
        return null;
    }

    try {
        $db = get_db();
        $stmt = $db->prepare("SELECT id, first_name, last_name, email, role, phone, gender, bio, avatar, status, created_at, updated_at FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$_SESSION['user_id']]);
        $cachedUser = $stmt->fetch();
        return $cachedUser ?: null;
    } catch (Exception $e) {
        error_log("Error getting current user: " . $e->getMessage());
        return null;
    }
}

/**
 * Check if the currently logged in user is an Admin
 */
function is_admin(): bool {
    if (!is_logged_in()) {
        return false;
    }
    return (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
}

/**
 * Require user to be logged in; otherwise redirect to login
 */
function require_login(): void {
    if (!is_logged_in()) {
        set_flash('warning', 'Please sign in to access this page.');
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
        redirect('login.php' . ($currentUrl ? '?redirect=' . urlencode($currentUrl) : ''));
    }
}

/**
 * Require user to be an admin
 */
function require_admin(): void {
    require_login();
    if (!is_admin()) {
        set_flash('danger', 'Access restricted! Administrator privileges required.');
        redirect('users.php');
    }
}

/**
 * For pages only guests should view (like Login and Register)
 */
function require_guest(): void {
    if (is_logged_in()) {
        redirect('users.php');
    }
}
