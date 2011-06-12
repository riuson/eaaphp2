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

		function prepare() {

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
