<?php
###############################  S  T  A  R  T   ################################
##              -= YOU MAY NOT REMOVE OR CHANGE THIS NOTICE =-                 ##
## --------------------------------------------------------------------------- ##
##  Filename       Class.ini.php                                               ##
##  Version        1.5                                                         ##
##  Developed by:  Francesco Esposito espoweb.com - francescoe15@gmail.com     ##
##  Rework by:     www.espoweb.com                                             ##
##  License:       Gaia Framework                                              ##
##  Copyright:     Gaia (c) 2017-2018. All rights reserved.                    ##
##                                                                             ##
#################################################################################


return [
	 
	/*
	 *	APPLICATION NAME
	 */
	
	'name' => 'Gaia Framework',
	
	/*
	 *	FRAMEWORK VERSION
	 */
	
	'version' => '2.5.0',
	
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
	
	'debug' => array(
		'status' => false,	//Please disable htaccess RedirectMatch -> libraries
		'quick_ip' => array(	/* Enabled quick_status_ip true if do you want debug only on your ip address */
			'status' => false,
			'myip' => ''
		),
		/*	UPDATER FRAMEWORK */
		/* COMING SOON */
		'updater' => false
	),
	

	/*
	 *	CHACHE SETTINGS
	 */
	
	'cache_enabled' => false,
	
	/**
	 * DISPLAY ERROR
	 */
	'display_errors' => true,

	/*
	 *	TEMPLATER TYPE
	 */
	
	'gaia_temp' => false,
	
	/*
	 *	APPLICATION URL
	 */
	
	'url' => 'http://peewit.altervista.org/',
	
	'url_updater' => 'http://peewit.altervista.org/json/check.php',	/* Or Beta Version add after link ?rc_ */


	/*
	 *	APPLICATION TIMEZONE
	 */
	
	'timezone' => 'UTC',
	
	'date_default_timezone_set' => 'Europe/Rome',
	
	'set_local_lc_time' => 'it_IT',
	
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
	 
	'defaultlang' => 'it',
	
	/*
	 *	MIGRATION DATA
	 */
	 
	'migration' => [
		'status' => true,
		'migration_type' => 'in', 	// Switch migration of type [out or in]
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
			'database' => 'test',
			'username' => 'root',
			'password' => '123456',
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
