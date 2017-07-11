<?php
  include('./config.php');

  $username = $_POST['Username'];
  $password = $_POST['Password'];
  $password2 = $_POST['Password2'];

  //Process Registration
  if (count($_POST)) {
      /*
       * Covert POST into a Collection object
       * for better values handling
       */
      $input = new \ptejada\uFlex\Collection($_POST);

      /*
       * If the form fields names match your DB columns then you can reduce the collection
       * to only those expected fields using the filter() function
       */
      $input->filter('Username', 'first_name', 'last_name', 'Email', 'Password', 'Password2', 'website', 'GroupID');

      /*
       * Register the user
       * The register method takes either an array or a Collection
       */
      $user->register(array(
        'Username'  => $username,
        'Password'  => $password,
        'Password2' => $password2,
      ),false);

      if($user->log->hasError()){
    		$errMsg = $user->log->getErrors();
    		$errMsg = $errMsg[0];
        $_SESSION['errMsgSignup'] = $errMsg;
    	} else {
        $_SESSION['errMsgSignup'] = "none";
      }

      header("Location: {$_SERVER['HTTP_REFERER']}");
  }
?>
