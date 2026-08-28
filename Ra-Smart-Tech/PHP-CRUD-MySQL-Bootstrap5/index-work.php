<?php
// include_once "db_conn.php";
include_once "header.php";
?>
<title>index-work.php</title>
</head>

<body>
  <div class="container">
    <?php
    // if (isset($_GET["msg"])) {
    //   $msg = $_GET["msg"];
    //   echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    //   ' . $msg . '
    //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    // }
    ?>
    <!-- bootstrp-5 alert -->
    <!-- <p>Display parameterize msg from calling pgm</p> -->
    <?php
      $msg = ($_GET["msg"] ?? "");
    ?>
    <?php if ($msg) { ?>
    <div class="alert alert-success" role="alert">
      <?= $msg ?>
    </div>
    <?php } ?>

    <a href="add_new.php" class="btn btn-dark mb-3">Add New</a>
  </div>

  <!-- Bootstrap 5 JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
  </script>
</body>

</html>