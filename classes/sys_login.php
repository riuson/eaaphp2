<?php

/**
 * Login form
 *
 * @author vladimir
 */
if (!function_exists('getContent')) {

	function getContent() {
	 print_r($_POST);
		if (isset($_POST["username"]))
			$username = $_POST["username"];
		else
			$username = "";

		if (isset($_POST["password"]))
			$password = $_POST["password"];
		else
			$password = "";

		$user = User::CreateUser();
		$user->Login($username, $password);
		$loginSuccess = $user->IsLogged();

		$result = "<p>User login</p>
<div class='login'>
	<form id='form_login'>
		<fieldset>
			<legend>Enter your login and password</legend>
			<div class='fm-req'>
				<label for='username'>Login:</label>
				<input name='username' id='username' type='text' value='$username'/>
			</div>
			<div class='fm-opt'>
				<label for='password'>Password:</label>
				<input id='password' name='password' type='text' value='$password'/>
			</div>
			<div class='fm-opt'>
				<label>&nbsp;</label>
				<input type='submit' value='Send'>
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
						}
					});
					return false;
				});
		}
	</script>
</div>";
		return $result;
	}

}
?>
