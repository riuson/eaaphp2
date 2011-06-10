<?php

$modeTitle = "Visitors";

if (!function_exists('getContent')) {

	function getContent() {

		$result = "<p>Visitors list</p>";
		$db = new Database();

		$qr = $db->query("select count(*) as _count_ from api_visitors;");
		$row = $qr->fetch_assoc();
		$recordsCount = $row["_count_"];
		$qr->close();

		$result .= "<p>hello</p>
<table>
	<tr>
		<td>#</td>
		<td>Date</td>
		<td>Address</td>
		<td>User-Agent</td>";

		$result .= "
	</tr>";

		$qr = $db->query("SELECT * FROM `api_visitors` group by address, date(_date_) order by _date_ desc limit 20;");

		$rowIndex = 0;
		$rowClass = "even";
		while ($row = $qr->fetch_assoc()) {
			if (($rowIndex % 2) == 1)
				$rowClass = "even";
			else
				$rowClass = "odd";
			$rowIndex++;

			$result .= "
<tr class='$rowClass'>
	<td>$rowIndex</td>
	<td>$row[_date_]</td>
	<td>$row[address]</td>
	<td>$row[agent]</td>
</tr>";
		}

		$result .= "
</table>
<script>
	function bindContent()
	{;
	}
</script>";

		$qr->close();

		return $result;
	}

}
?>