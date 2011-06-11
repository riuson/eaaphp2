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

			$page = 0;
			if (isset($_POST['page']) && is_numeric($_POST['page'])) {
				$page = $_POST['page'];
				$showTable = true;
			} else {
				$showTable = false;
			}

			$model = new model_mode_visitors($this->registry);
			$model->prepare($page);
			$this->registry['template']->set('log', $model->getLog());
			$this->registry['template']->set('page', $model->getPage());
			$this->registry['template']->set('start', $model->getStart());
			$this->registry['template']->set('total', $model->getTotal());

			$this->registry['template']->set('showTable', $showTable);
			return $this->registry['template']->show('mode_visitors');
		}

	}

}
?>
