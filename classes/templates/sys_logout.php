<?php

/*
 * Success (i hope :) logout message.
 */

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
			data: \"call=sys_menu&item=about\",
			success: function(html) {
				$(\"#menu\").html(html);
				$(\"#menu a\").bind(\"click\", updateMenu);
			}
		});
	}
</script>";
echo $result;
?>
