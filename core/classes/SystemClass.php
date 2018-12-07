<?php

namespace Gaia\core\classes;
use Gaia\core\Gaia;

class SystemClass extends Gaia{
	
	public static $_instance;
	
	//Array Instance
	public $syName, $syDesc, $syMaintenance, $sySQL, $syUrl, $syPrivacyMail, $sySupportMail, $syResetPassword, $sySupportPayment;
	
	public static function Instance(Array $_row = null){
        return call_user_func( self::$_instance, $_row);
    }
	
	
	public function __construct(Array $_row = null){
		if( $_row == null ) {
            //global $DB;
			$stmt = parent::$instance->prepare('select * from '.parent::$prfx.'system');
			$stmt->execute();
			$_row = $stmt->fetch();
        }
		$this->syName = $_row["system_name"];
		$this->syDesc = $_row["system_sub_desc"];
		$this->syUrl = $_row["system_url"];
		$this->syPrivacyMail = $_row["system_privacy_email"];
		$this->sySupportMail = $_row["system_support_email"];
		$this->sySupportPayment = $_row["system_support_payment"];
		$this->syMaintenance = $_row["system_close"];
		$this->sySQL = (int)$_row["system_sql"];
		$this->syResetPassword = $_row["system_reset_password"];
	}
	
	public static function queue($e){
		
	}
	
	public static function after($this_, $inthat){
        if (!is_bool(strpos($inthat, $this_)))
        return substr($inthat, strpos($inthat,$this_)+strlen($this_));
	}
	public static function before ($this_, $inthat){
        return substr($inthat, 0, strpos($inthat, $this_));
	}
	public static function between ($this_, $that, $inthat){
        return self::before($that, self::after($this_, $inthat));
	}
    
    public static function maxLength($text, $n_max){
		if(strlen($text) >= $n_max){
			return substr($text, 0, $n_max)."...";
		}else{
			return $text;
		}
	}
	
	public static function get_timeago($time, $fullDate = false, $expire = false, $expire_boolean = false) {
		if($fullDate == true){
			$time_d = substr(date("Y-m-d H:i:s", $time), 11, 5);
			
			if(date("Y", $time) == date("Y")){
				return strftime("%d %B", $time).", ".$time_d;
			}else{
				return strftime("%d %B, %Y", $time)." - ".$time_d;
			}
		}else{
			$cur_time   = time();
			$time_elapsed   = $cur_time - $time;
			
			$today = strtotime(date('M j, Y'));
			$reldays = ($time - $today)/86400;
			$seconds = $time_elapsed;
			$minutes = round($time_elapsed / 60 );
			$hours = round($time_elapsed / 3600);
			

			$time_d = substr(date("Y-m-d H:i:s", $time), 11, 5);
			
			if ($reldays >= 0 && $reldays < 1) {	//Today
				// Seconds
				if($seconds <= 60){
					return "Adesso";
				}else if($minutes <=60){//Minutes
					if($minutes==1){
						return "un minuto f&agrave;";
					}
					else{
						return "$minutes minuti f&agrave;";
					}
				}else if($hours <=24){//Hours
					if($hours==1){
						return "un ora f&agrave;";
					}else if($hours <= 5){
						return "$hours ore f&agrave;";
					}else if($hours > 5){
						//return 'Oggi alle '.$time_d;
						return "$hours ore f&agrave;";
					}
				}
			} else if ($reldays >= 1 && $reldays < 2) {
				return 'Nn';
			} else if ($reldays >= -1 && $reldays < 0) {
				return 'Ieri, '.$time_d;
			}
			 
			if (abs($reldays) < 999999 && $expire_boolean == false) {
				if ($reldays > 0) {
                    $reldays = floor($reldays);
                    
					return ($expire == true ? "Scade tra " : "In ") . $reldays . ' giorn' . ($reldays != 1 ? 'i' : 'o');
				} else {
					$reldays = abs(floor($reldays));
					return ($expire == true ? "Scaduto " : "") .$reldays . ' giorn' . ($reldays != 1 ? 'i' : 'o') . ' f&agrave;';
				}
			}else{
                if ($reldays > 0) {
                    return 'false'; //Scade tra
				} else {
                    return 'true'; //Scaduto
				}
            }
            
            if($expire == false && $expire_boolean == false) {
                if (abs($reldays) < 182) {
                    return ($expire == true ? "Scade " : "").ucwords(utf8_encode(strftime("%A %d %B %Y", $time ? $time : time())));
                    //return date('l, j F',$time ? $time : time());
                } else {
                    return ($expire == true ? "Scaduto " : "").ucwords(utf8_encode(strftime("%A %d %B %Y", $time ? $time : time())));
                    //return date('l, j F, Y',$time ? $time : time());
                }
            }else{
                if (abs($reldays) < 182) {
                    return 'false';
                } else {
                    return 'true';
                }
            }
			
		}
		
    }
	
}

SystemClass::$_instance = function(Array $row = null){ return new SystemClass($row); }; 
