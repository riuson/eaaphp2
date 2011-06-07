<?php

/**
 * Store paths to directories
 *
 * @author riuson@gmail.com
 */
class Settings {

	public static function ClassesPath() {
		return "classes/";
	}

	public static function ConfigPath() {
		return "config/";
	}

	public static function ScriptsPath() {
		return "scripts/";
	}

	public static function StylesPath() {
		return "styles/";
	}

	public static function ConfigFileNameDb() {
		$result = Settings::ConfigPath() . "db_conf.php";
		if (!file_exists($result))
			$result = Settings::ConfigPath() . "db_conf_def.php";
		return $result;
	}

}
?>
