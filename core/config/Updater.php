<?php
namespace Gaia\core\config;
use Gaia\libraries\Console\ConsoleTool;

class Updater{
    public static $status = false;    //automatic status = true or false
    public static $obj;

    public function __construct(){

    }

    public static function StringCheck(){
        //Check Update on Official Gaia Site
        //Checking Version 

        $ini = require(__DIR__.'/../../core/Class.ini.php');
       
        //Json recovery 
        $json = file_get_contents($ini['url_updater']);
        $obj = json_decode($json);

        if(version_compare($ini['version'], $obj->official_version, '<')){
            echo "New version available ".$obj->official_version;
        }
    }

    public static function Check(){
        //Check Update on Official Gaia Site
        //Checking Version 
        $ini = require(__DIR__.'/../../core/Class.ini.php');
       
        //Json recovery 
        $json = file_get_contents($ini['url_updater']);
        self::$obj = json_decode($json);

        if(version_compare($ini['version'], self::$obj->official_version, '<')){
            self::Download();
        }
    }

    public static function Start(){
        //Starting Update
        echo '<script>$(document).ready(function() { $("a[href=\'#log\']").click();';
        self::Check();
        echo '});</script>';
    }

    public static function Download(){
        //Overwriting GaiaFramework
        $ini = require(__DIR__.'/../../core/Class.ini.php');        

        try{
            if(file_put_contents(self::$obj->file_name, file_get_contents(self::$obj->file_url))){
                echo '$("#log ul").append("<li>Download package...</li>");';
                self::Overwrite(self::$obj->file_name);
            }
        }catch ( Exception $e ) {
            array_push($GLOBALS['log'], "<b>Error:<b> Downlaod filed!");
        }

        
    }

    public static function delete_files($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file)){
                self::delete_files($file); 
                echo '$("#log ul").append("<li>Removing '.$whatIWant = substr($file, strpos($file, "//") + 1).'/* dir </li>");';
			}else{
				unlink($file); 
                echo '$("#log ul").append("<li>Removing '.$whatIWant = substr($file, strpos($file, "//") + 1).' file</li>");';
			}
		} rmdir($dir); 
	}

    public static function Overwrite($file){  
        if(file_exists($file)){ 
                
            echo '$("#log ul").append("<li>Upload Successfully</li>");';
            echo "scroolLog();";
    
            echo '$("#log ul").append("<li>In Preparation for the unpacking...</li>");';
            echo "scroolLog();";
    
            /**
             *  Unpacking zip rar
             */
    
            $file_name = '' .$file;
            $folder_cryt = 'core/caches/' .md5($file);
            $zip = new \ZipArchive;
            sleep(1);
            $res = $zip->open($file_name);

            if ($res === TRUE) {
                if (!mkdir($folder_cryt, 0777, true)) {
                    echo '$("#log ul").append("<li><font color=\'red\'>Failed to create folders...</font><li>");';
                    echo "scroolLog();";
                }
                $zip->extractTo($folder_cryt);
                $zip->close();
            
                echo '$("#log ul").append("<li>File Unpacking Successfully!</li>");';
                echo "scroolLog();";

                unlink("$file_name");
                
                echo '$("#log ul").append("<li>Copyng Directory!</li>");';
                echo "scroolLog();";

                if(file_exists($folder_cryt."/update.php")){
                    require($folder_cryt."/update.php");
                }

                echo '$("#log ul").append("<li>Plugin Copied!</li>");';
                echo "scroolLog();";

                try {
                    self::delete_files($folder_cryt);
                } catch (Exception $e) {
                    echo '$("#log ul").append("<li><font color=\'red\'>Caught exception: '.$e->getMessage().'!</font><li>");';
                    echo "scroolLog();";
                }

                echo '$("#log ul").append("<li>Refresh in 5 Seconds!</li>");';
                echo "scroolLog();";
                
                echo 'setInterval(function() {  window.location.reload(true); }, 5000);
                ';
                
            }else echo '$("#log ul").append("<li><font color=\'red\'>Errore nell\'apertura</font><li>");'; echo "scroolLog();";
        }
    }


}
