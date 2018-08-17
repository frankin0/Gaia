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
	
	'name' => '%NAME%',
	
	/*
	 *	FRAMEWORK VERSION
	 */
	
	'version' => '%VERSION%',
	
	/*
	 *	CLASS PATH
	 */
	
	'path' => array(
		'dir'	=> '%DIRECTORY_SEPARATOR%', //getcwd().DIRECTORY_SEPARATOR,
		'class' => '%CLASS%',   //Default: core/classes/
		'core'	=> '%CORE%',    //DEFAULT: core/
		'app' 	=> '%APP%',  //Default: app/,
		'cache'	=> '%CACHE%',  //Default: core/caches/
		'resources' => '%RESOURCES%' //Default: resources/
	),
	
	/*
	 *	APPLICATION DEBUG MODE -> Console Tools
	 *	Enabling this feature can lead to graphical changes in your site, please manually override the local attributes in the console.
	 */
	
	'debug' => array(
		'status' => '%STATUS_DEBUG%',   //Default: true
		'quick_ip' => array(	/* Enabled quick_status_ip true if do you want debug only on your ip address */
			'status' => '%STATUS_QUICK_IP%',   //Default: false
			'myip' => '%MY_IP%'    //Default: 1:0:0
		),
		/*	UPDATER FRAMEWORK */
		/* COMING SOON */
		'updater' => '%UPDATER%'  //Default: false
	),
	

	/*
	 *	CHACHE SETTINGS
	 */
	
	'cache_enabled' => '%CACHE_ENABLED%',   //Default: false
	
	/*
	 *	TEMPLATER TYPE
	 */
	
	'gaia_temp' => '%GAIA_TEMP%',   //Default: false
	
	/*
	 *	APPLICATION URL
	 */
	
	'url' => '%URL_APPLICATION%',   //Default: http://peewit.altervista.org/
	
	'url_updater' => '%URL_UPDATER%',	/* Or Beta Version add after link ?rc_ */ //Default: http://peewit.altervista.org/json/check.php


	/*
	 *	APPLICATION TIMEZONE
	 */
	
	'timezone' => '%TIMEZONE%',    //Default: UTC
	
	'date_default_timezone_set' => '%DATE_DEFAULT_TIMEZONE_SET%', //Default: Europe/Rome
	
	/*
	 *	APPLICATION LOCAL LANGUAGE
	 */
	
	'language' => ['en', 'it'], //Default: ['en', 'it']
	
	/*
	 *	APPLICATION LOCAL FALLBACK LANGUAGE
	 */
	
	'fallback_lang' => '%FALLBACK_LANG%',    //Default: en
	
	/*
	 *	DEFAULT LOCAL LANGUAGE
	 */
	 
	'defaultlang' => '%DEFAULTLANG%',  //Default: en
	
	/*
	 *	MIGRATION DATA
	 */
	 
	'migration' => [
		'status' => '%STATUS_MIGRATION%',   //Default: true
		'migration_type' => '%MIGRATION_TYPE%', 	// Switch migration of type [out or ] -- Default: in
		'automatic' => '%AUTOMATIC%',   //Default: false
		//If migration is not automatic [ 'automatic' => false ], automatic migration includes all files into appropriate directory
	],
	
	
	/*
	 *	DEFAULT APPLICATION CONNECTION DATABASE
	 */
	
	'database_connection_default' => '%DATABASE_CONNECTION_DEFAULT%',   //Default: mysql
	
	'connections' => [
		'sqlite' => [
			'driver' => '%DRIVER_SQLITE%',   //Default: sqlite
			'database' => '%DATABASE_SQLITE%',   
			'prefix' => '%PREFIX_SQLITE%',
		],
		
		'mysql' => [
			'driver' => '%DRIVER_MYSQL%',    //Default: mysql
			'host' => '%HOST_MYSQL%',  //Default: localhost
			'database' => '%DATABASE_MYSQL%',
			'username' => '%USERNAME_MYSQL%',
			'password' => '%PASSWORD_MYSQL%',
			'charset' => '%CHARSET_MYSQL%',    //Default: utf8
			'collation' => '%COLLATION_MYSQL%',    //Default: utf8mb4_unicode_ci
			'prefix' => '%PREFIX_MYSQL%',    //Default: Gaia_
		],
		
		'mmsql' => [
			'driver' => '%DRIVER_MMSQL%',    //Default: mmsql
			'host' => '%HOST_MMSQL%',  //Default: localhost
			'database' => '%DATABASE_MMSQL%',
			'username' => '%USERNAME_MMSQL%',
			'password' => '%PASSWORD_MMSQL%',
			'charset' => '%CHARSET_MMSQL%', //Default: utf8mb4
			'collation' => '%COLLATION_MMSQL%',    //Default: utf8mb4_unicode_ci
			'prefix' => '%PREFIX_MMSQL%',
		]
	],
	
];

?>