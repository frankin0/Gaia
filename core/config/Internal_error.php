<?php

	namespace Gaia\core\config;


	class Internal_error{
		
		public static function show($type){

			echo "<pre><h1>Not Found</h1><p>The requested URL ".$_SERVER['REQUEST_URI']." was not found on this server.</p><p>Additionally, a {$type} Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p></pre>";

		}

		public static function warning($file){
			echo "<pre><b>Warning: </b>file({$file}): failed to open stream: No such file or directory in core/controllers/{$file} </pre>";
		}

		public static function error($type){
			echo "<pre><b>Error: </b> {$type} </pre>";
		}

		public static function ErrorHandler($errno, $errstr, $errfile, $errline){
			if (!(error_reporting() & $errno)) {
				// This error code is not included in error_reporting, so let it fall
				// through to the standard PHP error handler
				return false;
			}
		
			switch ($errno) {
				case E_USER_ERROR:
					echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
					echo "  Fatal error on line $errline in file $errfile";
					echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
					echo "Aborting...<br />\n";
					exit(1);
					break;
			
				case E_USER_WARNING:
					echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
					break;
			
				case E_USER_NOTICE:
					echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
					break;
			
				default:
					echo "Unknown error type: [$errno] $errstr<br />\n";
					break;
			}
		
			/* Don't execute PHP internal error handler */
			return true;
		}
	}