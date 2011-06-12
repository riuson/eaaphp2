<?php

/*
 * Access settings model.
 */
if (!class_exists("model_sys_access")) {

	Class model_sys_access Extends Model_Base {

		private $users;
		private $limitedModes;
		private $selectedUser;
		private $selectedModes;

		public function prepare() {

			$this->users = array();
			$this->limitedModes = array();
			$this->selectedModes = array();

			if ($this->registry['user']->getAccountData($data)) {

				$this->limitedModes = $this->registry['modes']->getLimitedModes();

				// get slave users info
				$master = $data['characterName'];
				$query = sprintf("select * from api_users where master = '%s';",
								$this->registry['db']->escape($master));

				//echo $query;
				$qr = $this->registry['db']->query($query);
				if ($qr) {

					while ($row = $qr->fetch_assoc()) {

						$sub = array("login" => $row['login'], "current" => false, "email" => $row['email'], "characterName" => $row['characterName']);

						$access = explode(",", $row['access']);
						$sub['access'] = $access;

						array_push($this->users, $sub);
					}
					$qr->close();
				}

				// check selected user
				if (isset($_POST['selectedUser']) && !empty($_POST['selectedUser']))
					$selectedUser = $_POST['selectedUser'];
				else
					$selectedUser = "";

				// default empty
				$this->selectedUser = array();
				foreach ($this->users as $userInfo) {

					// get first user as default
					if (count($this->selectedUser) == 0)
						$this->selectedUser = $userInfo;

					if ($userInfo['login'] == $selectedUser) {

						$this->selectedUser = $userInfo;
						break;
					}
				}
			}
			//print_r($this->selectedUser);
		}

		public function updateRights() {

			// print_r($_POST);
			$result = false;

			if (isset($_POST['selectedUser']) && !empty($_POST['selectedUser'])) {

				$selectedUser = $_POST['selectedUser'];

				// check: this user can update access rights to selected user
				if ($this->registry['user']->getAccountData($data)) {

					// get slave user info
					$master = $data['characterName'];
					$query = sprintf("select * from api_users where master = '%s' and login = '%s';",
									$this->registry['db']->escape($master),
									$this->registry['db']->escape($selectedUser));

					//echo $query;
					$accessRightsStr = "";
					$slaveAccountId = -1;

					// if user found with this login and master
					$qr = $this->registry['db']->query($query);
					if ($qr) {

						$row = $qr->fetch_assoc();
						if ($row) {

							$slaveAccountId = $row['accountId'];

							// get selected acces right from $_POST
							$rights = array();
							foreach ($_POST as $key => $value) {

								if ($value == true && preg_match("/(?<=cb_).+/", $key, $matches)) {

									array_push($rights, $matches[0]);
								}
							}
							$accessRightsStr = implode(",", $rights);
						}
						$qr->close();
					}

					// update access rights in db
					$query = sprintf("update api_users set access = '%s' where accountId = '%d';",
									$this->registry['db']->escape($accessRightsStr),
									$this->registry['db']->escape($slaveAccountId));

					$this->registry['db']->query($query);
					if ($this->registry['db']->getAffectedRows() == 1)
							$result = true;
				}
			}

			return $result;
		}

		public function getUsers() {

			return $this->users;
		}

		public function getLimitedModes() {

			return $this->limitedModes;
		}

		public function getSelectedUser() {

			return $this->selectedUser;
		}

	}

}
?>
