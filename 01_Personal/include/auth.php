<!-- auth.php — session guard
Put this at the very top of every protected page 
(e.g. dashboard.php, edit.php, admin.php): 
-->

<?php
// auth.php

if (empty($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}
?>