<?php

class Page {

	public function __construct() {

	}

	public function getTitle() {
		return "Avalon Guards's EA Site";
	}

	public function getScripts() {
		return "
				function updateStatus()
				{
					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						cache: false,
						data: \"sys=status\",
						success: function(html) {
							$(\"#status\").html(html);
							$(\"#status a\").bind(\"click\", updateStatus);
							bindStatus();
						}
					});
					return false;
				}
				function updateMenu()
				{
					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						cache: false,
						data: \"sys=menu&item=\" + $(this).attr('href'),
						success: function(html) {
							$(\"#menu\").html(html);
							$(\"#menu a\").bind(\"click\", updateMenu);
						}
					});
					loadContent($(this).attr('href'));
					return false;
				}
				function loadContent(modeName)
				{
					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						cache: false,
						data: \"mode=\" + modeName,
						success: function(html) {
							$(\"#content\").html(html);
						}
					});
					return false;
				}

				$(document).ready(function() {
				
					updateStatus();
					loadContent('about');

					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						cache: false,
						data: \"sys=menu&item=about\",
						success: function(html) {
							$(\"#menu\").html(html);
							$(\"#menu a\").bind(\"click\", updateMenu);
						}
					});

				});";
	}

	public function writeAll($template) {
		$result = str_replace("#title#", $this->getTitle(), $template);
		$result = str_replace("#script#", $this->getScripts(), $result);
		echo $result;
	}

}
?>
