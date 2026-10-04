<?php
// db.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** @var string $base_url_root */
$base_url_root = "/git-2026-php/01_Personal";  // adjust to match your project

/** @var mysqli $conn */
function getConn1($db_name) {
    /** @var mysqli $conn */
    $conn = mysqli_connect("localhost", "root", "", $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

/** @var mysqli $conn */
$conn = getConn1("ranjith_personal");