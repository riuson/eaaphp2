<?php

/*
 * Corp AccountBalance.
 * Returns the ISK balance of a corporation.
 * http://wiki.eve-id.net/APIv2_Corp_AccountBalance_XML
 * http://api.eve-online.com/corp/AccountBalance.xml.aspx
 *
 * $api = new Api_Corp_Account_Balance($this->registry, $this->registry['user']);
 * $api->getBalance($info);
 * print_r($info);
 */

class Api_Corp_Account_Balance Extends Api_Base {

	public function getBalance(&$info) {

		$result = false;
		$info = array();

		$this->registry['user']->getMasterData($userData);
		$this->commonMethod = false;

		$params = array();
		$params['version'] = '2';
		$params['userID'] = $userData['userId'];
		$params['apiKey'] = $userData['apiKey'];
		$params['characterID'] = $userData['characterId'];


		if ($this->request("/corp/AccountBalance.xml.aspx", $params)) {

			// xpath navigation
			$domPath = new DOMXPath($this->document);

			$nodes = $domPath->query("/eveapi/result/rowset[@name='accounts']/row");

			foreach ($nodes as $node) {

				$accountId = $node->getAttribute("accountID");
				$accountKey = $node->getAttribute("accountKey");
				$balance = $node->getAttribute("balance");

				$divisionData = array("accountId" => $accountId, "balance" => $balance);
				$info[$accountKey] = $divisionData;
			}

			if (count($info) == 7)
				$result = true;
		}

		return $result;
	}

}
?>
