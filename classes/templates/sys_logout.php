<?php

/*
 * Success (i hope :) logout message template view.
 */

if (!class_exists("template_sys_logout")) {

	Class template_sys_logout Extends Template_Base {

		public function getView() {

			extract($this->vars);
			$result = "<p>User logout</p>
<div class='login'>";

			if ($logoutSuccess) {
				$result .= "Logout success.";
			} else {
				$result .= "Logout failed o_O";
			}

			$result .= "</div>
<script>
	function bindContent()
	{
		updateStatus();
		updateMenuDefault();
	}
</script>";
			return $result;
		}

	}

}
?>
