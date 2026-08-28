<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tesst_01_components.php</title>

  <!-- Bootstrap 5 CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <h1>01_components.php</h1>

  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    $msg = "A simple success alert";

    echo 'Html alert';
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
    </div>';
    ?>

    <!-- bootstrp-5 alert -->
    <p>bootstrp-5 alert</p>
    <?php
    $msg11 = "This is a ";
    $msg12 = "simple success alert. . ";
    ?>
    <div class="alert alert-warning" role="alert">
      <?= $msg11 . $msg12 ?>
    </div>

    <!-- bootstrp-5 alert -->
    <p>Display parameterize msg from calling pgm</p>
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
    }

    // Normal
    // if (isset($_GET["first_name"])) {
    //   $first_name =" ". $_GET["first_name"];
    // }

    // With treary oprator
    // $first_name = isset($_GET["first_name"]) ? " " . $_GET["first_name"] : "";

    // Or using null coalescing operator (PHP 7+):
// $first_name = isset($_GET["first_name"]) ? " " . $_GET["first_name"] : "";

// Even shorter with null coalescing:
// $first_name = " " . ($_GET["first_name"] ?? "");

// Or if you want to avoid the extra space when empty:
  $first_name = isset($_GET["first_name"]) ? " " . $_GET["first_name"] : "";

    if (isset($_GET["last_name"])) {
      $last_name = " " . $_GET["last_name"];
    }
    ?>
    <div class="alert alert-warning" role="alert">
      <?= $msg . $first_name . $last_name ?>
    </div>


  </div>
  <!-- //contaner -->


  <!-- Bootstrap 5 JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>