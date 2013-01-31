<?php
return array(
	'/' => array(
		'label'       => 'Home',
		'title'       => 'title',
		'description' => 'description',
		'keywords'    => 'keywords',
		'pages'       => array(
			'/page1' => array(
				'label'       => 'Home',
				'title'       => 'title',
				'description' => 'description',
				'keywords'    => 'keywords',
			),
			'/page2' => array(
				'label'       => 'Home',
				'title'       => 'title',
				'description' => 'description',
				'keywords'    => 'keywords',
				'pages' => array(
					'/page2/page3' => array(
						'label'       => 'Home',
						'title'       => 'title',
						'description' => 'description',
						'keywords'    => 'keywords',
					),
				),
			),
		),
	),
);
