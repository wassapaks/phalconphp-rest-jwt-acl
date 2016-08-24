<?php

/**
 * Auto Load Class files by namespace
 *
 * @eg
'namespace' => '/path/to/dir'
 */

$autoload = [
	'Namespaces' => [
		'App\Controllers' => APP_DIR . '/controllers/',
		'App\Models' => APP_DIR . '/models/',
		'App\Security' => APP_DIR . '/security/',
		'App\Services' => APP_DIR . '/services/'
	],
	'Dirs' => [
		
	]
];

return $autoload;
