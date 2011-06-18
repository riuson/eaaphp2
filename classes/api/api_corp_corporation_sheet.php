<?php

/*
 * Corp CorporationSheet.
 * Returns attributes relating to a specific corporation.
 * http://wiki.eve-id.net/APIv2_Corp_CorporationSheet_XML
 * http://api.eve-online.com/corp/CorporationSheet.xml.aspx
 *
 * $api = new Api_Server_Status($registry, $user);
 * $api->getStatus($serverOpen, $onlinePlayers);
 * echo $serverOpen . " " . $onlinePlayers;
 *
 */

class Api_Corp_Corporation_Sheet Extends Api_Base {

	public function getCorporationInfo($corporationId, &$commonInfo) {

		$result = false;
		$commonInfo = array();

		$params = array();
		$params["version"] = "2";
		$params["corporationID"] = $corporationId;


		if ($this->request("/corp/CorporationSheet.xml.aspx", $params)) {

			// xpath navigation
			$domPath = new DOMXPath($this->document);
			// corporationID
			$value = $domPath->query("descendant::corporationID")->item(0);
			$commonInfo["corporationId"] = $value->nodeValue;

			$value = $domPath->query("descendant::corporationName")->item(0);
			$commonInfo["corporationName"] = $value->nodeValue;

			$value = $domPath->query("descendant::ticker")->item(0);
			$commonInfo["ticker"] = $value->nodeValue;

			$value = $domPath->query("descendant::ceoID")->item(0);
			$commonInfo["ceoId"] = $value->nodeValue;

			$value = $domPath->query("descendant::ceoName")->item(0);
			$commonInfo["ceoName"] = $value->nodeValue;

			$value = $domPath->query("descendant::stationID")->item(0);
			$commonInfo["stationId"] = $value->nodeValue;

			$value = $domPath->query("descendant::stationName")->item(0);
			$commonInfo["stationName"] = $value->nodeValue;

			$value = $domPath->query("descendant::description")->item(0);
			$commonInfo["description"] = $value->nodeValue;

			$value = $domPath->query("descendant::url")->item(0);
			$commonInfo["url"] = $value->nodeValue;

			$value = $domPath->query("descendant::allianceID")->item(0);
			$commonInfo["allianceId"] = $value->nodeValue;

			$value = $domPath->query("descendant::allianceName")->item(0);
			$commonInfo["allianceName"] = $value->nodeValue;

			$value = $domPath->query("descendant::taxRate")->item(0);
			$commonInfo["taxRate"] = $value->nodeValue;

			$value = $domPath->query("descendant::memberCount")->item(0);
			$commonInfo["memberCount"] = $value->nodeValue;

			$value = $domPath->query("descendant::memberLimit")->item(0);
			if ($value != null)
				$commonInfo["memberLimit"] = $value->nodeValue;
			else
				$commonInfo["memberLimit"] = "?";
			$value = $domPath->query("descendant::shares")->item(0);
			$commonInfo["shares"] = $value->nodeValue;
		}

		return $result;
	}

	public function getCorporationInfoPrivate(&$commonInfo, &$divisions, &$walletDivisions) {

		$result = false;
		$commonInfo = array();
		$divisions = array();
		$walletDivisions = array();

		$this->registry['user']->getMasterData($userData);
		$this->commonMethod = false;

		$params = array();
		$params['version'] = '2';
		$params['userID'] = $userData['userId'];
		$params['apiKey'] = $userData['apiKey'];
		$params['characterID'] = $userData['characterId'];


		if ($this->request("/corp/CorporationSheet.xml.aspx", $params)) {

			// xpath navigation
			$domPath = new DOMXPath($this->document);
			// corporationID
			$value = $domPath->query("descendant::corporationID")->item(0);
			$commonInfo["corporationId"] = $value->nodeValue;

			$value = $domPath->query("descendant::corporationName")->item(0);
			$commonInfo["corporationName"] = $value->nodeValue;

			$value = $domPath->query("descendant::ticker")->item(0);
			$commonInfo["ticker"] = $value->nodeValue;

			$value = $domPath->query("descendant::ceoID")->item(0);
			$commonInfo["ceoId"] = $value->nodeValue;

			$value = $domPath->query("descendant::ceoName")->item(0);
			$commonInfo["ceoName"] = $value->nodeValue;

			$value = $domPath->query("descendant::stationID")->item(0);
			$commonInfo["stationId"] = $value->nodeValue;

			$value = $domPath->query("descendant::stationName")->item(0);
			$commonInfo["stationName"] = $value->nodeValue;

			$value = $domPath->query("descendant::description")->item(0);
			$commonInfo["description"] = $value->nodeValue;

			$value = $domPath->query("descendant::url")->item(0);
			$commonInfo["url"] = $value->nodeValue;

			$value = $domPath->query("descendant::allianceID")->item(0);
			$commonInfo["allianceId"] = $value->nodeValue;

			$value = $domPath->query("descendant::allianceName")->item(0);
			$commonInfo["allianceName"] = $value->nodeValue;

			$value = $domPath->query("descendant::taxRate")->item(0);
			$commonInfo["taxRate"] = $value->nodeValue;

			$value = $domPath->query("descendant::memberCount")->item(0);
			$commonInfo["memberCount"] = $value->nodeValue;

			$value = $domPath->query("descendant::memberLimit")->item(0);
			if ($value != null)
				$commonInfo["memberLimit"] = $value->nodeValue;
			else
				$commonInfo["memberLimit"] = "?";
			$value = $domPath->query("descendant::shares")->item(0);
			$commonInfo["shares"] = $value->nodeValue;

			$divisionNodes = $domPath->query("descendant::rowset[@name='divisions']/row");
			if ($divisionNodes != null) {
				foreach ($divisionNodes as $divisionNode) {
					$accountKey = $divisionNode->getAttribute("accountKey");
					$description = $divisionNode->getAttribute("description");
					$divisions[$accountKey] = $description;
				}
			}

			$divisionNodes = $domPath->query("descendant::rowset[@name='walletDivisions']/row");
			if ($divisionNodes != null) {
				foreach ($divisionNodes as $divisionNode) {
					$accountKey = $divisionNode->getAttribute("accountKey");
					$description = $divisionNode->getAttribute("description");
					$walletDivisions[$accountKey] = $description;
				}
			}
		}

		return $result;
	}

}
?>
