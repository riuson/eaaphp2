<?php

/*
 * Visitors log list tempalte.
 */

if (!class_exists("template_mode_eve_conquerable_station_list")) {

	Class template_mode_eve_conquerable_station_list Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($show == 'template') {

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
<div id='corpInfo'>
</div>
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
				call: 'mode_eve_conquerable_station_list',
				corporationId: $(this).attr('href')
			}
			$.ajax({
				type: 'POST',
				url: 'backend.php',
				cache: false,
				data: aData,
				success: function(html) {
					$('#corpInfo').html(html);
				}
			});
			return false;
		});
	}
</script>
";
			} else if ($show == 'corpinfo'){
/*
	<tr>
		<td>CorporationId
		<td>$corpInfo[corporationId]
	<tr>
		<td>CeoId:
		<td>$corpInfo[ceoId]
	<tr>
		<td>StationId:
		<td>$corpInfo[stationId]
	<tr>
		<td>AllianceId:
		<td>$corpInfo[allianceId]
 */
				$result = "
<table>
	<tr>
		<td>CorporationName:
		<td>$corpInfo[corporationName]
	<tr>
		<td>Ticker:
		<td>$corpInfo[ticker]
	<tr>
		<td>CeoName:
		<td>$corpInfo[ceoName]
	<tr>
		<td>StationName:
		<td>$corpInfo[stationName]
	<tr>
		<td>Description:
		<td>$corpInfo[description]
	<tr>
		<td>URL:
		<td><a href='$corpInfo[url]'>$corpInfo[url]</a>
	<tr>
		<td>AllianceName:
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
			} else if ($show == 'datatable'){

				$result = $jsonOutput;
			}

			return $result;
		}

	}

}
?>
