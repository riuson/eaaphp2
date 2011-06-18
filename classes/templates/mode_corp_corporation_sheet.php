<?php

/*
 * Register template view.
 */

if (!class_exists("template_mode_corp_corporation_sheet")) {

	Class template_mode_corp_corporation_sheet Extends Template_Base {

		public function getView() {

			extract($this->vars);
			//print_r($this->vars['data']);

			$ids = "";
			if (!empty($resultCharacterId)) {
				foreach ($resultCharacterId as $key => $value) {
					$ids .= "$key => $value<br>";
				}
			}
			$names = "";
			if (!empty($resultCharacterName)) {
				foreach ($resultCharacterName as $key => $value) {
					$names .= "$value => $key<br>";
				}
			}

			$result = "<p>My Corporation</p>
<table>
	<tr>
		<td>Name:
		<td>$corpInfo[corporationName]
	<tr>
		<td>Ticker:
		<td>$corpInfo[ticker]
	<tr>
		<td>Ceo:
		<td>$corpInfo[ceoName]
	<tr>
		<td>Station:
		<td>$corpInfo[stationName]
	<tr>
		<td>Description:
		<td>$corpInfo[description]
	<tr>
		<td>URL:
		<td><a href='$corpInfo[url]'>$corpInfo[url]</a>
	<tr>
		<td>Alliance:
		<td>$corpInfo[allianceName]
	<tr>
		<td>Tax rate:
		<td>$corpInfo[taxRate]
	<tr>
		<td>Member count:
		<td>$corpInfo[memberCount]
	<tr>
		<td>Member limit:
		<td>$corpInfo[memberLimit]
	<tr>
		<td>Shares:
		<td>$corpInfo[shares]
</table>
";
			$result .= "
<table>
	<thead>
		<th>Id
		<th>Division
		<th>Wallet Division
";
			for ($i = 1000; $i < 1007; $i++) {
			$result .= "
	<tr>
		<td>$i
		<td>$divisions[$i]
		<td>$walletDivisions[$i]
";
			}
			$result .= "
</table>";
			return $result;
		}

	}

}
?>
