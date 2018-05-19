<?php
namespace Gaia\core;

use Gaia\core\classes\Tools;
use Gaia\core\classes\Router;
use Gaia\core\classes\Internal_error;
use Gaia\core\classes\Template;
use Gaia\libraries\Gaia_Templater\GaiaTemplate;
use Gaia\libraries\Console\ConsoleTool;
use Gaia\core\classes\Table_call;
use Gaia\core\controllers;

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
	
	private static $instance = NULL;
	
	
	private static $prfx;
	
	
	public static $ini;
	
	
	private static $s;
	
	
	private static $name_query;
	
	
	private static $engine_1_, $engine_2_;
	
	

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
	
	public function __construct(){
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		
		if(!isset($_SESSION)) session_start();
				
		$classes = array(
			'Tools.Class.php' => array(
				'file_class' => 'core/classes/Tools.Class.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'Router.Class.php' => array(
				'file_class' => 'core/classes/Router.Class.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'Internal_error.Class.php' => array(
				'file_class' => 'core/classes/Internal_error.Class.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'Template.Class.php' => array(
				'file_class' => 'core/classes/Template.Class.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'Render.php' => array(
				'file_class' => 'libraries/Gaia_Templater/Render.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'Console.Class.php' => array(
				'file_class' => 'libraries/Console/Console.Class.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'Table.Class.php' => array(
				'file_class' => 'core/classes/Table.Class.php',
				'instantiable' => false,
				'isAutoloader' => true
			),
			'controllers' => array(
				'file_class' => 'core/controllers/',
				'instantiable' => true,
				'isAutoloader' => true
			)
		);
		
		self::$ini = require_once(__DIR__.'/../core/Class.ini.php');
		
		@date_default_timezone_set(self::$ini['date_default_timezone_set']);
		
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
				echo "Error: can't load <b>$class</b> file: <i>$fileClass</i> <br>";
			}
		});

			
		if(self::$ini['debug']){
			new ConsoleTool();
		}
		/*foreach($classes as $key => $class){
			
			
			if(self::$ini['cache_enabled']){
				$class_file = $class['file_class'];
				$isAutoloader = $class['isAutoloader'];
				$instantiable = $class['instantiable'];
				
				$cache_dir[$key] = array(
					"instantiable" => $instantiable,
					"isAutoloader" => $isAutoloader,
					"file_class" => $class_file
				);
				file_put_contents($file_cache, serialize($cache_dir));
			}
			
			if($class['isAutoloader']){
				if(is_dir($class['file_class'])){
					foreach(preg_grep('/^([^.])/', scandir('core/controllers/')) as $files) {
						if(file_exists('core/controllers/'.$files)){
							require_once('core/controllers/'.$files);
						}
					}
				}else if(file_exists($class['file_class'])){
					require_once($class['file_class']);
				}
			}
			
		}*/
		
		
	}
	

	public static function migration_ (){
		
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
			
			
			
		}else{
			echo "Error <b>201</b>: Migration type unknown [ ".self::$ini['migration']['migration_type']." ] in [out or in]!";
		}
	}
	
	public static function select($table_select = '*',string $table_string, $execute, callable $callback){
		
		if($execute == '' || $execute == null || $execute == [] || $execute == false){
			$execute = [];
		}
		
		$array_group = [];
		
		try {
			$stmt = self::$instance->prepare('select '.$table_select.' from '.self::$prfx.$table_string);
			$stmt->execute($execute);
			
			foreach($stmt as $row) { $array_group[] = $row; }
			
			$callback($array_group);
		
		} catch (Exception $e) {
			self::$instance = null;	
			$callback("Oh noes! There's an error in the query: ". $e);
		}
	}
	
	public static function insert($table_string, $data, $values, $execute, callable $callback){
		
		if($execute == '' || $execute == null || $execute == [] || $execute == false){
			$execute = [];
		}
		
		try {
			$stmt = self::$instance->prepare('insert into '.self::$prfx.$table_string.' ('.$data.') values('.$values.')');
			$stmt->execute($execute);
		} catch (Exception $e) {
			self::$instance = null;	
			$callback("Oh noes! There's an error in the query: ". $e);
		}
		
	} 
	
	
	public function engine($var, $var2 = 'utf8'){ 
		self::$engine_1_ = $var;
		self::$engine_2_ = $var2;
		return new self;
	}
	
	
	public static function table($name_t, callable  $callback){
		self::databaseConnection();
		try {
			
			$matches = array(
				'string' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} VARCHAR({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'text' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} TEXT {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				}, 
				'autoIncrement' => function($name, $str = 11, $pred = 'NOT NULL AUTO_INCREMENT', $primary_key = true){
					if($primary_key == true){
						$pk = "PRIMARY KEY"; 
					}else{ $pk = ""; }
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} INT({$str}) {$pred} {$pk},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'integer' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} INT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'datetime' => function($name, $str = '', $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} DATETIME {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'date' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} DATE {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'timestamp' => function($name, $pred = 'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'){
					if(!empty($name)){ self::$s .= "{$name} TIMESTAMP {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'time' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} TIME {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'year' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} YEAR(4) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'tinyInteger' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} TINYINT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'smallInteger' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} SMALLINT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'mediumInteger' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} MEDIUMINT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'bigInteger' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} BIGINT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'decimal' => function($name, $str = '10,0' ,$pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} DECIMAL({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'float' => function($name ,$pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} FLOAT {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'double' => function($name ,$pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} DOUBLE {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'bit' => function($name, $str = 11 ,$pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} BIT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'tinyInteger' => function($name, $str = 11 ,$pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} TINYINT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'bigInteger' => function($name, $str = 11 ,$pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} BIGINT({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'char' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} CHAR({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'tinytext' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} TINYTEXT {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'mediumText' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} MEDIUMTEXT {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'longText' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} LONGTEXT {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'binary' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} BINARY({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'varbinary' => function($name, $str = 11, $pred = 'NOT NULL'){
					if(!empty($name) && !$str < 1){ self::$s .= "{$name} VARBINARY({$str}) {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'tinyblob' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} TINYBLOB {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'mediumblob' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} MEDIUMBLOB {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'blob' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} BLOB {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'longblob' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ self::$s .= "{$name} LONGBLOB {$pred},"; }else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'enum' => function($name, $enum = array(), $set = '', $pred = 'NOT NULL'){
					if(!empty($enum) && !empty($name)){ 
						$enum_ = "'".implode("','",$enum)."'";
						if(empty($set)){ $set_ = ""; }else{ $set_ = "DEFAULT '{$set}'"; }
						
						self::$s .= "{$name} ENUM({$enum_}) {$pred} {$set_},";
					}else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				},
				'set' => function($name, $pred = 'NOT NULL'){
					if(!empty($name)){ 
						self::$s .= "{$name} SET {$pred},";
					}else{ echo "Error <b>#200</b> attribute name not defined<br>"; }
				}
			);
			
			
			$callback($matches);
			
			
			
			if(isset(self::$s)){
				self::$name_query = $name_t;
				return new self;
			}
			
			//return $bgj;
		} catch (Exception $e) {
			self::$instance = null;	
			return ("Oh noes! ". $e);
		}
	}	
	
	
	public static function ok(){
		
		try{
			
			if(empty(self::$engine_1_)){
				$engine_1 = 'MyISAM';
			}else{
				$engine_1 = self::$engine_1_;
			}
			
			if(empty(self::$engine_2_)){
				$engine_2 = 'utf8';
			}else{
				$engine_2 = self::$engine_2_;
			}
			
			if(!empty(self::$s)){
				self::$instance->exec("CREATE TABLE IF NOT EXISTS ".self::$prfx.self::$name_query."( ".trim(self::$s,',')." ) ENGINE={$engine_1} DEFAULT CHARSET={$engine_2};");
				return "Dump Success!<br>";
			}
			
			
		} catch (Exception $e) {
			self::$instance = null;	
			echo ("Oh noes! There's an error in the query: ". $e);
		}
		
	}
	
	public static function update($table_string, $values, $execute, callable $callback){
		
		if($execute == '' || $execute == null || $execute == [] || $execute == false){
			$execute = [];
		}
		
		try {
			$stmt = self::$instance->prepare('update '.self::$prfx.$table_string.' set '.$values);
			$stmt->execute($execute);
		} catch (Exception $e) {
			self::$instance = null;	
			$callback("Oh noes! There's an error in the query: ". $e);
		}
	}
	
	public static function deletequery($table_string, $execute, callable $callback){
		try {
			$stmt = self::$instance->prepare('delete from '.self::$prfx.$table_string);
			$stmt->execute($execute);
		} catch (Exception $e) {
			self::$instance = null;	
			$callback("Oh noes! There's an error in the query: ". $e);
		}
	}
	
	public static function access_guest($userData = array()){		
		$uid = $userData['oauth_uid'];
		$oauth_provider = $userData['oauth_provider'];
		$email = $userData['email'];
		$username = $userData['username'];
		
		if($oauth_provider == 'facebook'){
			$check = self::$instance->prepare('select * from `'.self::$db_pefix.'Users` WHERE oauth_uid=:uid and oauth_provider=:oauth_provider');
			$check->execute(array('uid' => $uid, 'oauth_provider' => $oauth_provider));
			$row = $check->fetch();
			if($row != false){ 
				# User is already present
				session_start();
				$_SESSION['user_loged'] = $row['userID'];
				$_SESSION['oauth_id'] = $uid;
				$_SESSION['username'] = $row['userName'];
				$_SESSION['email'] = $email;
				$_SESSION['oauth_provider'] = $oauth_provider;
				echo '<meta http-equiv="refresh" content="0;URL=\'./\'" />';
			} else { 
				#user not present. Insert a new Record				
				$stmt = self::$instance->prepare('insert into '.self::$db_pefix.'Users(oauth_provider, oauth_uid, userName, userEmail, userIP, userDataReg, userDataLastLogin, userStat) values (:oauth_provider, :uid, :username, :email, :ip, :datareg, :datalastlogin, :status) ');
				$stmt->execute(array('oauth_provider' => $oauth_provider, 'uid' => $uid, 'username' => $username,'email' => $email, 'ip' => $_SERVER['REMOTE_ADDR'], 'datareg' => date("Y-m-d H:i:s"), 'datalastlogin' => '0000-00-00 00:00:00' ,'status' => 1));
				$id_user_Reg = self::$instance->lastInsertId();
				
				$stmt2 = self::$instance->prepare('insert into '.self::$db_pefix.'UsersPersonal(UserID, UserPIVA,UserRealName, UserRealSurname) values (:uid, :p_iva, :name, :surname) ');
				$stmt2->execute(array('uid' => $id_user_Reg,'p_iva' => '', 'name' => $userData['first_name'], 'surname' => $userData['last_name']));
				
				session_start();
				$_SESSION['user_loged'] = $id_user_Reg;
				$_SESSION['oauth_id'] = $uid;
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$_SESSION['oauth_provider'] = $oauth_provider;
				
				echo '<meta http-equiv="refresh" content="0;URL=\'./\'" />';
			}
		}else if($oauth_provider == 'google'){
			$check = self::$instance->prepare('select * from `'.self::$db_pefix.'Users` WHERE oauth_uid=:uid and oauth_provider=:oauth_provider');
			$check->execute(array('uid' => $uid, 'oauth_provider' => $oauth_provider));
			$row = $check->fetch();
			if($row != false){ 
				# User is already present
				session_start();
				$_SESSION['user_loged'] = $row['userID'];
				$_SESSION['oauth_id'] = $uid;
				$_SESSION['username'] = $row['userName'];
				$_SESSION['email'] = $email;
				$_SESSION['oauth_provider'] = $oauth_provider;
				echo '<meta http-equiv="refresh" content="0;URL=\'./\'" />';
			} else { 
				#user not present. Insert a new Record				
				$stmt = self::$instance->prepare('insert into '.self::$db_pefix.'Users(oauth_provider, oauth_uid, userName, userEmail, userIP, userDataReg, userDataLastLogin, userStat) values (:oauth_provider, :uid, :username, :email, :ip, :datareg, :datalastlogin, :status) ');
				$stmt->execute(array('oauth_provider' => $oauth_provider, 'uid' => $uid, 'username' => $username,'email' => $email, 'ip' => $_SERVER['REMOTE_ADDR'], 'datareg' => date("Y-m-d H:i:s"), 'datalastlogin' => '0000-00-00 00:00:00' ,'status' => 1));
				$id_user_Reg = self::$instance->lastInsertId();
				
				$stmt2 = self::$instance->prepare('insert into '.self::$db_pefix.'UsersPersonal(UserID, UserPIVA,UserRealName, UserRealSurname) values (:uid, :p_iva, :name, :surname) ');
				$stmt2->execute(array('uid' => $id_user_Reg,'p_iva' => '', 'name' => $userData['first_name'], 'surname' => $userData['last_name']));
				
				session_start();
				$_SESSION['user_loged'] = $id_user_Reg;
				$_SESSION['oauth_id'] = $uid;
				$_SESSION['username'] = $username;
				$_SESSION['email'] = $email;
				$_SESSION['oauth_provider'] = $oauth_provider;
				
				echo '<meta http-equiv="refresh" content="0;URL=\'./\'" />';
			}
		}else if($oauth_provider == 'FreeCket'){
			try{
				$passwd = preg_replace('/[^A-Za-z0-9\-]/', '', hash('sha512', $userData['password']));
				$check = self::$instance->prepare('select userID from '.self::$db_pefix.'Users where userEmail=:email and userPassword=:pswd limit 1');
				$check->execute(array('email' => $email, 'pswd' => $passwd));
				$row = $check->fetch();
				if($row != false){
					session_start();
					$_SESSION['user_loged'] = $row['userID'];
					$_SESSION['oauth_provider'] = $oauth_provider;
					echo "_true_";
				}else{
					echo "_false_";
				}
				
			}catch (Exception $e) {		
				die("Oh noes! There's an error in the query: " . $e);
			}	
			self::$instance = null;
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


Gaia::databaseConnection();
new Gaia();