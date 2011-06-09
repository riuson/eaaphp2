<?php

/*
 * Logout
 */
if (!function_exists('getContent')) {

	function getContent() {

		//print_r($_POST);

		$user = User::createUser();
		$user->logout();
		$loginSuccess = $user->isLogged();

		if (!$loginSuccess) {

			$result = "<p>User logout</p>
<div class='login'>User successfully logout
	<script>
		function bindContent()
		{
			updateStatus();
		}
	</script>
</div>";
		} else {

			$result = "<p>User logout</p>
<div class='login'>Unespected logout failure.
	<script>
		function bindContent()
		{
		}
	</script>
</div>";
		}
		return $result;
	}

}
?>
