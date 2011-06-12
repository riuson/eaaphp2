<?php

/*
 * Register template view.
 */

if (!class_exists("template_sys_register")) {

	Class template_sys_register Extends Template_Base {

		public function getView() {

			extract($this->vars['data']);
			//print_r($this->vars['data']);

			if (!$firstAttempt)
				$msg = "Registration failed, try again";
			else
				$msg = "";

			if ($apikeyOwner == "master")
				$initSwitch = "master";
			else
				$initSwitch = "slave";

			$result = "<p>User registration</p>
<div class='login'>
	<form id='form_login'>
		<fieldset>
			<legend>Enter your account data</legend>
			<div>
				<label for='username'>Login:</label>
				<input name='username' id='username' type='text' value='$username' autofocus required>
			</div>
			<div>
				<label for='password'>Password:</label>
				<input id='password' name='password' type='text' value='$password' required>
			</div>
			<div>
				<label for='email'>E-mail:</label>
				<input id='email' name='email' type='email' value='$email' required>
			</div>
			<div>
				<label for='characterName'>characterName:</label>
				<input id='characterName' name='characterName' type='text' value='$characterName' required>
			</div>
			<div>
				<label for='master'>&nbsp;</label>
				<input id='master' name='apikeyOwner' type='radio' value='master'>My ApiKey</input>
				<input id='slave' name='apikeyOwner' type='radio' value='slave'>ApiKey from master</input>
			</div>
			<div class='master'>
				<label for='userId'>userId:</label>
				<input id='userId' name='userId' type='number' value='$userId' required>
			</div>
			<div class='master'>
				<label for='apiKey'>ApiKey:</label>
				<input id='apiKey' name='apiKey' type='text' value='$apiKey' required>
			</div>
			<div class='master'>
				<label for='characterId'>characterId:</label>
				<input id='characterId' name='characterId' type='number' value='$characterId' required>
			</div>
			<div class='slave'>
				<label for='masterName'>Master name:</label>
				<input id='masterName' name='masterName' type='text' value='$masterName' required>
			</div>
			<div>
				<label>&nbsp;</label>
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
			$('#form_login').submit(function(){
				var aData = {
					call: 'sys_register',
					username:  $('#username').val(),
					password:  $('#password').val(),
					email:  $('#email').val(),
					characterName:  $('#characterName').val(),
					apikeyOwner:  $('input:radio[name=apikeyOwner]:checked').val(),
					userId:  $('#userId').val(),
					apiKey:  $('#apiKey').val(),
					characterId:  $('#characterId').val(),
					masterName:  $('#masterName').val()
				}
				$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						data: aData,
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
			$('#master').bind(\"click\", switchToMaster);
			$('#slave').bind(\"click\", switchToSlave);
			initSwitch();
		}
		function switchToMaster()
		{
			$('.slave').hide();
			$('.master').show();

			$('#masterName').attr('required', false);

			$('#userId').attr('required', true);
			$('#apiKey').attr('required', true);
			$('#characterId').attr('required', true);
		}
		function switchToSlave()
		{
			$('.master').hide();
			$('.slave').show();

			$('#userId').attr('required', false);
			$('#apiKey').attr('required', false);
			$('#characterId').attr('required', false);

			$('#masterName').attr('required', true);
		}
		function initSwitch()
		{
			var \$radios = $('input:radio[name=apikeyOwner]');
			if ('$initSwitch' == 'master')
			{
				\$radios.filter('[value=master]').attr('checked', true);
				switchToMaster();
			}
			else
			{
				\$radios.filter('[value=slave]').attr('checked', true);
				switchToSlave();
			}
		}
	</script>
</div>";
			return $result;
		}

	}

}
?>
