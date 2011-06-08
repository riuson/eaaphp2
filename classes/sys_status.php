<?php

$modeTitle = "Status";

if (!function_exists('getContent')) {

	function getContent() {
		$d = date("H:i:s");
		$user = new User();
		if ($user->IsLogged())
			$userInfo = "Welcome, $username";
		else
			$userInfo = "Login";
		return "EVE server: Online, 28984 pilots<br/>Sun 5 Jun 2011 $d<br/><a href='login'>$userInfo</a>
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
			data: \"sys=login\",
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
