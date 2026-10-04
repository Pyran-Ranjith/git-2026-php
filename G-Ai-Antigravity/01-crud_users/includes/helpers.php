<?php
/**
 * Helper Utility Functions
 */

/**
 * Escape HTML output to prevent XSS
 */
function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a given URL or path
 */
function redirect(string $path): void {
    if (filter_var($path, FILTER_VALIDATE_URL)) {
        header("Location: " . $path);
    } else {
        header("Location: " . BASE_URL . ltrim($path, '/'));
    }
    exit;
}

/**
 * Check if current request is POST
 */
function is_post(): bool {
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/**
 * Sanitize text input string
 */
function sanitize(?string $value): string {
    return trim($value ?? '');
}

/**
 * Get user avatar URL with fallback to initials SVG
 */
function get_user_avatar(?string $avatarFilename, string $firstName = 'U', string $lastName = 'U'): string {
    if (!empty($avatarFilename)) {
        $path = ROOT_PATH . 'assets/uploads/avatars/' . $avatarFilename;
        if (file_exists($path)) {
            return BASE_URL . 'assets/uploads/avatars/' . rawurlencode($avatarFilename);
        }
    }
    
    // UI Initials SVG placeholder
    $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
    if (empty($initials)) {
        $initials = 'U';
    }
    
    // Nice gradient background based on initials
    return "https://ui-avatars.com/api/?name=" . urlencode($firstName . ' ' . $lastName) . "&background=0D6EFD&color=fff&size=128&bold=true";
}

/**
 * Format datetime string into human readable format
 */
function format_date(?string $datetime, string $format = 'M d, Y h:i A'): string {
    if (!$datetime) {
        return '—';
    }
    $ts = strtotime($datetime);
    return $ts ? date($format, $ts) : '—';
}

/**
 * Return relative time like "3 mins ago", "yesterday", etc.
 */
function time_ago(?string $datetime): string {
    if (!$datetime) return 'Never';
    $time = strtotime($datetime);
    if (!$time) return 'Never';

    $diff = time() - $time;
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . 'm ago';
    if ($diff < 86400) return floor($diff / 3600) . 'h ago';
    if ($diff < 604800) return floor($diff / 86400) . 'd ago';
    return date('M d, Y', $time);
}

/**
 * Helper to check if current page matches for active nav highlighting
 */
function is_active_page(string $pageName): string {
    $script = basename($_SERVER['SCRIPT_NAME'] ?? '');
    return ($script === $pageName) ? 'active' : '';
}
