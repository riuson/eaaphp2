<?php

/*
 * CharacterName.
 * Returns the name associated with an ownerID or a typeID.
 * http://wiki.eve-id.net/APIv2_Eve_CharacterName_XML
 * http://api.eve-online.com/eve/CharacterName.xml.aspx 
 *
 * $api = new Api_Eve_CharacterName($registry, $user);
 * $api->getNames(array(797400947, 1188435724), $ids);
 * var_dump($ids);
 *
 */

class Api_Eve_CharacterName Extends Api_Base {

	public function getNames($ids, &$names) {

		$result = false;
		$names = array();
		$onlinePlayers = 0;

		$params = array();
		$params["version"] = "2";
		$params["ids"] = implode(",", $ids);

		if ($this->request("/eve/CharacterName.xml.aspx", $params)) {

			$domPath = new DOMXPath($this->document);

			$nodes = $domPath->query("descendant::rowset[@name='characters']/row");

			foreach ($nodes as $node) {

				$id = $node->getAttribute("characterID");
				$name = $node->getAttribute("name");
				$names[$id] = $name;
			}

			if (count($ids) == count($names))
				$result = true;
		}

		return $result;
	}

}
?>
