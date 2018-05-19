<?php

namespace Gaia\core\classes;
use Gaia\core\classes\Internal_error;
use Gaia\core\controllers\Index;

/*
 * How - The program that powers espoweb.com
 * Copyright (C) 2017
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * https://espoweb.com
 *
 */
class Bho{

}

class Router{

	public static function get($dir = null, $callback = array(), $require_ajax = false){
		return self::map(['GET'], $dir, $callback, $require_ajax);
	}

	public static function post($dir, $callback, $require_ajax = false){
		return self::map(['POST'], $dir, $callback, $require_ajax);
	}
	
	public static function put($dir, $callback, $require_ajax = false){
		return self::map(['PUT'], $dir, $callback, $require_ajax);
	}
	
	public static function delete($dir, $callback, $require_ajax = false){
		return self::map(['DELETE'], $dir, $callback, $require_ajax);
	}
	
	public static function patch($dir, $callback, $require_ajax = false){
		return self::map(['PATCH'], $dir, $callback, $require_ajax);
	}
	
	public static function options($dir, $callback, $require_ajax = false){
		return self::map(['OPTIONS'], $dir, $callback, $require_ajax);
	}
	
	public static function any($dir, $callback, $require_ajax = false){
		return self::map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'], $dir, $callback, $require_ajax);
	}

	protected static function controller($route, $dir, $matches){
		$fnc = "Show";
		$array_variables = Array();
		$ref; 
		$err = 0;

		if(isset($route)){ 
			if(empty($dir)) {
				$imp = explode("/", $route);
			}else{

				$dir_regex = preg_replace("/\{(.*?)\}/", "", $dir);
				$ijas = preg_replace('#/+#', '/', $dir_regex);
				$ijas = trim($ijas, "/");
				$imp = explode("/", $ijas); 
			}
			foreach($imp as $key => $value){
				if($key == 0){	//if key = 0 is mother container then 0 is a file
					
					if(!file_exists(getcwd().DIRECTORY_SEPARATOR."core\controllers".DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, ($imp[0] ? $imp[0] : $route )).".php")){
						Internal_error::warning(($imp[0] ? $imp[0] : $route ).".php");
						$err = 1;
					}else{	// Else file exists
						$ref = new \ReflectionClass("Gaia\\core\\controllers\\". ($imp[0] ? $imp[0] : $route ));
						$c = $ref->newInstance();
						$err = 0;
					}

				}else{
					
					$fnc = $imp[$key]; 
					$array_variables[$key] = $value;					

				}
			}

			
			$funcArray = Array();
			$funcArray_c;

			foreach($array_variables as $key => $val){
				if($err == 1){
					Internal_error::warning($route.".php");
				}else{

					if(method_exists($c, $val)){	//is function in class
						$funcArray[$key] = $val;
						$funcArray_c = $val;
					}else{
						if(property_exists($c, 'Index')){	//is variable in class
							$c->Index['var'.$key] = $val;
						}
					}
				}
			}

			if($err == 0){
				$c->Index = (object) @$c->Index;
				
				return $c->{(@$funcArray_c ? @$funcArray_c : $fnc)}($matches);
			}
		}
		
	}
	
	public static function map($methods, $dir = null, $callback, $require_ajax = false){
		if(!in_array(strtoupper($_SERVER['REQUEST_METHOD']), $methods)){
			return;
		}

		if($require_ajax && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) != 'XMLHTTPREQUEST'){
			return;
		}

		if(empty($dir)){
			$dir = "";
		}

		$dir_regex = preg_replace("/\{(.*?)\}/", "(?P<$1>[\w-]+)", $dir);
		$dir_regex = "#^".trim($dir_regex, "/")."$#";
		

		if($methods[0] == 'GET'){
			preg_match($dir_regex, trim(@$_GET['route'], "/"), $matches);

			$route_controller = isset($_GET["route"]) ? $_GET["route"] : "Index";

			if($matches || empty($dir)){ 
				self::controller($route_controller, $dir, (object) $matches);
				if(is_callable($callback)) call_user_func($callback, (object) $matches);
				exit;
			}
	    }

        if($methods[0] == 'POST'){

			if(is_callable($callback) && $require_ajax == false){
				preg_match($dir_regex, trim(@$_GET['route'], "/"), $matches);

				if($matches){
	                call_user_func($callback, (object) $_POST);
	                exit;
				}
			}else if(is_callable($callback) && $require_ajax == true){
				preg_match($dir_regex, trim(@$_POST['route'], "/"), $matches);

				if($matches){
					call_user_func($callback, (object) $matches);
					exit;
				}
			}

		}

	}

}
