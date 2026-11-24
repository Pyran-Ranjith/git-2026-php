
<?php
// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['currentuser']['username'])) {
if (isset($_SESSION['currentuser']['username']) && $_SESSION['currentuser']['username']) {
  $currentuser =  htmlspecialchars($_SESSION['currentuser']['username']);
  $userid   = $_SESSION['currentuser']['user_id'];
  $username = $currentuser;
} else {
  $currentuser = 'User';
  header("Location: login.php");
  exit();
}
?>
