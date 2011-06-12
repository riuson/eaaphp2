<?php

/*
 * Success register message template view.
 */

if (!class_exists("template_sys_register_success")) {

	Class template_sys_register_success Extends Template_Base {

		public function getView() {

			extract($this->vars['data']);
			$result = "<p>User registration</p>
<div class='login'>
	Registration and login as '$username' success.
</div>
<script>
	function bindContent()
	{
		updateMenuDefault();
	}
</script>";
			return $result;
		}

	}

}
?>
