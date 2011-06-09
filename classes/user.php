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

	public function __construct() {
		$this->logged = false;
		$this->accountId = -1;
	}

	public static function CreateUser() {

		if (isset($_SESSION["User"])) {

			$userSaved = $_SESSION["User"];
			return $userSaved;
		} else {

			return new User();
		}
	}

	public function IsLogged() {
		return $this->logged;
	}

	public function UserName() {
		return $this->username;
	}

	public function Login($username, $password) {

		include Settings::ClassesPath() . "database.php";

		$result = false;
		$this->logged = false;
		$this->accountId = -1;
		$this->username = "Guest";
		$_SESSION["User"] = $this;

		if (!empty($username) && !is_array($username) && !empty($password) && !is_array($password)) {
			// connect db
			$db = new Database();

			if ($db->IsValid()) {

				// query for user
				$query = sprintf("select * from api_users where login = '%s' and password = md5('%s');",
								$db->escape($username),
								$db->escape($password));
				$qr = $db->query($query);

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

	public function SaveSession() {
		//$db = OpenDB2();
		//$query = sprintf("replace into api_sessions values ('%s', '%s', '%s', '%s', '%s');",
		//				GetUniqueId(),
		//				$db->real_escape_string(session_id()),
		//				$this->parameters["accountId"],
		//				$db->real_escape_string($_SERVER["REMOTE_ADDR"]),
		//				date("Y-m-d H:i:s", strtotime("+30 day")));
		//$db->query($query);
		//$db->close();
		setcookie(session_name(), session_id(), time() + 3600 * 24 * 30);
	}

	public function DestroySession($sessId) {
		//$db = OpenDB2();
		//$query = sprintf("delete from api_sessions where sessionId = '%s' and address = '%s';",
		//				$db->real_escape_string($sessId),
		//				$db->real_escape_string($_SERVER["REMOTE_ADDR"]));
		//$db->query($query);
		//$db->close();
	}

}
?>
