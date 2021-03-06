<?php

/**
 * Handle login, access rights, cookies.
 *
 * @author vladimir
 */
class User {

	private $accountId;
	private $logged;
	private $username;
	private $registry;

	public function __construct($registry) {
		$this->logged = false;
		$this->accountId = -1;
		$this->registry = $registry;
	}

	public static function createUser($registry) {

		if (isset($_SESSION["User"])) {

			$userSaved = $_SESSION["User"];
			$userSaved->registry = $registry;
			return $userSaved;
		} else {

			return new User($registry);
		}
	}

	public function isLogged() {
		return $this->logged;
	}

	public function getAccountId() {
		return $this->accountId;
	}

	public function userName() {
		return $this->username;
	}

	public function login($username, $password) {

		$result = false;
		$this->logged = false;
		$this->accountId = -1;
		$this->username = "";
		$_SESSION["User"] = $this;

		if (!empty($username) && !empty($password)) {
			// connect db

			if ($this->registry['db']->isValid()) {

				// query for user
				$query = sprintf("select * from api_users where login = '%s' and password = md5('%s');",
								$this->registry['db']->escape($username),
								$this->registry['db']->escape($password));
				$qr = $this->registry['db']->query($query);

				// if user exists
				if ($qr != null && $qr->num_rows == 1) {

					$row = $qr->fetch_assoc();

					$this->logged = true;
					$this->accountId = $row["accountId"];
					$this->username = $username;
					$_SESSION["User"] = $this;
				}
			}
		}
		return $result;
	}

	public function register($username, $password, $email, $characterName, $apikeyOwner, $userId, $apiKey, $characterId, $masterName) {

		$result = false;
		if (!empty($username) && !empty($password) && !empty($email) && !empty($apikeyOwner)) {

			if ($apikeyOwner == "master") {

				if (!empty($characterName) && !empty($userId) && is_numeric($userId) && !empty($apiKey) && !empty($characterId) && is_numeric($characterId)) {

					$query = sprintf(
									"insert into api_users " .
									"(login, password, email, userId, apiKey, characterId, characterName)" .
									"values ('%s', md5('%s'), '%s', '%d', '%s', '%d', '%s')",
									$this->registry['db']->escape($username),
									$this->registry['db']->escape($password),
									$this->registry['db']->escape($email),
									$this->registry['db']->escape($userId),
									$this->registry['db']->escape(base64_encode($this->registry['db']->rc4($apiKey))),
									$this->registry['db']->escape($characterId),
									$this->registry['db']->escape($characterName)
					);
					//echo $query;
					$this->registry['db']->query($query);
					if ($this->registry['db']->getAffectedRows() == 1)
						$result = true;
				}
			} else if ($apikeyOwner == "slave") {

				if (!empty($masterName)) {

					$query = sprintf(
									"insert into api_users " .
									"(login, password, email, master, characterName, userId, characterId)" .
									"values ('%s', md5('%s'), '%s', '%s', '%s', 0, 0)",
									$this->registry['db']->escape($username),
									$this->registry['db']->escape($password),
									$this->registry['db']->escape($email),
									$this->registry['db']->escape($masterName),
									$this->registry['db']->escape($characterName)
					);
					//echo $query;
					$this->registry['db']->query($query);
					if ($this->registry['db']->getAffectedRows() == 1)
						$result = true;
				}
			}
		}
		return $result;
	}

	public function modify($password, $email, $characterName, $apikeyOwner, $userId, $apiKey, $characterId, $masterName) {

		$result = false;
		if ($this->accountId > 0 && $this->isLogged() && !empty($password) && !empty($email) && !empty($apikeyOwner)) {

			if ($apikeyOwner == "master") {

				if (!empty($characterName) && !empty($userId) && is_numeric($userId) && !empty($apiKey) && !empty($characterId) && is_numeric($characterId)) {

					$modes = array();
					foreach ($this->registry['modes']->getLimitedModes() as $key => $value) {
						array_push($modes, $value);
					}
					$query = sprintf(
									"update api_users set " .
									"password = md5('%s'), email = '%s', userId = %d, apiKey = '%s', characterId = %d, characterName = '%s', master = '', access = '%s' " .
									"where accountId = %d;",
									$this->registry['db']->escape($password),
									$this->registry['db']->escape($email),
									$this->registry['db']->escape($userId),
									$this->registry['db']->escape(base64_encode($this->registry['db']->rc4($apiKey))),
									$this->registry['db']->escape($characterId),
									$this->registry['db']->escape($characterName),
									$this->registry['db']->escape(implode(",", $modes)),
									$this->registry['db']->escape($this->accountId)
					);
					//echo $query;
					$this->registry['db']->query($query);
					if ($this->registry['db']->getAffectedRows() == 1)
						$result = true;
				}
			} else if ($apikeyOwner == "slave") {

				if (!empty($masterName)) {

					$query = sprintf(
									"update api_users set " .
									"password = md5('%s'), email = '%s', master = '%s', characterName = '%s', userId = 0, characterId = 0, access = '' " .
									"where accountId = %d;",
									$this->registry['db']->escape($password),
									$this->registry['db']->escape($email),
									$this->registry['db']->escape($masterName),
									$this->registry['db']->escape($characterName),
									$this->registry['db']->escape($this->accountId)
					);
					//echo $query;
					$this->registry['db']->query($query);
					if ($this->registry['db']->getAffectedRows() == 1)
						$result = true;
				}
			}
		}
		return $result;
	}

	public function logout() {
		$result = false;
		$this->logged = false;
		$this->accountId = -1;
		$this->username = "";
		$_SESSION["User"] = $this;
	}

	function logVisitor() {

		// check for last user
		$query = "SELECT * FROM api_visitors WHERE recordId = (SELECT max( recordId ) FROM api_visitors );";
		$qr = $this->registry['db']->query($query);
		if ($qr) {

			$row = $qr->fetch_assoc();
			if ($row) {

				if ($row["address"] != $_SERVER["REMOTE_ADDR"] || $row["agent"] != $_SERVER["HTTP_USER_AGENT"]) {

					$this->registry['db']->query(sprintf(
									"insert into api_visitors set _date_ = '%s', address = '%s', agent = '%s', login = '%s', uri = '%s';",
									date("Y-m-d H:i:s", time()),
									$this->registry['db']->escape($_SERVER["REMOTE_ADDR"]),
									$this->registry['db']->escape($_SERVER["HTTP_USER_AGENT"]),
									$this->registry['db']->escape($this->username),
									$this->registry['db']->escape($_SERVER["REQUEST_URI"])));
				}
			} else {

				$this->registry['db']->query(sprintf(
								"insert into api_visitors set _date_ = '%s', address = '%s', agent = '%s', login = '%s', uri = '%s';",
								date("Y-m-d H:i:s", time()),
								$this->registry['db']->escape($_SERVER["REMOTE_ADDR"]),
								$this->registry['db']->escape($_SERVER["HTTP_USER_AGENT"]),
								$this->registry['db']->escape($this->username),
								$this->registry['db']->escape($_SERVER["REQUEST_URI"])));
			}
		}
	}

	public function filterAvailableModes($sourceModes) {

		$result = array();
		if ($this->isLogged()) {
			$qr = $this->registry['db']->query(sprintf("select access from api_users where accountId = '%d'",
									$this->registry['db']->escape($this->accountId)));
			$row = $qr->fetch_assoc();
			if ($row) {

				// get access lsit from DB and split by comma
				$accessString = $row["access"];
				$accessList = explode(",", $accessString);

				// check for each assigned access
				foreach ($sourceModes as $key => $value) {
					//$result = array_intersect($accessList, $sourceModes);
					if (in_array($value, $accessList)) {
						$result[$key] = $value;
					}
				}
			}
		}
		return $result;
	}

	public function getAccountData(&$data) {

		$result = false;
		$data = array();
		if ($this->isLogged()) {
			$qr = $this->registry['db']->query(sprintf("select * from api_users where accountId = '%d'",
									$this->registry['db']->escape($this->accountId)));
			$row = $qr->fetch_assoc();
			if ($row) {

				// get access lsit from DB and split by comma
				$data = $row;
				$result = true;
			}
		}
		return $result;
	}

	public function getMasterData(&$data) {

		$result = false;

		if ($this->getAccountData($data)) {

			if (!empty($data['master'])) {

				$qr = $this->registry['db']->query(sprintf("select * from api_users where characterName = '%s'",
										$this->registry['db']->escape($data['master'])));
				$row = $qr->fetch_assoc();
				if ($row) {

					// get access lsit from DB and split by comma
					$data['accountId'] = $row['accountId'];
					$data['password'] = $row['password'];
					$data['userId'] = $row['userId'];
					$data['apiKey'] = $row['apiKey'];
					$data['apiKey'] = $this->registry['db']->rc4(base64_decode($data['apiKey']));
					$data['characterId'] = $row['characterId'];
					$result = true;
				}
			} else {

				$data['apiKey'] = $this->registry['db']->rc4(base64_decode($data['apiKey']));
			}
		}
		return $result;
	}

	public function saveSession() {
		//$db = OpenDB2();
		//$query = sprintf("replace into api_sessions values ('%s', '%s', '%s', '%s', '%s');",
		//				GetUniqueId(),
		//				$db->real_escape_string(session_id()),
		//				$this->parameters["accountId"],
		//				$db->real_escape_string($_SERVER["REMOTE_ADDR"]),
		//				date("Y-m-d H:i:s", strtotime("+30 day")));
		//$db->query($query);
		//$db->close();
		//setcookie(session_name(), session_id(), time() + 3600 * 24 * 30);
	}

	public function destroySession($sessId) {
		//$db = OpenDB2();
		//$query = sprintf("delete from api_sessions where sessionId = '%s' and address = '%s';",
		//				$db->real_escape_string($sessId),
		//				$db->real_escape_string($_SERVER["REMOTE_ADDR"]));
		//$db->query($query);
		//$db->close();
	}

}
?>
