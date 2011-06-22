<?php

/*
 * Visitors log list tempalte.
 */

if (!class_exists("template_mode_corp_wallet_journal")) {

	Class template_mode_corp_wallet_journal Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($showTemplate) {

				$result = "<p>Wallet Journal</p>
<table id='visitors'>
	<thead>
		<tr>
			<th>Wallet</th>
			<th>refId</th>
			<th>Date</th>
			<th>Type</th>
			<th>Sender</th>
			<th>Receiver</th>
			<th>Subject</th>
			<th>Amount</th>
			<th>Balance</th>
			<th>Comment</th>
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
			<th>Sender</th>
			<th>Receiver</th>
			<th>Subject</th>
			<th>Amount</th>
			<th>Balance</th>
			<th>Comment</th>
		</tr>
	</tfoot>
</table>
<script>
	function bindContent()
	{
		$('#visitors').dataTable( {
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
			aoData.push( { 'name': 'call', 'value': 'mode_corp_wallet_journal' } );
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
				null,
				null,
				null,
				null,
				null,
				{ type: 'number-range' },
				null,
				{ type: 'number' }
			]
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
