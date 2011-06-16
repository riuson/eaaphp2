<?php

/*
 * Register template view.
 */

if (!class_exists("template_sys_user")) {

	Class template_sys_user Extends Template_Base {

		public function getView() {

			extract($this->vars['data']);
			//print_r($this->vars['data']);

			$msg = "";
			if (!$firstAttempt) {
				if ($updateSuccess)
					$msg = "Account data changed";
				else
					$msg = "Account data not changed";
			}

			if ($apikeyOwner == "master") {
				$initSwitch = "master";
				$slavesLink = "<a href='sys_access'>Slave account's access settings</a>";
			}
			else {
				$initSwitch = "slave";
				$slavesLink = "";
			}

			$result = "<p>User account</p>
<div class='form_data'>
	<form id='form_data'>
		<fieldset>
			<legend>Enter your account data</legend>
			<div>
				<label for='login'>Login:</label>
				<input name='login' id='login' type='text' value='$login' disabled>
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
				<label for='masterMode'>&nbsp;</label>
				<input id='masterMode' name='apikeyOwner' type='radio' value='master'>My ApiKey</input>
				<input id='slaveMode' name='apikeyOwner' type='radio' value='slave'>ApiKey from master</input>
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
				<label for='master'>Master name:</label>
				<input id='master' name='master' type='text' value='$master' required>
			</div>
			<div>
				<label>&nbsp;</label>
				<input type='submit' value='Submit'>
				<input type='reset' value='Reset'>
			</div>
			<div class='form_data_error'>
				$msg
			</div>
			<div>
				$slavesLink
			</div>
		</fieldset>
	</form>
	<script>
		function bindContent()
		{
			$('#form_data a').bind('click', doSetupAccess);
			$('#form_data').submit(function(){
				var aData = {
					login:  $('#login').val(),
					password:  $('#password').val(),
					email:  $('#email').val(),
					characterName:  $('#characterName').val(),
					apikeyOwner:  $('input:radio[name=apikeyOwner]:checked').val(),
					userId:  $('#userId').val(),
					apiKey:  $('#apiKey').val(),
					characterId:  $('#characterId').val(),
					master:  $('#master').val()
				}
				loadContent('sys_user', aData);
				return false;
			});
			$('#masterMode').bind('click', switchToMaster);
			$('#slaveMode').bind('click', switchToSlave);
			initSwitch();
		}
		function switchToMaster()
		{
			$('.slave').hide();
			$('.master').show();

			$('#master').attr('required', false);

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

			$('#master').attr('required', true);
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
		function doSetupAccess()
		{
			loadContent('sys_access');
			return false;
		}
	</script>
</div>";
			return $result;
		}

	}

}
?>
