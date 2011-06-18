<?php

/*
 * Alliance list.
 */
if (!class_exists("controller_mode_eve_alliance_list")) {

	Class controller_mode_eve_alliance_list Extends Controller_Base {

		static function title() {
			return "Alliance list";
		}

		static function limited() {
			return false;
		}

		function loginRequired() {
			return false;
		}

		function process() {

			if (isset($_POST['sender']) && $_POST['sender'] == "datatables") {

				$model = new model_mode_eve_alliance_list($this->registry);
				$model->prepareDataTable();
				$this->registry['template']->set('show', 'datatable');
				$this->registry['template']->set('jsonOutput', $model->getJsonOutput());
			} else {

				$this->registry['template']->set('show', 'template');
			}
			return $this->registry['template']->show('mode_eve_alliance_list');
		}

	}

}
?>
