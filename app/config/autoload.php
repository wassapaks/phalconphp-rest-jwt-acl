<?php

/**
 * Auto Load file from Config
 *
 * @example 
 * 	$autoload = [
 *		'Namespaces' => [
 *			'App\Controllers' => APP_DIR . '/controllers/',
 *			'App\Models' => APP_DIR . '/models/',
 *			'App\Security' => APP_DIR . '/security/',
 *			'App\Services' => APP_DIR . '/services/'
 *		],
 *		'Dirs' => [
 *			
 *		]
 *	];
 */

$autoload = [
	'Namespaces' => [
		'App\Controllers' => APP_DIR . '/controllers/',
		'App\Models' => APP_DIR . '/models/',
		'App\Security' => APP_DIR . '/security/',
		'App\Services' => APP_DIR . '/services/',
		'App\Routes' => APP_DIR . '/routes/'
	],
	'Dirs' => [
		
	]
];

return $autoload;
