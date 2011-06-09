<?php

include_once 'classes/page.php';
$template = "<!DOCTYPE html>
<html>
	<head>
		<title>#title#</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		<link media=\"screen\" rel=\"stylesheet\" href=\"styles/ea.css\" type=\"text/css\">
		<script type=\"text/javascript\" src=\"scripts/jquery-1.6.1.min.js\"></script>
	</head>
	<body>
		<div id=\"main\">
			<div id=\"header\"  class=\"header\">#title#</div>
			<div id=\"status\"  class=\"status\">#status#</div>
			<div id=\"menu\"    class=\"menu\">#menu#</div>
			<div id=\"content\" class=\"content\">#content#</div>
			<div id=\"footer\"  class=\"footer\">
				&copy; 2011 <a href=\"mailto:riuson(a)gmail(dot)com\">riuson</a>
			</div>
		</div>
		<script>#script#</script>
	</body>
</html>";

$p = new Page();
$p->writeAll($template);
?>