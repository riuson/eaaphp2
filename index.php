<!DOCTYPE html>
<html>
	<head>
		<title>Avalon Guards's EA Site</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="Content-Language" content="en">
		<meta name="GENERATOR" content="NetBeans 6.9">
		<link media="screen" rel="stylesheet" href="styles/ea.css">
		<link rel="shortcut icon" href="favicon.ico">
		<script type="text/javascript" src="scripts/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.dataTables.js"></script>
		<script type="text/javascript" src="scripts/jquery.dataTables.columnFilter.js"></script>
	</head>
	<body>
		<div id="main">
			<div id="header"  class="header">Avalon Guards's EA Site</div>
			<div id="status"  class="status">#status#</div>
			<div id="menu"    class="menu">#menu#</div>
			<div id="content" class="content">#content#</div>
			<div id="footer"  class="footer">
				&copy; 2011 <a href="mailto:riuson(a)gmail(dot)com">riuson</a>
			</div>
		</div>
		<script type="text/javascript" >
function updateStatus()
{
	$.ajax({
		type: "POST",
		url: "backend.php",
		cache: false,
		data: "call=sys_status",
		success: function(html) {
			$("#status").html(html);
		}
	});
	return false;
}
function loadContent(modeName, params)
{
	var aData = {
		call: modeName
	}
	if (typeof params == 'object')
	{
		aData = params;
		aData['call'] = modeName;
	}
	$.ajax({
		type: "POST",
		url: "backend.php",
		cache: false,
		data: aData,
		success: function(html) {
			$("#content").html(html);
			bindContent();
			loadMenu(modeName);
			updateStatus();
			//alert('loaded: ' + modeName);
		}
	});
	return false;
}
function loadMenu(modeName)
{
	$.ajax({
		type: "POST",
		url: "backend.php",
		cache: false,
		data: "call=sys_menu&item=" + modeName,
		success: function(html) {
			$("#menu").html(html);
		}
	});
	return false;
}

$(document).ready(function() {

	// bind menu calls
	$('#menu a').live('click', function()
	{
		loadContent($(this).attr('href'));
		return false;
	});
	// bind status calls
	$('#status a').live('click', function()
	{
		loadContent($(this).attr('href'));
		return false;
	});

	loadContent('mode_about');
});
		</script>
	</body>
</html>
