<?php

/*
 * About template view.
 */

if (!class_exists("template_mode_about")) {

	Class template_mode_about Extends Template_Base {

		public function getView() {

			extract($this->vars);
			$result = "
<p>About</p>
<p>Used documentation:</p>
<ul>
	<li><a href='http://myeve.eve-online.com/api/doc/default.asp'>EVE API Documentation Index</a></li>
	<li><a href='http://wiki.eve-id.net/'>EVE-Development Network</a></li>
	<li><a href='http://htmlbook.ru/'>HTML/CSS handbook</a></li>
	<li><a href='http://jz-soft.blog.163.com/blog/static/3437376200802111295321/'>Building a simple MVC system with PHP5</a>, <a href='http://habrahabr.ru/blogs/php/31270/'>Создание простой MVC-системы на PHP 5</a></li>
</ul>
Project repository at <a href='https://github.com/riuson/eaaphp2'>github</a>
<script>
	function bindContent()
	{
	}
</script>
";
			return $result;
		}

	}

}
?>
