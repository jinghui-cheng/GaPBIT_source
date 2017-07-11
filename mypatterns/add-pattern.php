<?php
  $idToAdd = $_GET['id'];
  if (isset($idToAdd)) {
    include 'connect.php';
    include('../login/config.php');

    $sql = "INSERT INTO UserPatterns (Username, PatternID) VALUES ('$user->Username', '$idToAdd')";
    $result = $conn->query($sql);
    $conn->close();
  }

  header("Location: {$_SERVER['HTTP_REFERER']}");
?>
