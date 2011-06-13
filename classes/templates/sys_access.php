<?php

/*
 * Access settings template view.
 */

if (!class_exists("template_sys_access")) {

	Class template_sys_access Extends Template_Base {

		public function getView() {

			extract($this->vars);

			$usersListHtml = "<ul>";
			$count = count($users);
			$userLogin = "";

			if ($count > 0) {
				foreach ($users as $user) {

					if (!empty($selectedUser['login']) && $selectedUser['login'] != $user['login'])
						$usersListHtml .= "<li><a href='$user[login]'>$user[characterName] ($user[email])</a></li>";
					else
						$usersListHtml .= "<li>$user[characterName] ($user[email])</li>";
				}
				$userLogin = $selectedUser['login'];
			}
			$usersListHtml .= "</ul>";

			//print_r($limitedModes);
			$result = "<p>Access settings</p>
<div class='login'>
			<div class='left' id='users'>Slave users: $count<br>$usersListHtml</div>";

			if ($count > 0) {

				$result .= "
	<form id='form_login'>
		<fieldset>
			<legend>Select character and access rights</legend>";

				foreach ($limitedModes as $key => $value) {

					$checked = "";
					if (in_array($value, $selectedUser['access']))
						$checked = "checked";
					$result .= "<div>
					<input name='cb_$value' id='$value' type='checkbox' value='true' $checked>$key</input>
					</div>";
				}

				$result .= "
			<div>
				<input type='submit' value='Send'>
				<input type='reset' value='Reset'>
			</div>
			<div>
				$updateMessage
			</div>
		</fieldset>
	</form>";
			}
			$result .= "
	<script>
		function bindContent()
		{
			$('#users a').bind(\"click\", switchUser);
			$('#form_login').submit(function(){
				var aData = $(this).serializeArray();
				aData.push( { name: 'call', value: 'sys_access' } );
				aData.push( { name: 'submit', value: 'changes' } );
				aData.push( { name: 'selectedUser', value: '$userLogin' } );
				loadContentWithData(aData);
				return false;
			});
		}
		function switchUser()
		{
			var aData = {
				call: 'sys_access',
				selectedUser: $(this).attr('href')
			}
			loadContentWithData(aData);
			return false;
		}
	</script>
</div>";
			return $result;
		}

	}

}
?>
