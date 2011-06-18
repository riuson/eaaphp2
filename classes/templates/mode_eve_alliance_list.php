<?php

/*
 * Alliance list tempalte.
 */

if (!class_exists("template_mode_eve_alliance_list")) {

	Class template_mode_eve_alliance_list Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($show == 'template') {

				$result = "<p>Alliance List</p>
<table id='alliances'>
	<thead>
		<tr>
			<th>Ticker</th>
			<th>Ticker</th>
			<th>Name</th>
			<th>Member count</th>
			<th>Start Date</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
		<tr>
			<th>Ticker</th>
			<th>Ticker</th>
			<th>Name</th>
			<th>Member count</th>
			<th>Start Date</th>
		</tr>
	</tfoot>
</table>
<div id='allianceInfo'>
</div>
<script>
	function bindContent()
	{
		$('#alliances').dataTable( {
		'aoColumns': [
			{ 'bSearchable': false, 'bVisible': false },
			null,
			{ 'fnRender': function ( oObj ) {

				//return \"<a class='.showAlliance' href='\" + oObj.aData[0] +\"'>\"+ oObj.aData[2] + \"</a>\";
				return oObj.aData[2];
			} },
			null,
			null
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
			aoData.push( { 'name': 'call', 'value': 'mode_eve_alliance_list' } );
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
		$('#alliances').css('width', '100%');
		$('#alliances a').live('click', function()
		{
			var aData = {
				call: 'mode_eve_conquerable_station_list',
				allianceId: $(this).attr('href')
			}
			$.ajax({
				type: 'POST',
				url: 'backend.php',
				cache: false,
				data: aData,
				success: function(html) {
					$('#allianceInfo').html(html);
				}
			});
			return false;
		});
	}
</script>
";
			} else if ($show == 'datatable'){

				$result = $jsonOutput;
			}

			return $result;
		}

	}

}
?>
