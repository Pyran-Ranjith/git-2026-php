<?php
// config.php
function getBaseUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = rtrim(dirname($script), '/\\');
    // echo "<br><br><br>";
    // echo "_SERVER['DOCUMENT_ROOT'] = " . $_SERVER['DOCUMENT_ROOT'] . "";
    // echo "<br>";
    // echo "Shost = " . $_SERVER['HTTP_HOST'] . "";
    // echo "<br>";
    $Sscript = $_SERVER['SCRIPT_NAME'];
    // echo "Sscript = " . $_SERVER['SCRIPT_NAME'] . "";
    // echo "<br>";
    // echo "Spath = " . rtrim(dirname($Sscript), '/\\') . "";
    // echo "<br>";
    return $protocol . $host . $path;
}

function getConn()
{
    $setvername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ranjith_personal";

    $conn = mysqli_connect($setvername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully";
    return $conn;
}

// Only works in localhost
// $base_url_root = "http://localhost/git-2026-php/01_Personal";
// $base_path_root = "C:\\xampp\htdocs\git-2026-php\01_Personal"; // Use file system path, NOT URL foo require_once

// $base_url_diary = "http://localhost/git-2026-php/01_Personal/diary";
// $base_path_diary = "C:\\xampp\htdocs\git-2026-php\01_Personal\diary"; // Use file system path, NOT URL foo require_once

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];
$path = rtrim(dirname($script), '/\\');
// works in localhost and infinityfree
$base_url_root = $protocol . $host . $path;
$base_path_root = $_SERVER['DOCUMENT_ROOT'] . $path; // Use file system path, NOT URL foo require_once

$base_url_diary  = $base_url_root  . "/diary";
$base_path_diary = $base_path_root . "/diary"; // Use file system path, NOT URL foo require_once

// echo "<br><br>";
// echo "Sbase_url_root = " . $base_url_root . "";
// echo "<br>";
// echo "Sbase_path_root = " . $base_path_root . "";
// echo "<br>";

define('BASE_URL', getBaseUrl());
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']));

// $burl = getBaseUrl();
$conn = getConn();
