<?php

/*
 * Menu template.
 */

$result = "<nav><p>Menu</p>
		<ul>";
foreach ($modes as $key => $value) {
	$result .= "<li><a href='$value'>$key</a></li>";
}
$result .= "</ul></nav>";

echo $result;
?>
