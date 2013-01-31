<?php
return array(

	'breadcrumbs' => array(
		'template' => array(
			'wrapper_start' => '<ul class="breadcrumb">',
			'wrapper_end' => '</ul>',
			'item_start' => '<li>',
			'item_start_active' => '<li class="active">',
			'item_end' => '</li>',
			'divider' => '<span class="divider">/</span>',
		),

		'filterkey' => 'label',
	),

	'links' => array(
		'filterkey' => 'label',
	),

	'childnode' => 'pages',

	'properties' => array(
		'label',
		'title',
		'description',
		'keywords',
		'pages',
	),

);
