<?php

if ($user_logged) {
	$user_info = "$user_name. <a href='$callback'>Logout</a>";
} else {
	$user_info = "<a href='$callback'>Login</a>";
}

echo "
EVE Server: $server_online, $server_pilots pilot(s)<br>
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
?>