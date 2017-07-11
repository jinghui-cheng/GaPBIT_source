<script src="js/jquery.js"></script>

<?php
	$active = "login";
	if ($_SESSION['errMsgSignup'] != "" && $_SESSION['errMsgSignup'] != "none") {
		$active = "signup";
	}
?>

<div id="login" class="<?php if ($active != "login") echo 'hidden';?>">
	<?php
		if ($_SESSION['errMsgSignup'] == "none") {
			echo '<div class="infomsg">Account successfully created!</div>';
			$_SESSION['errMsgSignup'] = "";
		}
	?>
	<form method="post" action="login/login.php">
		<h3>Please sign in</h3>
		<?php
			if ($_SESSION['errMsgLogin'] != "") {
				echo '<div class="errmsg">'.$_SESSION['errMsgLogin'].'</div>';
				$_SESSION['errMsgLogin'] = "";
			}
		?>

		<div class="form-group">
			<label for="inputUsername" class="sr-only">Username</label>
			<input type="text" id="inputUsername" class="form-control" placeholder="Username" name="Username" required autofocus>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="Password" required>
		</div>
		<button class="btn btn-primary btn-block" type="submit"><b>Sign in</b></button>
	</form>
	<hr />
	<p class="text-center">
		New to the system?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-default" id="btn-switch-signup">Create a new account</button>
	</p>
</div>

<div id="signup" class="<?php if ($active != "signup") echo 'hidden';?>">
	<form method="post" action="login/signup.php">
		<h3>Create account</h3>
		<?php
			if ($_SESSION['errMsgSignup'] != "") {
				echo '<div class="errmsg">'.$_SESSION['errMsgSignup'].'</div>';
				$_SESSION['errMsgSignup'] = "";
			}
		?>

		<div class="form-group">
			<label for="inputUsername" class="sr-only">Username</label>
			<input type="text" id="inputUsername" class="form-control" placeholder="Username" name="Username" required autofocus>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="Password" required>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="sr-only">Password again</label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Password again" name="Password2" required>
		</div>

		<button class="btn btn-primary btn-block" type="submit"><b>Create a new account</b></button>
	</form>
	<hr />
	<p class="text-center">
		Already have an account?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-default" id="btn-switch-login">Sign in</button>
	</p>
</div>

<script type="text/javascript">
	$('#btn-switch-signup').on('click', function(){
		$('#login').addClass('hidden');
		$('#signup').removeClass('hidden');
	});

	$('#btn-switch-login').on('click', function(){
		$('#signup').addClass('hidden');
		$('#login').removeClass('hidden');
	});
</script>
