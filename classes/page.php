<?php

class Page {

	public function __construct() {

	}

	public function getStatus() {
		return "EVE server: Online, 28984 pilots<br/>Sun 5 Jun 2011 4:44:19";
	}

	public function getTitle() {
		return "Avalon Guards's EA Site";
	}

	public function getMenu() {
		return "
                        <p>Menu</p>
                        <ul>
                                <li class='disabled'>Visitors</li>
                                <li><a href='index.php?mode=Api_Errors'>API Errors</a></li>
                                <li><a href='index.php?mode=Api_FacWarTopStats'>Fractional wars</a></li>
                                <li><a href='index.php?mode=Api_Conversion'>Names/Id conversion</a></li>
                        </ul>";
	}

	public function getContent() {
		return "
				<p class='content_header'>About</p>
				<p>Used documentation:</p>
				<ul>
					<li><a href='http://myeve.eve-online.com/api/doc/default.asp'>EVE API Documentation Index</a></li>
					<li><a href='http://wiki.eve-id.net/'>EVE-Development Network</a></li>
					<li><a href='http://bughunters.addix.net/igbtest/IGB-commands.html'>EVE Ingame Webbrowser preliminary documentation</a></li>
					<li><a href='http://htmlbook.ru/'>HTML/CSS handbook</a></li>
				</ul>";
	}

	public function writeAll($template) {
		$result = str_replace("#title#", $this->getTitle(), $template);
		$result = str_replace("#status#", $this->getStatus(), $result);
		$result = str_replace("#menu#", $this->getMenu(), $result);
		$result = str_replace("#content#", $this->getContent(), $result);
		echo $result;
	}

}
?>
