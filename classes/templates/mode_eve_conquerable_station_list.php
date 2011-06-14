<?php

/*
 * Visitors log list tempalte.
 */

if (!class_exists("template_mode_eve_conquerable_station_list")) {

	Class template_mode_eve_conquerable_station_list Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($showTemplate) {

				$result = "<p>Conquerable Stations List</p>
<table id=\"stations\">
	<thead>
		<tr>
			<th>Station</th>
			<th>Solar System</th>
			<th>CorporationId</th>
			<th>Corporation</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
		<tr>
			<th>Station</th>
			<th>Solar System</th>
			<th>CorporationId</th>
			<th>Corporation</th>
		</tr>
	</tfoot>
</table>
<script>
	function bindContent()
	{
		$('#stations').dataTable( {
		'aoColumns': [
			null,
			null,
			{ 'bSearchable': false, 'bVisible': false },
			{ 'fnRender': function ( oObj ) {
				return \"<a href='\" + oObj.aData[2] +\"'>\"+ oObj.aData[3] + \"</a>\";
			} }
		],
		\"aaSorting\": [[ 0, \"desc\" ]],
		\"bJQueryUI\": true,
		\"bProcessing\": true,
		\"bServerSide\": true,
		\"bSort\": true,
		\"bAutoWidth\" : true,
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
			aoData.push( { \"name\": \"call\", \"value\": \"mode_eve_conquerable_station_list\" } );
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
		$('#stations').css('width', '100%');
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
