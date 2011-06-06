<?php

class Page {

	public function __construct() {

	}

	public function getTitle() {
		return "Avalon Guards's EA Site";
	}

	public function getMenu() {
		return "
                        <p>Menu</p>
                        <ul>
                                <li><a href='about'>About</a></li>
                                <li class='disabled'>Visitors</li>
                                <li><a href='Api_Errors'>API Errors</a></li>
                                <li><a href='Api_FacWarTopStats'>Fractional wars</a></li>
                                <li><a href='Api_Conversion'>Names/Id conversion</a></li>
                        </ul>";
	}

	public function getScripts() {
		return "
				function updateStatus()
				{
					$.ajax({
						type: \"POST\",
						url: \"backend.php\",
						cache: false,
						data: \"mode=status\",
						success: function(html) {
							$(\"#status\").html(html);
							$(\"#status a\").bind(\"click\", updateStatus);
						}
					});
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

					$('#menu a').click(function()
					{
						loadContent($(this).attr('href'));
						return false;
					})
				});";
	}

	public function writeAll($template) {
		$result = str_replace("#title#", $this->getTitle(), $template);
		$result = str_replace("#menu#", $this->getMenu(), $result);
		$result = str_replace("#script#", $this->getScripts(), $result);
		echo $result;
	}

}
?>
