<?php
/**
 * Database Connection using PDO
 */
require_once __DIR__ . '/config.php';

function get_db(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Check if error is database doesn't exist (error code 1049)
            if ($e->getCode() == 1049) {
                // Try to create the database automatically
                try {
                    $rootDsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
                    $rootPdo = new PDO($rootDsn, DB_USER, DB_PASS, $options);
                    $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    // Reconnect to newly created database
                    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
                } catch (PDOException $createEx) {
                    die("Database connection failed and could not be auto-created: " . htmlspecialchars($createEx->getMessage()));
                }
            } else {
                die("Database connection error: " . htmlspecialchars($e->getMessage()));
            }
        }
    }

    return $pdo;
}
