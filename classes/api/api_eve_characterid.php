<?php

/*
 * CharacterID.
 * Returns the ownerID for a given character, faction, alliance or corporation name, or the typeID for other objects such as stations, solar systems, planets, etc.
 * http://wiki.eve-id.net/APIv2_Eve_CharacterID_XML
 * http://api.eve-online.com/eve/CharacterID.xml.aspx
 *
 * $api = new Api_Eve_CharacterID($registry, $user);
 * $api->getIds(array("Lehar", "CCP Garthagk"), $ids);
 * var_dump($ids);
 * 
 */

class Api_Eve_CharacterID Extends Api_Base {

	public function getIds($names, &$ids) {

		$result = false;
		$ids = array();
		$onlinePlayers = 0;

		$params = array();
		$params["version"] = "2";
		$params["names"] = implode(",", $names);

		if ($this->request("/eve/CharacterID.xml.aspx", $params)) {

			$domPath = new DOMXPath($this->document);

			$nodes = $domPath->query("descendant::rowset[@name='characters']/row");

			foreach ($nodes as $node) {
				
				$id = $node->getAttribute("characterID");
				$name = $node->getAttribute("name");
				$ids[$name] = $id;
			}

			if (count($names) == count($ids))
				$result = true;
		}

		return $result;
	}

}
?>
