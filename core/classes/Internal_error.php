<?php

	namespace Gaia\core\classes;


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

	}