<?php

/*
 * Conversion between characterId and characterName.
 */

if (!class_exists("controller_mode_conversion")) {

	Class controller_mode_conversion Extends Controller_Base {

		static function title() {
			return "Character Id/Name";
		}

		static function limited() {
			return false;
		}

		function loginRequired() {
			return false;
		}

		function process() {

			//print_r($_POST);
			$model = new model_mode_conversion($this->registry);
			$model->prepare();
			$data = $model->getData();

			$this->registry['template']->set('data', $data);

			$result = $this->registry['template']->show('mode_conversion');

			return $result;
		}

	}
}
?>
