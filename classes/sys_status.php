<?php

$modeTitle = "Status";

if (!function_exists('getContent')) {

	function getContent() {
		$d = date("H:i:s");
		$user = User::CreateUser();
		$username = $user->UserName();
		if ($user->IsLogged()) {

			$userInfo = "Welcome, $username. <a href='logout'>Logout</a>";
			$sys_callback = "logout";
		} else {

			$userInfo = "$username, <a href='login'>Login</a>";
			$sys_callback = "login";
		}
		return "EVE server: Online, 28984 pilots<br/>Sun 5 Jun 2011 $d<br/>$userInfo
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
			data: \"sys=$sys_callback\",
			success: function(html) {
				$(\"#content\").html(html);
				bindContent();
			}
		});
		return false;
	}
</script>";
	}

}
?>
