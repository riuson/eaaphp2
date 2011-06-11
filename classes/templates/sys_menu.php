<?php

/*
 * Menu template view.
 */

if (!class_exists("template_sys_menu")) {

	Class template_sys_menu Extends Template_Base {

		public function getView() {

			$items = $this->vars['items'];

			$result = "<nav><p>Menu</p>
		<ul>";
			foreach ($items as $item) {

				if ($item['current'])
					$result .= "<li>$item[title]</li>";
				else
					$result .= "<li><a href='$item[call]'>$item[title]</a></li>";
			}
			$result .= "</ul></nav>";

			return $result;
		}

	}

}
?>
