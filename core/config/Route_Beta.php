<?php

namespace Gaia\core\config;

use Gaia\core\Gaia;
use Gaia\core\config\Internal_error;
//use Gaia\core\controllers\Index;

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

class Route_Beta extends Gaia{
    
    public static $site_path, $_instance;

    public static function Instance($site_path){
        return call_user_func( self::$_instance, $site_path);
    }


    public function __construct($site_path){
        self::$site_path = self::RemoveSlash($site_path);
    }

    public function __toString(){
        return self::$site_path;
    }

    public static function RemoveSlash($string){
        if($string[strlen($string) -1] == '/'){
            $string = rtrim($string, '/');
        }

        return $string;
    }

    protected static function controller($controller_file){
		$start_function = "Show"; //defult function in class controller = Show
        $CountSegment = count(self::CountSegments());
        $controller_file = ucfirst($controller_file);
        
		if($controller_file != NULL){

            // Show page controller class
            //echo $controller_file."<br>";
            if(!file_exists(getcwd().DIRECTORY_SEPARATOR."core/controllers".DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $controller_file).".php")){
                Internal_error::warning($controller_file.".php");
            }else{	// Else file exists
                $ref = new \ReflectionClass("Gaia\\core\\controllers\\". $controller_file);
                $c = $ref->newInstance();
            }

 
            //echo $CountSegment."<br>";

            // Show the function in controller class
            if($CountSegment <= 1){ // if segment count is minor of 1
                $start_function = $start_function;
                $c->Index['function0'] = $start_function;
            }else{

                // Show last segment number
                //echo self::segment($CountSegment);
                $i = 0;
         
                foreach(self::CountSegments() as $key => $val){

                    if($key > 1 && $val != $controller_file){

                        if(method_exists($c, $val)){	//is function in class
                            $funcArray[$key] = $val;
                            $start_function = $val;
                            $c->Index['function'.$key] = $val;
                        }else{
                            if(property_exists($c, 'Index')){	//is variable in class
                                $c->Index['var'.$i] = $val;
                            }
                        }

                        $i++;
                    }
                   
                }

                
            }
            

            $c->Index = (object) @$c->Index;
			return $c->{$start_function}();
                
        }else{
            //Show error if controller file not exist
            Internal_error::warning($controller_file.".php");
        }

    }
    
    public function Start($arr = null){
		
        if(!self::segment(1) && self::CountSegments() != 0){
            $page = 'Index';
        }else{
            $page = self::segment(1);
        }
        
		if($arr){
			foreach($arr as $key => $val){
				$divideURL = explode(';', $val);
				$url = $divideURL[0];
				$cdx = $divideURL[1];
				
				$url = explode('/', $url);
				//$_GET['auth'] = $url[1];
				if(@$_GET['auth'] == $url[1]){
					//explode @
					$x = explode("@", $cdx);
					
					$fileAndClass = $x[0];
					$function = $x[1];

					if(!file_exists(getcwd().DIRECTORY_SEPARATOR."core/classes".DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $fileAndClass).".php")){
						Internal_error::warning($fileAndClass.".php");
					}else{	// Else file exists
						$ref = new \ReflectionClass("Gaia\\core\\classes\\". $fileAndClass);
						$c = $ref->newInstance();
                        return $c->{$function}();
					}
					
				}
				
			}
			
		}
		return self::controller($page);
		
    }

    public static function CountSegments(){
        $url = str_replace(self::$site_path, '', $_SERVER['REQUEST_URI']);
        $url = explode('/', $url);
        return array_filter($url, 'strlen');
    }

    public static function segment($segment){
        $url = str_replace(self::$site_path, '', $_SERVER['REQUEST_URI']);
        $url = explode('/', $url);

        if(isset($url[$segment])){
            return $url[$segment];
        }else{
            return false;
        }
    }
	
	

}

Route_Beta::$_instance = function($site_path){ return new Route_Beta($site_path); }; 
