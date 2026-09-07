<?php
echo "_SERVER['DOCUMENT_ROOT'] = " . $_SERVER['DOCUMENT_ROOT'] . ">";
echo "<br>";
echo "Shost = " . $_SERVER['HTTP_HOST'] . ">";
echo "<br>";
$Sscript = $_SERVER['SCRIPT_NAME'];
echo "Sscript = " . $_SERVER['SCRIPT_NAME'] . ">";
echo "<br>";
echo "Spath = " . rtrim(dirname($Sscript), '/\\') . ">";
echo "<br>";
// echo "BASE_URL = " . BASE_URL . ">";
// echo "<br>";
// echo "BASE_PATH = " . BASE_PATH . ">";
// echo "<br>";
echo "dirname(__FILE__) = " . dirname(__FILE__) . ">";
echo "<br>";
echo "dirname(__DIR__) = " . dirname(__DIR__);
?>

<!doctype html>
<html>
  <head>
    <title></title>
  </head>
  <body>
  </body>
</html>
