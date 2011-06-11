<?php

/*
 * Menu template view.
 */

if (!class_exists("template_sys_menu")) {

	Class template_sys_menu Extends Template_Base {

		public function getView() {

			extract($this->vars);
			$result = "<nav><p>Menu</p>
		<ul>";
			foreach ($modes as $key => $value) {
				$result .= "<li><a href='$value'>$key</a></li>";
			}
			$result .= "</ul></nav>";

			return $result;
		}

	}

}
?>
