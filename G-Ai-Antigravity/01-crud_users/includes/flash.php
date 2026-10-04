<?php
/**
 * Flash Notification Messages
 */

function set_flash(string $type, string $message): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash'] = [
        'type'    => in_array($type, ['success', 'danger', 'warning', 'info']) ? $type : 'info',
        'message' => $message
    ];
}

function has_flash(): bool {
    return isset($_SESSION['flash']);
}

function get_flash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function render_flash(): void {
    $flash = get_flash();
    if (!$flash) {
        return;
    }

    $icon = match ($flash['type']) {
        'success' => 'bi-check-circle-fill',
        'danger'  => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-diamond-fill',
        default   => 'bi-info-circle-fill'
    };

    echo '<div class="alert alert-' . htmlspecialchars($flash['type']) . ' alert-dismissible fade show d-flex align-items-center shadow-sm my-3" role="alert">';
    echo '  <i class="bi ' . $icon . ' me-2 fs-5"></i>';
    echo '  <div class="flex-grow-1">' . htmlspecialchars($flash['message']) . '</div>';
    echo '  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}
