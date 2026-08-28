<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tesst_01a.php</title>

  <!-- Bootstrap 5 CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <h1>Sql Error Handling</h1>

  <div class="container">
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
  </div>

  <!-- Bootstrap 5 JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>