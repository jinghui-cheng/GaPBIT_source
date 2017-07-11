<?php
  $idToRemove = $_GET['id'];
  if (isset($idToRemove)) {
    include 'connect.php';
    include('../login/config.php');

    $sql = "DELETE FROM UserPatterns WHERE Username='$user->Username' AND PatternID='$idToRemove'";
    $result = $conn->query($sql);
    $conn->close();
  }

  header("Location: {$_SERVER['HTTP_REFERER']}");
?>
