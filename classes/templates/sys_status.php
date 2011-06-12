<?php

/*
 * Status template view
 */
if (!class_exists("template_sys_status")) {

	Class template_sys_status Extends Template_Base {

		public function getView() {

			extract($this->vars['status']);
			if ($user_logged) {
				$user_info = "$user_name. <a href='$callback'>Logout</a>";
			} else {
				$user_info = "<a href='$callback'>Login</a>";
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
	function bindStatus()
	{
		$(\"#status a\").bind(\"click\", doStatus);
	}
	function doStatus()
	{
		$.ajax({
			type: \"POST\",
			url: \"backend.php\",
			cache: false,
			data: \"call=sys_$callback\",
			success: function(html) {
				$(\"#content\").html(html);
				bindContent();
			}
		});
		return false;
	}
</script>";
			return $result;
		}

	}

}
?>