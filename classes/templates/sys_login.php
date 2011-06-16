<?php

/*
 * Login template view.
 */

if (!class_exists("template_sys_login")) {

	Class template_sys_login Extends Template_Base {

		public function getView() {

			extract($this->vars);
			if ($loginFailed)
				$msg = "Login failed, try again";
			else
				$msg = "";

			$result = "<p>User login</p>
<div class='form_data'>
	<form id='form_data'>
		<fieldset>
			<legend>Enter your login and password</legend>
			<div>
				<label for='username'>Login:</label>
				<input name='username' id='username' type='text' value='$username' autofocus required>
			</div>
			<div>
				<label for='password'>Password:</label>
				<input id='password' name='password' type='text' required>
			</div>
			<div>
				<label><a href='mode_register'>Registration</a></label>
				<input type='submit' value='Send'>
			</div>
			<div class='form_data_error'>
				$msg
			</div>
		</fieldset>
	</form>
	<script>
		function bindContent()
		{
			$('#form_data a').bind('click', function() {
				loadContent('sys_register');
				return false;
			});
			$('#form_data').submit(function(){
				var aData = {
					username: $('#username').val(),
					password: $('#password').val()
				}
				loadContent('sys_login', aData);
				return false;
			});
		}
	</script>
</div>";
			return $result;
		}

	}

}
?>
