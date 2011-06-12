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
				<input id='password' name='password' type='text' required>
			</div>
			<div>
				<label><a href='mode_register'>Registration</a></label>
				<input type='submit' value='Send'>
			</div>
			<div class='login_error'>
				$msg
			</div>
		</fieldset>
	</form>
	<script>
		function bindContent()
		{
			$(\"#form_login a\").bind(\"click\", doRegister);
			$('#form_login').submit(function(){
					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						data: \"call=sys_login&username=\" + $(\"#username\").val() + \"&password=\" + $(\"#password\").val(),
						success: function(html){
							$(\"#content\").html(html);
							bindContent();
							updateStatus();

							$.ajax({
								type: \"POST\",
								url: \"backend.php\",
								cache: false,
								data: \"call=sys_menu\",
								success: function(html) {
									$(\"#menu\").html(html);
									$(\"#menu a\").bind(\"click\", updateMenu);
								}
							});
						}
					});
					return false;
				});
				$.ajax({
					type: \"POST\",
					url: \"backend.php\",
					cache: false,
					data: \"call=sys_menu\",
					success: function(html) {
						$(\"#menu\").html(html);
						$(\"#menu a\").bind(\"click\", updateMenu);
					}
				});
		}
		function doRegister()
		{
			$.ajax({
				type: \"POST\",
				url: \"backend.php\",
				cache: false,
				data: \"call=sys_register\",
				success: function(html) {
					$(\"#content\").html(html);
					bindContent();
				}
			});
			return false;
		}
	</script>
</div>";
			return $result;
		}

	}

}
?>
