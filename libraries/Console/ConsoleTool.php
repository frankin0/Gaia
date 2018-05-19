<?php
namespace Gaia\libraries\Console;
use Gaia\core\Gaia;

class ConsoleTool extends Gaia{
	
	public function __construct(){
		
		if(parent::$ini['debug']){
			//Debug is TRUE then show tool component
			self::__Print();
		}
		
	}
	
	public static function __Print(){
		
		/*
		 *	Print Debug Panel
		 */
		 
		define("cons_dir", "libraries/Console/views/");
		
		require_once(__DIR__.'/views/Console.php');
		
	}
	
}

//new ConsoleTool;