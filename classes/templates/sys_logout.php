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
		$.ajax({
			type: \"POST\",
			url: \"backend.php\",
			cache: false,
			data: \"call=sys_menu\",
			success: function(html) {
				$(\"#menu\").html(html);
				$(\"#menu a\").bind(\"click\", updateMenu);
			}
		});
	}
</script>";
			return $result;
		}

	}

}
?>
