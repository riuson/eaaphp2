<?php

/*
 * Corporation wallet transactions template.
 */

if (!class_exists("template_mode_corp_wallet_transactions")) {

	Class template_mode_corp_wallet_transactions Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($showTemplate) {

				$result = "<p>Wallet Transactions</p>
<table id='visitors'>
	<thead>
		<tr>
			<th>Wallet</th>
			<th>refId</th>
			<th>Date</th>
			<th>Type</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Character</th>
			<th>Client</th>
			<th>Station</th>
			<th>Trans. type</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
		<tr>
			<th>Wallet</th>
			<th>refId</th>
			<th>Date</th>
			<th>Type</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Character</th>
			<th>Client</th>
			<th>Station</th>
			<th>Trans. type</th>
		</tr>
	</tfoot>
</table>
<script>
	function bindContent()
	{
		$('#visitors').dataTable( {
		'aoColumns': [
			null,
			null,
			null,
			null,
			null,
			{ 'fnRender': function ( oObj ) {

				return oObj.aData[5] + \" <span class='cell-comment'>(\" + oObj.aData[4] * oObj.aData[5] + \")</span>\";
			} },
			null,
			null,
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
			aoData.push( { 'name': 'call', 'value': 'mode_corp_wallet_transactions' } );
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
		setTableFilters();
		$('#visitors').css('width', '100%');
	}
	function setTableFilters()
	{
		$('#visitors').dataTable().columnFilter({
			aoColumns: [
				{ type: 'select', values: [ '1000', '1001', '1002', '1003', '1004', '1005', '1006']  },
				null,
				{ type: 'date-range' },
				{ type: 'text' },
				{ type: 'text' },
				{ type: 'text' },
				{ type: 'text' },
				{ type: 'number-range' },
				{ type: 'text' },
				{ type: 'number' }
			]
		});
		$.datepicker.setDefaults({
		dateFormat: 'yy-mm-dd',
		   showOn: 'both',
		   buttonImageOnly: true,
		   buttonImage: 'calendar.gif',
		   buttonText: 'Calendar' });
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
