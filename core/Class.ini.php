<?php

return [
	 
	/*
	 *	APPLICATION NAME
	 */
	
	'name' => '',
	
	/*
	 *	FRAMEWORK VERSION
	 */
	
	'version' => '0.0.1',
	
	/*
	 *	CLASS PATH
	 */
	
	'path' => array(
		'dir'	=> getcwd().DIRECTORY_SEPARATOR,
		'class' => 'core/classes/',
		'core'	=> 'core/',
		'app' 	=> 'app/',
		'cache'	=> 'core/caches/',
		'resources' => 'resources/'
	),
	
	/*
	 *	APPLICATION DEBUG MODE -> Console Tools
	 *	Enabling this feature can lead to graphical changes in your site, please manually override the local attributes in the console.
	 */
	
	'debug' => false,
	
	/*
	 *	CHACHE SETTINGS
	 */
	
	'cache_enabled' => false,
	
	/*
	 *	TEMPLATER TYPE
	 */
	
	'gaia_temp' => false,
	
	/*
	 *	APPLICATION URL
	 */
	
	'url' => 'http://peewit.altervista.org/',

	/*
	 *	APPLICATION TIMEZONE
	 */
	
	'timezone' => 'UTC',
	
	'date_default_timezone_set' => 'Europe/Rome',
	
	/*
	 *	APPLICATION LOCAL LANGUAGE
	 */
	
	'language' => ['en', 'it'],
	
	/*
	 *	APPLICATION LOCAL FALLBACK LANGUAGE
	 */
	
	'fallback_lang' => 'en',
	
	/*
	 *	DEFAULT LOCAL LANGUAGE
	 */
	 
	'defaultlang' => 'en',
	
	/*
	 *	MIGRATION DATA
	 */
	 
	'migration' => [
		'status' => false,
		'migration_type' => 'in', 	// Switch migration of type [out or ]
		'automatic' => false,
		//If migration is not automatic [ 'automatic' => false ], automatic migration includes all files into appropriate directory
	],
	
	
	/*
	 *	DEFAULT APPLICATION CONNECTION DATABASE
	 */
	
	'database_connection_default' => 'mysql',
	
	'connections' => [
		'sqlite' => [
			'driver' => 'sqlite',
			'database' => '',
			'prefix' => '',
		],
		
		'mysql' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'database' => 'gaia',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => 'Gaia_',
		],
		
		'mmsql' => [
			'driver' => 'mmsql',
			'host' => 'localhost',
			'database' => '',
			'username' => '',
			'password' => '',
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
		]
	],
	
];

?>