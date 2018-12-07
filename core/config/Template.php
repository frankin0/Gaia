<?php

	namespace Gaia\core\config;
	use Gaia\core\Gaia;
	use Gaia\core\config\Internal_error;
	use Gaia\libraries\Gaia_Templater\GaiaTemplate;

abstract class Template extends Gaia{

        public static $ShowData = array();

		public static function view($viewFile, $viewVars = array()){
			if(parent::$ini['gaia_temp']){
				self::GaiaView($viewFile, $viewVars);
			}else{
				self::nativeView($viewFile, $viewVars);
			}
		}
		
		public static function nativeView($viewFile, $viewVars = array()){
			//extract($viewVars);
			$viewFileCheck = explode(".", $viewFile);
			if(!isset($viewFileCheck[1])){
				$viewFile .= ".php";
			}
			
			$viewFile = str_replace("::", "/", $viewFile);
			$filename = parent::$ini['path']['app']."views/{$viewFile}";
			if(file_exists($filename)){
				require_once($filename);
			}else{
				internal_error::show(404);
			}
		}
		
		public static function GaiaView($viewFile, $viewVars = array()){
			$viewFileCheck = explode(".", $viewFile);
			if(!isset($viewFileCheck[1])){
				$viewFile .= ".html";
			}
			
			$viewFile = str_replace("::", "/", $viewFile);
			$filename = parent::$ini['path']['app']."views/{$viewFile}";
			if(file_exists($filename)){
				$engine = new GaiaTemplate();
				
                echo $engine->render($filename, $viewVars);
			}else{
				internal_error::show(404);
			}
		}
	}

?>