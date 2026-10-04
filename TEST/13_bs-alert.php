<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>13_bs-alert.php</title>

    <!-- Bootstrap 5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h1>13_bs-alert.php</h1>

        <?php
        $msg = "Record saved successfully!";
        $alert_type = "success";
        ?>

        <div class="container mt-3">
            <br><br>
            <?php if (!empty($msg)): ?>
                <div class="alert alert-<?= htmlspecialchars($alert_type) ?> alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert">
                    <div>
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= htmlspecialchars($msg) ?>
                        <a href="admin.php" class="alert-link fw-bold ms-3 text-decoration-underline">
                            <i class="bi bi-arrow-clockwise"></i> Refresh parameters
                        </a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    <!-- //contaner -->


    <!-- Bootstrap 5 JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>