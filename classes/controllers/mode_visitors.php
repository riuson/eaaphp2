<?php

/*
 * Visitors list.
 */
if (!class_exists("controller_mode_visitors")) {

	Class controller_mode_visitors Extends Controller_Base {

		static function title() {
			return "Visitors list";
		}

		static function limited() {
			return true;
		}

		function process() {

			$model = new model_mode_visitors($this->registry);
			$model->prepare();

			$this->registry['template']->set('log', $model->getLog());
			return $this->registry['template']->show('mode_visitors');
		}

	}

}
?>
