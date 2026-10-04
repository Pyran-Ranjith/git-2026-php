<?php
/**
 * Delete User Handler - CRUD Delete
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/flash.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/csrf.php';

// Must be authenticated
require_login();

// Must be POST request
if (!is_post()) {
    set_flash('danger', 'Invalid request method for user deletion.');
    redirect('users.php');
}

// CSRF validation
$csrfToken = $_POST['csrf_token'] ?? '';
if (!verify_csrf_token($csrfToken)) {
    set_flash('danger', 'Invalid security token. Deletion aborted.');
    redirect('users.php');
}

$userId = (int)($_POST['user_id'] ?? 0);
if ($userId <= 0) {
    set_flash('danger', 'Invalid user ID specified.');
    redirect('users.php');
}

// Prevent deleting self while logged in
if ((int)$_SESSION['user_id'] === $userId) {
    set_flash('danger', 'You cannot delete your own account while logged in.');
    redirect('users.php');
}

// Only admin can delete users
if (!is_admin()) {
    set_flash('danger', 'Administrator privileges are required to delete users.');
    redirect('users.php');
}

try {
    $db = get_db();

    // Fetch user to get avatar path and name
    $stmt = $db->prepare("SELECT id, first_name, last_name, avatar FROM users WHERE id = ? LIMIT 1");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if (!$user) {
        set_flash('warning', 'User does not exist or has already been deleted.');
        redirect('users.php');
    }

    // Delete avatar file if exists
    if (!empty($user['avatar']) && file_exists(UPLOAD_DIR . $user['avatar'])) {
        @unlink(UPLOAD_DIR . $user['avatar']);
    }

    // Delete tokens
    $delTokens = $db->prepare("DELETE FROM user_tokens WHERE user_id = ?");
    $delTokens->execute([$userId]);

    // Delete user record
    $delUser = $db->prepare("DELETE FROM users WHERE id = ?");
    $delUser->execute([$userId]);

    set_flash('success', "User '{$user['first_name']} {$user['last_name']}' has been permanently deleted.");
} catch (Exception $e) {
    set_flash('danger', 'Failed to delete user: ' . $e->getMessage());
}

redirect('users.php');
