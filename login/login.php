<?php
  include('./config.php');

  $username = $_POST['Username'];
  $password = $_POST['Password'];

  $user->login($username,$password,'remember-me');

	$errMsg = '';

	if($user->log->hasError()){
		$errMsg = $user->log->getErrors();
		$errMsg = $errMsg[0];
    $_SESSION['errMsgLogin'] = $errMsg;
	}

  header("Location: {$_SERVER['HTTP_REFERER']}");
?>
