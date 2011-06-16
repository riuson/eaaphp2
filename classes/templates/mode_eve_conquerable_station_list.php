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
<table id='stations'>
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

				return \"<a class='.showCorp' href='\" + oObj.aData[2] +\"'>\"+ oObj.aData[3] + \"</a>\";
			} }
		],
		'aaSorting': [[ 0, 'desc' ]],
		'bJQueryUI': true,
		'bProcessing': true,
		'bServerSide': true,
		'bSort': true,
		'bAutoWidth' : true,
		'sDom': '<\"H\"Tfr>t<\"F\"ip>',
		'sPaginationType': 'full_numbers',
		'sAjaxSource': 'backend.php',
		'fnServerData': function ( sSource, aoData, fnCallback ) {
			aoData.push( { 'name': 'call', 'value': 'mode_eve_conquerable_station_list' } );
			aoData.push( { 'name': 'sender', 'value': 'datatables' } );
			$.ajax( {
				'dataType': 'json',
				'type': 'POST',
				'url': sSource,
				'data': aoData,
				'success': fnCallback
			} );
			}
		});
		$('#stations').css('width', '100%');
		$('#stations a').live('click', function()
		{
			var aData = {
				corporationId: $(this).attr('href')
			}
			loadContent('mode_corp_corporation_sheet', aData);
			return false;
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
