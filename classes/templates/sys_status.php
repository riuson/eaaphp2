<?php

/*
 * Status template view
 */
if (!class_exists("template_sys_status")) {

	Class template_sys_status Extends Template_Base {

		public function getView() {

			extract($this->vars['status']);
			if ($user_logged) {
				$user_info = "<a href='sys_logout'>Logout</a> [ <a href='sys_user'>$user_name<a/> ]";
			} else {
				$user_info = "<a href='sys_login'>Login</a>";
			}

			if (($server_pilots % 10) == 1)
				$suffix = "";
			else
				$suffix = "s";

			if ($server_online)
				$server_online = "Online";
			else
				$server_online = "Offline";

			$result = "
EVE Server: $server_online, $server_pilots pilot$suffix<br>
$server_time<br>
$user_info
<script>
</script>";
			return $result;
		}

	}

}
?>