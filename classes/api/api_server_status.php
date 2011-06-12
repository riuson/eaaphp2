<?php

/*
 * Server Status.
 * Returns current Tranquility status and number of players online.
 * http://wiki.eve-id.net/APIv2_Server_ServerStatus_XML
 * http://api.eve-online.com/server/ServerStatus.xml.aspx
 */

class Api_Server_Status Extends Api_Base {

	public function getStatus(&$serverOpen, &$onlinePlayers) {

		$result = false;
		$serverOpen = false;
		$onlinePlayers = 0;

		$params = array();
		$params["version"] = "2";

		if ($this->request("/server/ServerStatus.xml.aspx", $params)) {

			// xpath navigation
			$domPath = new DOMXPath($this->document);
			// get nodes: result
			$status = $domPath->query("descendant::result");
			// get first node
			$status = $status->item(0);
			// get child nodes
			$status = $status->childNodes;
			$index = 0;
			foreach ($status as $statusElement) {
				if ($statusElement->localName == "serverOpen") {
					$serverOpen = $statusElement->nodeValue;
					$result = true;
				}
				if ($statusElement->localName == "onlinePlayers") {
					$onlinePlayers = $statusElement->nodeValue;
					$result = true;
				}
			}
		}

		return $result;
	}

}
?>
