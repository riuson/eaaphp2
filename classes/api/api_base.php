<?php

/*
 * Api base class.
 *
 * $api = new Api_Base($registry);
 * $params = array();
 * $params["version"] = "2";
 * $api->request("/server/ServerStatus.xml.aspx", $params);
 * 
 */

class Api_Base {

	// settings
	protected $registry;
	protected $user;
	protected $commonMethod;
	private $apiroot;
	protected $document;
	protected $showinfo;
	protected $updateFromCache;
	protected $errorMessage;

	public function __construct($registry, $user = null) {

		$this->registry = $registry;
		if ($user == null)
			$this->user = $registry['user'];
		else
			$this->user = $user;
		$this->commonMethod = true;

		$this->apiroot = "http://api.eve-online.com";
		$this->showinfo = false;
		$this->updateFromCache = true;
	}

	// request eve api page
	// $target: page address
	// $paramarray: parameters
	// answer: true on succes, false on failure
	public function request($target, $params) {

		$success = false;
		$errorMessage = "";
		date_default_timezone_set("Etc/Universal");

		$serverResponse = null;

		try {

			$uri = $this->getUri($target, $params);
			$this->writeDebugMsg($uri . "<br>");
			$fromCache = false;

			// check cache
			if ($this->checkCache($uri, $cached, $cachedUntil, $mustGetFromCache, $cachedValue)) {

				if ($mustGetFromCache) {

					$this->writeDebugMsg("get from cache, because cachedUntil > now<br>");
					$serverResponse = $cachedValue;
					$fromCache = true;
				} else {

					$this->writeDebugMsg("but data too old, downloading from server...<br>");
					$serverResponse = $this->exchange($target, $params);
				}
			} else {

				$this->writeDebugMsg("cache empty, downloading from server...<br>");
				$serverResponse = $this->exchange($target, $params);
			}

			$this->cleanOldCache();

			// check for error
			if ($this->validate($serverResponse, $errorMessage)) {

				// if updated from server, save to cache
				if (!$fromCache)
					$this->saveToCache($uri, $serverResponse);

				// load to DomDocument

				$success = $this->loadXml($serverResponse, $errorMessage);
			}
		} catch (Exception $exc) {

			$success = false;
		}
		$this->errorMessage = $errorMessage;
		return $success;
	}

	public function getErrorMessage() {

		return $this->errorMessage;
	}

	private function getUri($target, $params) {

		// post data
		$result = $target . "?";
		// add field as `key=value&`
		foreach ($params as $k => $v) {
			// skip empty parameters
			//if ($k == "userId" && $v == 0)
			//	continue;
			//if ($k == "characterId" && $v == 0)
			//	continue;
			//if ($k == "apiKey" && $v == "")
			//	continue;
			$result .= $k . "=" . $v . "&";
		}
		// trim `&` from end
		$result = rtrim($result, "&");
		//$this->writeDebugMsg($result);

		return $result;
	}

	private function exchange($uri, $params) {

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->apiroot . $uri);
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1000);
		// read response to string
		$serverResponse = curl_exec($ch);
		$this->writeDebugMsg("post fields " . $uri . "<br>");

		curl_close($ch);

		$this->fromCache = false;

		return $serverResponse;
	}

	private function validate($serverResponse, &$errorMessage) {

		$success = true;
		$errorMessage = "";

		if (preg_match("/(?<=\<body).*(?=\<\/body)/ims", $serverResponse, $matches) > 0) {

			$errorMessage = "received html document instead xml"; //$matches[0];
			$success = false;
		} else
		if (preg_match("/eveapi/i", $serverResponse) == 0) {

			$errorMessage = "eveapi tag not found in response";
			$success = false;
		} else
		if (preg_match("/(?<=error).+\>(.*)(?=\<\/error)/i", $serverResponse, $matches) > 0) {

			$errorMessage = $matches[1];
			$success = false;
		}
		return $success;
	}

	private function checkCache($uri, &$cached, &$cachedUntil, &$mustGetFromCache, &$cachedValue) {

		$recordExists = false;

		if ($this->commonMethod)
			$accountId = 0;
		else {
			$this->user->getMasterData($masterData);
			$accountId = $masterData['accountId'];
		}

		$query = sprintf("select * from api_cache where accountId = '%d' and uri = '%s' order by `cached` desc limit 1;",
						$this->registry['db']->escape($accountId),
						$this->registry['db']->escape($uri));

		$qr = $this->registry['db']->query($query);
		if ($qr) {

			$row = $qr->fetch_assoc();

			if ($row != false) {

				$this->writeDebugMsg("cache not empty<br>");
				$cached = new DateTime($row["cached"]);
				$cachedUntil = new DateTime($row["cachedUntil"]);
				$now = new DateTime("now");
				$cachedValue = base64_decode($row["cachedValue"]);

				$qr->close();

				if ($cachedUntil < $now)
					$mustGetFromCache = false;
				else
					$mustGetFromCache = true;

				$recordExists = true;
			}
		}

		return $recordExists;
	}

	private function cleanOldCache() {

		$oltTime = date("Y-m-d H:i:s", strtotime("-2 day"));
		$query = sprintf("delete from api_cache where cachedUntil < '%s';",
						$this->registry['db']->escape($oltTime));
		//$this->writeDebugMsg($query);
		$this->registry['db']->query($query);
	}

	private function saveToCache($uri, $serverResponse) {

		if ($this->commonMethod)
			$accountId = 0;
		else {
			$this->user->getMasterData($masterData);
			$accountId = $masterData['accountId'];
		}

		$cachedStr = "?";
		if (preg_match("/(?<=currentTime\>).*(?=\<\/currentTime)/", $serverResponse, $regs))
			$cachedStr = $regs[0];

		$cachedUntilStr = "?";
		if (preg_match("/(?<=cachedUntil\>).*(?=\<\/cachedUntil)/", $serverResponse, $regs))
			$cachedUntilStr = $regs[0];

		$serverResponseStr = base64_encode($serverResponse);

		$query = sprintf("insert into api_cache (accountId, uri, cached, cachedUntil, cachedValue) " .
						"values(%d, '%s', '%s', '%s', '%s');",
						$this->registry['db']->escape($accountId),
						$this->registry['db']->escape($uri),
						$this->registry['db']->escape($cachedStr),
						$this->registry['db']->escape($cachedUntilStr),
						$this->registry['db']->escape($serverResponseStr));
		$this->writeDebugMsg("saving to cache<br>");
		$this->registry['db']->query($query);
		$this->writeDebugMsg("records cached: " . $this->registry['db']->getAffectedRows() . "<br>");
	}

	// return true if document readed successfully, else false
	// document stored in $this->document
	private function loadXml($serverResponse, &$errorMessage) {

		$success = false;
		$this->writeDebugMsg("<pre>" . htmlentities($serverResponse) . "</pre>");

		try {

			$this->document = DomDocument::loadXML($serverResponse);
			$errorMessage = "";
			$success = true;
		} catch (Exception $exc) {

			$errorMessage = $exc->getMessage();
			$success = false;
		}

		return $success;
	}

	private function writeDebugMsg($message) {

		if ($this->showinfo) {
			echo $message;
		}
	}

}
?>
