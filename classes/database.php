<?php

/*
 * Class with database object
 */

class Database {

	private $db_link;
	private $errorMsg;
	private $affectedRows;

	public function __construct() {

		include Settings::ConfigFileNameDb();

		$count = 0;
		while ($count++ < 3) {
			$this->db_link = @new mysqli($db_host, $db_user, $db_password, $db_name);
			if (mysqli_connect_errno ()) {
				if ($retries == 1) {
					$this->errorMsg = 'Cannot connect db {$db_host} #' . mysqli_connect_errno() . ' ' . mysqli_connect_error();
					die($this->errorMsg);
				}
				$this->db_link = null;
			} else {
				$this->db_link->query("SET NAMES utf8");
				$this->db_link->query("SET CHARACTER SET utf8");
				$this->db_link->query("SET CHARACTER_SET_RESULTS=utf8");
				break;
			}
		}
	}

	function __destruct() {

		if ($this->db_link != null) {

			$this->db_link->close();
			$this->db_link = null;
		}
	}

	public function isValid() {

		if ($this->db_link == null)
			return false;
		else
			return true;
	}

	public function escape($value) {

		return $this->db_link->real_escape_string($value);
	}

	public function query($sqlQuery) {

		if (!trim($sqlQuery))
			return null;

		$result = $this->db_link->query($sqlQuery);
		$this->affectedRows = $this->db_link->affected_rows;
		//echo $sqlQuery;

		if (!$result) {

			$this->errorMsg = $this->db_link->error;
		}
		return $result;
	}

	public function getErrorMessage() {

		return $this->errorMsg;
	}

//http://web-tribe.net/one_news/518.html
	function rc4($data) {
		include Settings::ConfigFileNameDb();
//ecncrypt $data with the key in $keyfile with an rc4 algorithm
//$pwd = implode('', file($keyfile));
		$pwd = $dcapicode . $rckey;
		$pwd_length = strlen($pwd);
		$x = 0;
		$a = 0;
		$j = 0;
		$Zcrypt = "";
		for ($i = 0; $i < 256; $i++) {
			$key[$i] = ord(substr($pwd, ($i % $pwd_length) + 1, 1));
			$counter[$i] = $i;
		}
//print_r($counter);
		for ($i = 0; $i < 256; $i++) {
			$x = ($x + $counter[$i] + $key[$i]) % 256;
			$temp_swap = $counter[$i];
			$counter[$i] = $counter[$x];
			$counter[$x] = $temp_swap;
		}
		for ($i = 0; $i < strlen($data); $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $counter[$a]) % 256;
			$temp = $counter[$a];
			$counter[$a] = $counter[$j];
			$counter[$j] = $temp;
			$k = $counter[(($counter[$a] + $counter[$j]) % 256)];
			$Zcipher = ord(substr($data, $i, 1)) ^ $k;
			$Zcrypt .= chr($Zcipher);
		}
		return $Zcrypt;
	}

	function logVisitor() {
		$recordId = "1";
		date_default_timezone_set("Etc/Universal");
		$t = time(); // - $t;
		$strtime = date("Y-m-d H:i:s", $t);
//check for last user
		$query = "select * from api_visitors where _date_ in (select max(_date_) from api_visitors);";
		$qr = $this->db_link->query($query);
		if ($row = $qr->fetch_assoc()) {
			if ($row["ip"] != $_SERVER["REMOTE_ADDR"] || $row["userAgent"] != $_SERVER["HTTP_USER_AGENT"]) {
				$query = sprintf("insert into api_visitors values ('%s', '%s', '%s', '%s');",
								$db->real_escape_string($recordId),
								$db->real_escape_string($strtime),
								$db->real_escape_string($_SERVER["REMOTE_ADDR"]),
								$db->real_escape_string($_SERVER["HTTP_USER_AGENT"]));
				$this->db_link->query($query);
			}
		} else {
			$query = sprintf("insert into api_visitors values ('%s', '%s', '%s', '%s');",
							$db->real_escape_string($recordId),
							$db->real_escape_string($strtime),
							$db->real_escape_string($_SERVER["REMOTE_ADDR"]),
							$db->real_escape_string($_SERVER["HTTP_USER_AGENT"]));
			$this->db_link->query($query);
		}
	}

	public function getAffectedRows() {
	 return $this->affectedRows;
	}

}
?>
