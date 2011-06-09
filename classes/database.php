<?php

/*
 * Class with database object
 */

//$db_link = mysql_connect($host, $user, $password);
//mysql_close($dblink);
class Database {

	private $db;
	private $errorMsg;

	public function __construct() {

		include Settings::ConfigFileNameDb();

		$count = 0;
		while ($count++ < 3) {
			$this->db = @new mysqli($db_host, $db_user, $db_password, $db_name);
			if (mysqli_connect_errno ()) {
				if ($retries == 1) {
					$this->errorMsg = 'Cannot connect db {$db_host} #' . mysqli_connect_errno() . ' ' . mysqli_connect_error();
				}
				$this->db = null;
			} else {
				$this->db->query("SET NAMES utf8");
				$this->db->query("SET CHARACTER SET utf8");
				$this->db->query("SET CHARACTER_SET_RESULTS=utf8");
				break;
			}
		}
		//echo "construct";
	}

	function __destruct() {

		if ($this->db != null) {

			$this->db->close();
			$this->db = null;
		}
		//echo "destruct";
	}

	public function isValid() {

		if ($this->db == null)
			return false;
		else
			return true;
	}

	public function escape($value) {

		return $this->db->real_escape_string($value);
	}

	function query($sqlQuery) {

		if (!trim($sqlQuery))
			return null;

		$result = $this->db->query($sqlQuery);
		//echo $sqlQuery;

		if (!$result) {

			$this->errorMsg = $this->db->error;
		}
		return $result;
	}

//http://web-tribe.net/one_news/518.html
	function rc4($keyString, $data) {
		include Settings::ConfigFileNameDb();
//ecncrypt $data with the key in $keyfile with an rc4 algorithm
//$pwd = implode('', file($keyfile));
		$pwd = $keyString . $rckey;
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
		$qr = $this->db->query($query);
		if ($row = $qr->fetch_assoc()) {
			if ($row["ip"] != $_SERVER["REMOTE_ADDR"] || $row["userAgent"] != $_SERVER["HTTP_USER_AGENT"]) {
				$query = sprintf("insert into api_visitors values ('%s', '%s', '%s', '%s');",
								$db->real_escape_string($recordId),
								$db->real_escape_string($strtime),
								$db->real_escape_string($_SERVER["REMOTE_ADDR"]),
								$db->real_escape_string($_SERVER["HTTP_USER_AGENT"]));
//echo ($query);
//print("<br/>$strtime");
				$this->db->query($query);
			}
		} else {
			$query = sprintf("insert into api_visitors values ('%s', '%s', '%s', '%s');",
							$db->real_escape_string($recordId),
							$db->real_escape_string($strtime),
							$db->real_escape_string($_SERVER["REMOTE_ADDR"]),
							$db->real_escape_string($_SERVER["HTTP_USER_AGENT"]));
//echo ($query);
//print("<br/>$strtime");
			$this->db->query($query);
		}
	}

}
?>
