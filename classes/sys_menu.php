<?php

if (!function_exists('getContent')) {

	function getContent() {
		$result = "bad request";

		if (isset($_POST["item"]) && !empty($_POST["item"])) {
			$item = $_POST["item"];
			if (preg_match("/^[a-z]+$/", $item) > 0 && strlen($item) <= 20) {
				// list of mode's files (mode_*.php)
				$modes = array();
				foreach (glob(Settings::ClassesPath() . "mode_*.php") as $filename) {
					array_push($modes, $filename);
				}

				// build menu from mode_*.php files
				// href is mode name, text is mode title
				$result = "<p>Menu</p>
		<ul>";
				foreach ($modes as $filename) {
					include_once "$filename";
					//$title = "$filename";//getModeTitle();
					$title = $modeTitle;

					preg_match('/(?<=mode_).+(?=\.php)/i', $filename, $matches);
					$mode = $matches[0];

					$result .= "<li><a href='$mode'>$title</a></li>";
				}
				$result .= "</ul>";
			}
		}
		return $result;
	}

}
?>