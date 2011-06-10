<?php

/*
 * Login form
 */
if (!function_exists('getContent')) {

	function getContent() {

		//print_r($_POST);

		if (isset($_POST["username"]))
			$username = $_POST["username"];
		else
			$username = "";

		if (isset($_POST["password"]))
			$password = $_POST["password"];
		else
			$password = "";

		$user = User::createUser();
		$user->login($username, $password);
		$loginSuccess = $user->isLogged();

		$loginFailedMsg = "";
		if (!empty($username) && !empty($password)) {

			if (!$loginSuccess)
				$loginFailedMsg = "Login failed, try again";
		}

		if (!$loginSuccess) {

			$result = "<p>User login</p>
<div class='login'>
	<form id='form_login'>
		<fieldset>
			<legend>Enter your login and password</legend>
			<div>
				<label for='username'>Login:</label>
				<input name='username' id='username' type='text' value='$username' autofocus required>
			</div>
			<div>
				<label for='password'>Password:</label>
				<input id='password' name='password' type='text' value='$password' required>
			</div>
			<div>
				<label>&nbsp;</label>
				<input type='submit' value='Send'>
			</div>
			<div class='login_error'>
				$loginFailedMsg
			</div>
		</fieldset>
	</form>
	<script>
		function bindContent()
		{
			$('#form_login').submit(function(){
					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						data: \"sys=login&username=\" + $(\"#username\").val() + \"&password=\" + $(\"#password\").val(),
						success: function(html){
							$(\"#content\").html(html);
							bindContent();
							updateStatus();

							$.ajax({
								type: \"POST\",
								url: \"backend.php\",
								cache: false,
								data: \"sys=menu&item=about\",
								success: function(html) {
									$(\"#menu\").html(html);
									$(\"#menu a\").bind(\"click\", updateMenu);
								}
							});
						}
					});
					return false;
				});
		}
	</script>
</div>";
		} else {

			$result = "<p>User login</p>
<div class='login'>Login as '$username' success.
</div>
	<script>
		function bindContent()
		{
		}
	</script>";
		}
		return $result;
	}

}
?>
