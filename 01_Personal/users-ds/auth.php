<?php
// auth.php
$development = true;
// Enable error reporting for development (remove in production)
if ($development) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    mysqli_report(MYSQLI_REPORT_OFF);   // so mysqli_query returns false instead of throwing
}

require_once __DIR__ . "/db.php";

if (empty($_SESSION['user_id'])) {
    header("Location: " . $base_url_root . "/login.php");
    exit;
}