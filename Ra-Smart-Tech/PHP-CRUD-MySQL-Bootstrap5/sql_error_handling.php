<?php
// Disable MySQLi exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "ra_smart_tech_curd");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO `crudd` (name, email) VALUES ('John', 'john@email.com')";

if (mysqli_query($conn, $sql)) {
    echo "Record created successfully!";
} else {
    // Get error details
    $error_no = mysqli_errno($conn);
    $error_msg = mysqli_error($conn);
    
    // Display in readable format
    echo "<h3>Database Error</h3>";
    echo "<p><strong>Error Number:</strong> " . $error_no . "</p>";
    echo "<p><strong>Error Description:</strong> " . htmlspecialchars($error_msg) . "</p>";
    
    // For 1146 error, show specific message
    if ($error_no == 1146) {
        preg_match("/Table '.*?\.(.*?)' doesn't exist/", $error_msg, $matches);
        $table = $matches[1] ?? 'unknown';
        echo "<p><strong>Missing Table:</strong> " . $table . "</p>";
    }
}

mysqli_close($conn);
?>