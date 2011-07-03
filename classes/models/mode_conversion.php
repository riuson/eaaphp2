<?php

/*
 * User account setup model.
 */
if (!class_exists("model_mode_conversion")) {

	Class model_mode_conversion Extends Model_Base {

		private $data;

		function prepare() {

			$this->data = array();
			//print_r($_POST);
			$this->data['resultCharacterId'] = "";
			$this->data['resultCharacterName'] = "";

			if (isset($_POST['characterId']) && !empty($_POST['characterId'])) {

				$this->data['characterId'] = $_POST['characterId'];
				if (preg_match("/^[\d]+$/", $_POST['characterId'])) {

					$api = new Api_Eve_CharacterName($this->registry);
					if ($api->getNames(array($this->data['characterId']), $names)) {

						if (!empty($names)) {
							$this->data['resultCharacterName'] = $names;
						}
					}
				}
			}
			else
				$this->data['characterId'] = "";

			if (isset($_POST['characterName']) && !empty($_POST['characterName'])) {

				$this->data['characterName'] = $_POST['characterName'];
				if (preg_match("/^[a-zA-Z\d\ \"\']+$/", $_POST['characterName'])) {

					$api = new Api_Eve_CharacterId($this->registry);
					if ($api->getIds(array($this->data['characterName']), $ids)) {

						if (!empty($ids)) {
							$this->data['resultCharacterId'] = $ids;
						}
					}
				}
			}
			else
				$this->data['characterName'] = "";
		}

		public function getData() {

			return $this->data;
		}

	}

}
?>
