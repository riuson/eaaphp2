<?php

/*
 * Corp Account Balance tempalte.
 */

if (!class_exists("template_mode_corp_account_balance")) {

	Class template_mode_corp_account_balance Extends Template_Base {

		public function getView() {

			extract($this->vars);

			if ($showTemplate) {

				$result = "<p>Account Balance</p>
<table id='balance'>
	<thead>
		<tr>
			<th>Account Key</th>
			<th>Division</th>
			<th>Balance</th>
			<th>Updated</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
		<tr>
			<th>Account Key</th>
			<th>Division</th>
			<th>Balance</th>
			<th>Updated</th>
		</tr>
	</tfoot>
</table>
<script>
	function bindContent()
	{
		$('#balance').dataTable( {
		'aaSorting': [[ 0, 'asc' ]],
		'bJQueryUI': true,
		'bProcessing': true,
		'bServerSide': true,
		'bSort': true,
		'bAutoWidth' : true,
		'sDom': '<\"H\"Tfr>t<\"F\"ip>',
		'sPaginationType': 'full_numbers',
		'sAjaxSource': 'backend.php',
		'fnServerData': function ( sSource, aoData, fnCallback ) {
			aoData.push( { 'name': 'call', 'value': 'mode_corp_account_balance' } );
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
		$('#balance').css('width', '100%');
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
