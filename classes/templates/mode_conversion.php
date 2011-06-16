<?php

/*
 * Register template view.
 */

if (!class_exists("template_mode_conversion")) {

	Class template_mode_conversion Extends Template_Base {

		public function getView() {

			extract($this->vars['data']);
			//print_r($this->vars['data']);

			$ids = "";
			if (!empty($resultCharacterId)) {
				foreach ($resultCharacterId as $key => $value) {
					$ids .= "$key => $value<br>";
				}
			}
			$names = "";
			if (!empty($resultCharacterName)) {
				foreach ($resultCharacterName as $key => $value) {
					$names .= "$value => $key<br>";
				}
			}

			$result = "<p>Character Id/Name</p>
<div class='form_data'>
	<form id='form_data'>
		<fieldset>
			<legend>Enter characterId or characterName to search</legend>
			<div>
				<label for='characterId'>characterId:</label>
				<input name='characterId' id='characterId' type='text' value='$characterId'>
			</div>
			<div>
				<label for='characterName'>characterName:</label>
				<input id='characterName' name='characterName' type='text' value='$characterName'>
			</div>
			<div>
				<label>&nbsp;</label>
				<input type='submit' value='Submit'>
				<input type='reset' value='Reset'>
			</div>
			<div>
				$names
			</div>
			<div>
				$ids
			</div>
		</fieldset>
	</form>
	<script>
		function bindContent()
		{
			$('#form_data').submit(function(){
				var aData = {
					characterId:  $('#characterId').val(),
					characterName:  $('#characterName').val()
				}
				loadContent('mode_conversion', aData);
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
