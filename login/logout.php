<?php
  include('./config.php');
  $user->logout();
  header("Location: {$_SERVER['HTTP_REFERER']}");
?>
