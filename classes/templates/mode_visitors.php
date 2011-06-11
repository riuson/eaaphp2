<?php

/*
 * Visitors log list tempalte.
 */

if (!class_exists("template_mode_visitors")) {

	Class template_mode_visitors Extends Template_Base {

		public function getView() {

			extract($this->vars);
			$result = "<p>Visitors list</p>
<table>
	<tr>
		<td>#</td>
		<td>Date</td>
		<td>Address</td>
		<td>User-Agent</td>";

			$result .= "
	</tr>";

			$rowIndex = 0;
			$rowClass = "even";
			foreach ($log as $sub) {
				if (($rowIndex % 2) == 1)
					$rowClass = "even";
				else
					$rowClass = "odd";
				$rowIndex++;

				$result .= "
<tr class='$rowClass'>
	<td>$rowIndex</td>
	<td>$sub[_date_]</td>
	<td>$sub[address]</td>
	<td>$sub[agent]</td>
</tr>";
			}

			$result .= "
</table>
<script>
	function bindContent()
	{;
	}
</script>";

			return $result;
		}

	}

}
?>
