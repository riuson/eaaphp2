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

			$showTemplate = true;
			if (isset($_POST['sender']) && $_POST['sender'] == "datatables") {
				$showTemplate = false;
			}

			if (!$showTemplate) {
				$model = new model_mode_visitors($this->registry);
				$model->prepare();
				$this->registry['template']->set('jsonOutput', $model->getJsonOutput());
			}

			$this->registry['template']->set('showTemplate', $showTemplate);
			return $this->registry['template']->show('mode_visitors');
		}

	}

}
?>
