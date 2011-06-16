<?php

/*
 * Success login message template view.
 */

if (!class_exists("template_sys_login_success")) {

	Class template_sys_login_success Extends Template_Base {

		public function getView() {

			extract($this->vars);
			$result = "<p>User login</p>
<div class='form_data'>
	Login as '$username' success.
</div>
<script>
	function bindContent()
	{
	}
</script>";
			return $result;
		}

	}

}
?>
