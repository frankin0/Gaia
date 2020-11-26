<?php
namespace Gaia\core;

use Gaia\core\config\Tools;
use Gaia\core\config\Route_Beta;
#use Gaia\core\config\Router;
use Gaia\core\config\Internal_error;
use Gaia\core\config\Template;
use Gaia\core\config\Updater;
use Gaia\core\config\Table_call;
use Gaia\libraries\Gaia_Templater\GaiaTemplate;
use Gaia\libraries\Console\ConsoleTool;
use Gaia\core\controllers;
use Gaia\core\classes\UserClass;
use Gaia\core\classes\AuthClass;
use Gaia\core\classes\SystemClass;


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
 
 
class Gaia{
	
	protected static $instance = NULL;
	
	
	public static $prfx;
	
	
	public static $ini;
	
	
	private static $s;
	
	
	private static $name_query;
	
	
	private static $engine_1_, $engine_2_;
	

	public function __construct(){
		
		if(!isset($_SESSION)) session_start();

		self::$ini = require_once(getcwd().DIRECTORY_SEPARATOR.'core/Class.ini.php');
		

        @date_default_timezone_set(self::$ini['date_default_timezone_set']);
		setlocale(LC_TIME, self::$ini['set_local_lc_time']);
		
		$file_cache = self::$ini['path']['cache']."classloc.cache";
		
		//Migration function
		self::migration_();

		$cache_dir = array();
		
		$classPath = self::$ini['path']['dir']; 
		define("classPath", $classPath);

		spl_autoload_register(function($class){
			if(class_exists($class, false)){
				return;
            }
            
			$class = str_replace("Gaia\\", "", $class);
			$fileClass = classPath.str_replace("\\", DIRECTORY_SEPARATOR, $class).".php";
		
			if(file_exists($fileClass)){ 
				require_once($fileClass);
			}else{
				if(self::$ini['display_errors'] != false){
					echo "Error: can't load <b>$class</b> in file: <i>$fileClass</i> <br>";
				}
			}
		});


		$ip = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
		if(self::$ini['debug']['status']){
			if(self::$ini['debug']['quick_ip']['status']) {
				if(self::$ini['debug']['quick_ip']['myip'] == $ip){
					new ConsoleTool();

					if(self::$ini['debug']['updater']){
						Updater::Start();
					}
				}
			}else{
				new ConsoleTool();

				if(self::$ini['debug']['updater']){
					Updater::Start();
				}
			}
		}
		
		
		error_reporting(E_ALL ^ E_STRICT);
		if(self::$ini['display_errors'] == false){
			ini_set("display_errors", 0);
			ini_set("error_log", self::$ini['path']['dir']."core/php-error.log");
		}else{
			ini_set('display_errors', 1);
			//set_error_handler('Gaia\core\config\Internal_error::ErrorHandler',E_ALL|E_STRICT);

        }
        
        //FetchAllQueue
        if(AuthClass::Instance()->getUser() != null){
            
        }
		
		SystemClass::queue(1);

		Gaia::databaseConnection();
		
	}

	
	public static function databaseConnection(){

		switch(self::$ini['database_connection_default']){
			case self::$ini['connections']['sqlite']['driver']:
				
				try{
					self::$instance = new \PDO("sqlite:".self::$ini['connections']['sqlite']['database']);
					self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				} catch(PDOException $e) {
					echo 'ERROR: ' . $e->getMessage();
				}
				self::$prfx = self::$ini['connections']['sqlite']['prefix'];
				
				break;
			case self::$ini['connections']['mysql']['driver']:
				
				try{
					self::$instance = new \PDO("mysql:host=".self::$ini['connections']['mysql']['host'].";dbname=".self::$ini['connections']['mysql']['database'], self::$ini['connections']['mysql']['username'], self::$ini['connections']['mysql']['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".self::$ini['connections']['mysql']['charset']."'"));
					self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

				} catch(PDOException $e) {
					echo 'ERROR: ' . $e->getMessage();
				}
				self::$prfx = self::$ini['connections']['mysql']['prefix'];
				
				break;
			case self::$ini['connections']['mmsql']['driver']:
				
				try{
					self::$instance = new \PDO("mssql:host=".self::$ini['connections']['mmsql']['host'].";dbname=".self::$ini['connections']['mmsql']['database'], self::$ini['connections']['mmsql']['username'], self::$ini['connections']['mmsql']['password'], array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '".self::$ini['connections']['mmsql']['charset']."'"));
					self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				} catch(PDOException $e) {
					echo 'ERROR: ' . $e->getMessage();
				}
				self::$prfx = self::$ini['connections']['mmsql']['prefix'];
				
				break;
			default:
				echo "<alert>No database selected 404</alert>";
				break;
		}
		
	}


	public static function migration_(){
		self::databaseConnection();

		/*
		 *	MIGRATION ARRAY FILE
		 */
		
		if(self::$ini['migration']['migration_type'] == 'out'){
			
			if(self::$ini['migration']['status'] == true){
				$mig = require_once(__DIR__.'/../core/migrations/migration.php');
				
				
				if(self::$ini['migration']['automatic'] == true){
					
					foreach($mig as $key => $value){
						
						if(file_exists($value['file_class'])){
							require_once($value['file_class']);
							
							new $value['calss_name'];
							
							echo "Migration ".$value['calss_name']." success!<br>";
						}
					}
					
				}else{
					
					foreach($mig as $key => $value){
						if($value['single_mig'] == true){
							if(file_exists($value['file_class'])){
								require_once($value['file_class']);
								
								new $value['calss_name'];
								
								echo "Migration ".$value['calss_name']." success!<br>";
							}
						}
					}
					
				}
			} 
		}else if(self::$ini['migration']['migration_type'] == 'in'){ 
			if(self::$ini['migration']['status'] == true){ 
				//Search sql file in migration directory
				if(file_exists("core/migrations/install.sql")){
					
					$update = "core/migrations/install.sql";
					$qr= file_get_contents($update);
					$qr= preg_replace("'%PREFIX%'", self::$prfx, $qr );
	
					try {
						$stmt = self::$instance->exec($qr);
						$GLOBALS['log'] = array($qr, 'Dump ok.');
						unlink($update);
					}
					catch (PDOException $e)
					{
						$GLOBALS['log'] = array($qr, $e->getMessage());
					}
					

				}else{
					try {
						$stmt = self::$instance->prepare('select * from '.self::$prfx.'system');
						$stmt->execute();
						$row = $stmt->fetch();
						if( $row !=false ){
							$update = "core/migrations/".$row['system_sql'].".sql";
							if( !file_exists($update) ){
								$GLOBALS['log'] = array("DB update '$update' doesn't exist!");
								return;
							}
							$qr= file_get_contents($update);
							$qr= preg_replace( "'%PREFIX%'", self::$prfx, $qr );

							try {
								$stmt = self::$instance->exec($qr);
								$GLOBALS['log'] = array($qr, 'Dump ok.');
							}
							catch (PDOException $e)
							{
								$GLOBALS['log'] = array($qr, $e->getMessage());
							}
						}
					
					} catch (Exception $e) {
						self::$instance = null;	
						$callback("Oh noes! There's an error in the query: ". $e);
						$GLOBALS['log'] = array("Oh noes! There's an error in the query: ". $e);
					}
				}
			}
		}else{
			echo "Error <b>201</b>: Migration type unknown [ ".self::$ini['migration']['migration_type']." ] in [out or in]!";
			$GLOBALS['log'] = array("Error <b>201</b>: Migration type unknown [ ".self::$ini['migration']['migration_type']." ] in [out or in]!");
        }
        
	}
	
	
	public static function get($dir, callable $callback){
		
		if (!function_exists('view')){echo "ss";
			function view($t, $d = array()){ 
				echo Template::view($t, $d);
			}
		}
		
		Router::get($dir, $callback);
		
	}
	
}


class Lang{
	private static $instance;

	public $configuration = array();
	public $lang = '';
	public $tags = array();

	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct(){
		$this->configuration = Config::getInstance();

		if(isset($_GET['lang'])){
			if(in_array($_GET['lang'], $this->configuration->language)){
				$this->lang = $_GET['lang'];
				setcookie('lang', $_GET['lang'], time()+86400, '/');
			}
		}else if(isset($_COOKIE['lang'])){
			$this->lang = $_COOKIE['lang'];
		}else{
			if($this->configuration->defaultlang == '' || $this->configuration->defaultlang == null || $this->configuration->defaultlang == 'undefined'){
				$this->lang = $this->configuration->defaultlang;
			}else{
				$this->lang = $this->configuration->fallback_lang;
			}
			setcookie('lang', $this->lang, time()+86400, '/');
		}

		$this->tags = require(__DIR__.'/../resources/lang/'.$this->lang.'.php');
	}
	public function __destruct(){
		$this->configuration = array();
		$this->lang = '';
		$this->tags = array();
	}
	public function __get($tag){
		return $this->tags[$tag];
	}

}

class Config{
	private static $instance;
	private $cfg = array();

	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function __construct(){
		$this->cfg = require(__DIR__.'/../database/Class.ini.php');
	}
	public function __destruct(){
		$this->cfg = array();
	}
	public function __get($tag){
		return $this->cfg[$tag];
	}
}



new Gaia();