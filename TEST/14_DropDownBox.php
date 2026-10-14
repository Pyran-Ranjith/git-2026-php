<?php
$cat = trim($_POST['cat'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test | 14_DropDownBox.php</title>

    <!-- Bootstrap 5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h1>Test | 14_ Datalist - Select or Type</h1>

    <div class="container mt-5">
        <h3>Select or Type a Cat</h3>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Cat:</label>
                <input type="text" class="form-control" name="cat"
                    list="catList"
                    value="<?= htmlspecialchars($cat) ?>"
                    placeholder="Select or type...">

                <datalist id="catList">
                    <option value="Cricket">
                    <option value="Tv">
                </datalist>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <?php if ($cat): ?>
            <div class="alert alert-success mt-3">
                You entered: <strong><?= htmlspecialchars($cat) ?></strong>
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