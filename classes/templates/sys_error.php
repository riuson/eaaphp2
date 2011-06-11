<?php

/*
 * Error message template view.
 */

if (!class_exists("template_sys_error")) {

	Class template_sys_error Extends Template_Base {

		public function getView() {

			extract($this->vars);
			$result = "<p>Error</p>
Error 404. Page `$call` not found or invalid.
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
