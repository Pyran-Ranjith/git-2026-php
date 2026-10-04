<?php
/**
 * Application Configuration
 */

// Error Reporting (Turn on for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
// define('DB_NAME', 'crud_users_db');
define('DB_NAME', 'ai_antigaravity_crud');
define('DB_USER', 'root');
define('DB_PASS', '');

// Application Constants
define('APP_NAME', 'UserHub');
define('APP_TAGLINE', 'Modern User Management & Authentication');

// Dynamic BASE_URL Detection
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Calculate relative path from web root to project directory
    $docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])) : '';
    $projectRoot = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    
    if ($docRoot && strpos($projectRoot, $docRoot) === 0) {
        $relativePath = substr($projectRoot, strlen($docRoot));
    } else {
        // Fallback detection
        $relativePath = '/git-2026-php/G-Ai-Antigravity/01-crud_users';
    }
    
    $baseUrl = rtrim($protocol . $host . $relativePath, '/') . '/';
    define('BASE_URL', $baseUrl);
}

// Upload Directories
define('ROOT_PATH', realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR);
define('UPLOAD_DIR', ROOT_PATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR);
define('UPLOAD_URL', BASE_URL . 'assets/uploads/avatars/');

// Start Session with secure cookie params if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
