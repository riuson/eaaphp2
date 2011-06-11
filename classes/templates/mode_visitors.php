<?php

/*
 * Visitors log list tempalte.
 */

if (!class_exists("template_mode_visitors")) {

	Class template_mode_visitors Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($showTemplate) {

				$result = "<p>Visitors list</p>
<table id=\"example\">
	<thead>
		<tr>
			<th>Date</th>
			<th>Address</th>
			<th>User Agent</th>
			<th>Login</th>
			<th>Uri</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
		<tr>
			<th>Date</th>
			<th>Address</th>
			<th>User Agent</th>
			<th>Login</th>
			<th>Uri</th>
		</tr>
	</tfoot>
</table>
<script>
	function bindContent()
	{
		$('#example').dataTable( {
		\"aaSorting\": [[ 0, \"desc\" ]],
		\"bJQueryUI\": true,
		\"bProcessing\": true,
		\"bServerSide\": true,
		\"bSort\": true,
		\"bAutoWidth\" : false,
		\"sDom\": '<\"H\"Tfr>t<\"F\"ip>',
		\"oTableTools\": {
			\"aButtons\": [
				\"copy\", \"csv\", \"xls\", \"pdf\",
				{
					\"sExtends\":    \"collection\",
					\"sButtonText\": \"Save\",
					\"aButtons\":    [ \"csv\", \"xls\", \"pdf\" ]
				}
			]
		},

		\"sPaginationType\": \"full_numbers\",
		\"sAjaxSource\": \"backend.php\",
		\"fnServerData\": function ( sSource, aoData, fnCallback ) {
			aoData.push( { \"name\": \"call\", \"value\": \"mode_visitors\" } );
			aoData.push( { \"name\": \"sender\", \"value\": \"datatables\" } );
			$.ajax( {
				\"dataType\": 'json',
				\"type\": \"POST\",
				\"url\": sSource,
				\"data\": aoData,
				\"success\": fnCallback
			} );
			}
		});
	}
</script>
";
			} else {

				$result = $jsonOutput;
			}

			return $result;
		}

	}

}
?>
