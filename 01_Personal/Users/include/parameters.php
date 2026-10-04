<!-- g_protocol = http://localhost/git-2026-php/01_Personal
g_host = localhost
g_script = /git-2026-php/01_Personal/dashboard.php
g_path = /git-2026-php/01_Personal
g_base_url_root = http://localhost/git-2026-php/01_Personal
g_base_path_root = C:/xampp/htdocs/git-2026-php/01_Personal
base_path_diary = http://localhost/git-2026-php/01_Personallocalhost/git-2026-php/01_Personal/Diary  -->

<?php
  $g_app_name = "Ranjith's Personal";
  $g_app_favicon = "Ranjith_personal-1.png";


$g_protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$g_host = $_SERVER['HTTP_HOST'];
$g_script = $_SERVER['SCRIPT_NAME'];
$g_path = rtrim(dirname($g_script), '/\\');

// $g_base_url_root = dirname($g_protocol . $g_host . $g_path);
$g_base_url_root = $g_protocol . $g_host . $g_path;

$g_base_path_root = dirname($_SERVER['DOCUMENT_ROOT'] . $g_path); // Use file system path, NOT URL foo require_once
$g_base_path_root = $_SERVER['DOCUMENT_ROOT'] . $g_path; // Use file system path, NOT URL foo require_once

$g_protocol  = $g_protocol . $g_host . $g_path;
// $base_path_diary = $g_protocol . $g_host . $g_path; // Use file system path, NOT URL foo require_once
$base_path_diary = $g_protocol . $g_host . $g_path . "/Diary"; // Use file system path, NOT URL foo require_once

// echo "<br><br><br>";
// echo "g_protocol = " . $g_protocol . "";
// echo "<br>";
// echo "g_host = " . $g_host . "";
// echo "<br>";
// echo "g_script = " . $g_script . "";
// echo "<br>";
// echo "g_path = " . $g_path . "";
// echo "<br>";
// echo "g_base_url_root = " . $g_base_url_root . "";
// echo "<br>";
// echo "g_base_path_root = " . $g_base_path_root . "";
// echo "<br>";
// echo "base_path_diary = " . $base_path_diary . "";


// echo "<br><br>";
// echo "Sbase_url_root = " . $g_base_url_root . "";
// echo "<br>";
// echo "Sbase_path_root = " . $g_base_path_root . "";
// echo "<br>";

// echo "<br><br>";
// echo "Sbase_url_diary = " . $g_base_url_diary . "";
// echo "<br>";
// echo "Sbase_path_diary = " . $g_base_path_diary . "";
// echo "<br>";


// --------------------------------------------------------------------------------------
  $g_server_localhost = [
    "host" => "localhost",
    "user" => "root",
    "pass" => "",
    "name" => "ranjith_personal"
    ];

  $g_server_infinityfree = [
    "host" => "sql312.infinityfree.com",
    "user" => "if0_34821597",
    "pass" => "q6CJCIvgPj9zjh5",
    "name" => "if0_34821597_ranjith_personal"
    ];
  ?>
