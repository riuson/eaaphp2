<?php

/*
 * Visitors log list tempalte.
 */

if (!class_exists("template_mode_visitors")) {

	Class template_mode_visitors Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($showTable) {
				//$result = "
//<table id=\"visitors_table\">
$result = "	<tr>
		<td>#</td>
		<td>Date</td>
		<td>Address</td>
		<td>User-Agent</td>";

				$result .= "
	</tr>";

				$rowIndex = $start;
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
				//$result .= "</table>";
			}
			else {
				$result = "<p>Visitors list</p>
<div id=\"pagination\"></div>
<table id=\"visitors_table\"></table>";

			}

			$result .= "
<script>
	function bindContent()
	{
		$(\"#pagination\").pagination($total, {
			items_per_page:20,
			num_edge_entries: 2,
			load_first_page: true,
			callback:handlePaginationClick
		});
	}
    function handlePaginationClick(new_page_index, pagination_container) {
        $.ajax({
			type: \"POST\",
			url: \"backend.php\",
			cache: false,
			data: \"call=mode_visitors&page=\" + new_page_index,
			success: function(html) {
				$(\"#visitors_table\").html(html);
			}
		});
        return false;
    }
</script>";

			return $result;
		}

	}

}
?>
