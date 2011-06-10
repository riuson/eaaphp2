<?php

/*
 * Test controller.
 */

Class Controller_Test Extends Controller_Base {

	function index() {

		echo "
<p>Test</p>
<p>Sample</p>
<script>
	function bindContent()
	{
	}
</script>
";
	}

	function view() {

		echo 'You are viewing the members/view request';
	}

}
?>
