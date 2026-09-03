<?php
// config.php
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = rtrim(dirname($script), '/\\');
    return $protocol . $host . $path;
}

define('BASE_URL', getBaseUrl());
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']));
?>