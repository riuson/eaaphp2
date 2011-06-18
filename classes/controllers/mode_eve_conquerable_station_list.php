<?php

/*
 * Visitors list.
 */
if (!class_exists("controller_mode_eve_conquerable_station_list")) {

	Class controller_mode_eve_conquerable_station_list Extends Controller_Base {

		static function title() {
			return "Conquerable stations";
		}

		static function limited() {
			return false;
		}

		function loginRequired() {
			return false;
		}

		function process() {

			if (isset($_POST['sender']) && $_POST['sender'] == "datatables") {

				$model = new model_mode_eve_conquerable_station_list($this->registry);
				$model->prepareDataTable();
				$this->registry['template']->set('show', 'datatable');
				$this->registry['template']->set('jsonOutput', $model->getJsonOutput());
			} else if (isset($_POST['corporationId']) && is_numeric ($_POST['corporationId'])) {

				$model = new model_mode_eve_conquerable_station_list($this->registry);
				$model->prepareCorpInfo($_POST['corporationId']);
				$this->registry['template']->set('show', 'corpinfo');
				$this->registry['template']->set('corpInfo', $model->getCorpInfo());
			} else {

				$this->registry['template']->set('show', 'template');
			}
			return $this->registry['template']->show('mode_eve_conquerable_station_list');
		}

	}

}
?>
