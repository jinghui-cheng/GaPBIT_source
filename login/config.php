<?php
  include('uFlex/autoload.php');

  //Instantiate the User object
  $user = new ptejada\uFlex\User();

  // Add database credentials
  $user->config->database->host = 'localhost';
  $user->config->database->user = 'root';
  $user->config->database->password = 'mysql';
  $user->config->database->name = 'users';

  //Start object construction
  $user->start();
?>
