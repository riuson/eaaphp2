<?php

/*
 * Menu model.
 */
if (!class_exists("model_sys_menu")) {

	Class model_sys_menu Extends Model_Base {

		private $items;

		function prepare() {

			$this->items = array();

			$modes = $this->registry['modes'];
			$availableModes = $modes->getAvailableModes();

			if (isset($_POST['item']) && !empty($_POST['item'])) {
				$item = $_POST['item'];
			} else {
				$item = "sys_about";
			}

			foreach ($availableModes as $key => $value) {

				if ($value == $item) {
					$sub = array("title" => $key, "call" => $value, "current" => true);
				} else  {
					$sub = array("title" => $key, "call" => $value, "current" => false);
				}
				array_push($this->items, $sub);
			}
		}

		public function getItems() {

			return $this->items;
		}

	}

}
?>
