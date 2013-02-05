<?php

Autoloader::add_core_namespace('Navigation');

Autoloader::add_classes(array(
	'Navigation\\Navigation'										=> __DIR__.'/classes/navigation.php',
	'Navigation\\BadMethodCallException'				=> __DIR__.'/classes/navigation.php',

	'Navigation\\Navigation_Driver'							=> __DIR__.'/classes/navigation/driver.php',
	'Navigation\\Navigation_Driver_Breadcrumbs'	=> __DIR__.'/classes/navigation/driver/breadcrumbs.php',
	'Navigation\\Navigation_Driver_Links'				=> __DIR__.'/classes/navigation/driver/links.php',
	'Navigation\\Navigation_Driver_Sitemap'			=> __DIR__.'/classes/navigation/driver/sitemap.php',
));
