<?php

namespace Gaia\core\classes;
use Gaia\core\Gaia;
use Gaia\core\classes\SystemClass;
use Gaia\core\config\Route_Beta;
use Gaia\core\config\Internal_error;
use Gaia\core\classes\FacebookClass;
use Gaia\core\classes\GoogleClass;
use Gaia\core\classes\UserClass;
use Gaia\core\classes\MailClass;

class AuthClass extends Gaia{

    public static $_instance;
    public static $user = null;
    
    public static function PasswordCrypt($password){
        return preg_replace('/[^A-Za-z0-9\-]/', '', hash('sha512', $password));
    }
	
	public function __construct(){
		//parent;
	}

    public static function Instance(){
        return self::$_instance; 
    }

    public function getUserIP(){
        switch(true){
          case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
          case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
          case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
          default : return $_SERVER['REMOTE_ADDR'];
        }
    }
	
	protected static function getCurlData($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		$curlData = curl_exec($curl);
		curl_close($curl);
		return $curlData;
	}

	protected static function generateRandomPassword() {
		//Initialize the random password
		$password = '';

		//Initialize a random desired length
		$desired_length = rand(8, 12);

		for($length = 0; $length < $desired_length; $length++) {
			//Append a random ASCII character (including symbols)
			$password .= chr(rand(32, 126));
		}

		return $password;
	}
    public function getUser(){
        if( isset($_SESSION["user_loged"]))
            self::$user = new UserClass($_SESSION["user_loged"]);

        return self::$user;
    }

    public function Logout(){
        self::$user= null;
        session_destroy();
        session_start();
        header("Location: ".SystemClass::Instance()->syUrl);
    }

	
	public function loginGaia($email, $password){ 
		
		
		$UserData = array(
			'oauth_provider'=> 'gaia',
			'email'         => $email,
			'password'		=> $password,
		);
		echo self::checkUser($UserData);
	}

    public function registerUser($recaptcha, $email, $password, $piva_enum, $reg_stat){
		
		if(!empty($recaptcha)){
			$google_url="https://www.google.com/recaptcha/api/siteverify";
			$secret='6LecEGEUAAAAAKynhG-wsTqH5k7slY67EqVIoVjs';
			$ip=$_SERVER['REMOTE_ADDR'];
			$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
			$res=self::getCurlData($url);
			$res= json_decode($res, true);
			//reCaptcha success check 
			if($res['success']){
				
				
				// captacha validated successfully.
				$check = parent::$instance->prepare('select userEmail from '.parent::$prfx.'Users where userEmail=:email');
				$check->execute(array('email' => $email));
				$row = $check->fetch();

				if($row == false){
					$passwd = self::PasswordCrypt($password);
					$stmt = parent::$instance->prepare('insert into '.parent::$prfx.'Users(userName, userPassword, userEmail, oauth_provider, userIP, userDataReg, userDataLastLogin, userStat) values (:username, :pass, :email, :oauth_provider, :ip, :datareg, :datalastlogin, :status) ');
					$stmt->execute(array('username' => '','pass' => $passwd,'email' => $email, 'oauth_provider' => 'gaia', 'ip' => self::getUserIP(), 'datareg' => date("Y-m-d H:i:s"), 'datalastlogin' => '0000-00-00 00:00:00' ,'status' => 1));

					$id = parent::$instance->lastInsertId();

					if($reg_stat == 2){
						$prtners = 3;
					}else{ $prtners = 0; }
					
					
					sleep(1);
					//if($success){
						if(!session_id()){ 
							session_start();
						}
						$UserData = array(
							'oauth_provider'=> 'gaia',
							'email'         => $email,
							'password'		=> $password,
						);
						
						$message_ = "<h3>Benvenuto ".$email.", </h3>
								<p>grazie per esserti registrato su ".SystemClass::Instance()->syName.", troverai tutto il necessario nel tuo portale, all'indirizzo ".SystemClass::Instance()->syUrl."#signin, se hai bisogno di aiuto hai a tua disposizione un'area gratuita per il supporto ed una pagina adibita all'Aiuto su ".SystemClass::Instance()->syUrl."policies</p>
								</p>
								<p><b>Ip: ".self::getUserIP()."</b></p>
								</p>
								<small>Se non hai efettuato alcuna registrazione ti chiediamo gentilmente di contattarci sulla pagina ufficiale ".SystemClass::Instance()->syName." su facebook, all'indirizzo email <b>".SystemClass::Instance()->sySupportMail."</b> o al numero +39 351 966 2296 dal Lunedì al Venerdì alle ore 9:00 / 13:00.</small>
								<p />";
					
						echo MailClass::Send($email, SystemClass::Instance()->syPrivacyMail, "Registrazione su ".SystemClass::Instance()->syName, $message_);
						
						
						echo self::checkUser($UserData);
					//}
				}else{
					echo "error_user_exists";
				}
				
				
			}else{
				echo "error_recaptcha";
			}
		}else{
			echo "error_recaptcha";
		}
    }
	
	
    protected function checkUser($userData = array()){ 
		if(empty($userData)) echo "Error: Token expired, please redirect to ".SystemClass::Instance()->syUrl;
		
        $uid = @$userData['oauth_uid'];
		$oauth_provider = @$userData['oauth_provider'];
		$email = @$userData['email'];
        $username = @$userData['username'];
        
        switch($oauth_provider){
            case "facebook":
				$_SESSION['fcb_response_arrayLog'] = array();
                break;
            case "google":
				
				$_SESSION['ggl_response_array'] = array();
                break;
            case "gaia":
			
				$passwd = self::PasswordCrypt($userData['password']);

				$check = parent::$instance->prepare('select userID from '.parent::$prfx.'Users where userEmail=:email and userPassword=:pswd and oauth_provider=:prv limit 1');
				$check->execute(array('email' => $email, 'pswd' => $passwd, 'prv' => 'gaia'));
				$row = $check->fetch(); 
				if($row != false){
                    if(!session_id()){ 
						session_start();
					}
					$_SESSION['user_loged'] = $row['userID'];
					$_SESSION['oauth_provider'] = $oauth_provider;
					echo "_true_";
				}

                break;
        }
	}
	

	public static function restoreAutomaticallyPassword($PID){
		if($PID == null)
			throw new \Exception("invalid code $PID");
		
		$checkRestore = parent::$instance->prepare('select * from '.parent::$prfx.'restorePassword where resPubID=?');
		$checkRestore->execute([$PID]);
		$rowRestore = $checkRestore->fetch();
		if($rowRestore != false){
			$newPW = self::generateRandomPassword();
			//insert value on db
			$passwd = self::PasswordCrypt($newPW);

			$checkUser = parent::$instance->prepare('select userPassword, userID from '.parent::$prfx.'Users where userEmail=? and oauth_provider=? ');
			$checkUser->execute([$rowRestore['resEmail'], 'gaia']);
			$rowcheckUser = $checkUser->fetch();
			if($rowcheckUser != false){
				if($rowcheckUser['userPassword'] != $passwd){
					$smtp = parent::$instance->prepare('update '.parent::$prfx.'Users set userPassword=? where userID=? and oauth_provider=? ');
					$smtp->execute([$passwd, $rowcheckUser['userID'], 'gaia']);
					
					$delI = parent::$instance->prepare('update '.parent::$prfx.'restorePassword set resStatus=? where resEmail=? and resPubID=?');
					$delI->execute([1,$rowRestore['resEmail'], $PID]);
					
					$message_ = "<h3>Gentile ".$rowRestore['resEmail'].", </h3>
						<p>Abbiamo provvisto al cambio della tua password in modo automatico. Se non hai rischiesto tu il cambio password allora contattarci sulla pagina ufficiale ".SystemClass::Instance()->syName." di Facebook o all'indirizzo email <b>".SystemClass::Instance()->sySupportMail."</b> subiuto dopo aver ricevuto questa Email. </p>
						</p>
							<p><b>Ip: ".self::getUserIP()."</b></p>
							<p><b>Password: ".$newPW."</b></p>
						</p>
						<p><small>Se non hai richiesto il cambio password ricorda di contattarci entro 5 giorni o non sarà più possibile risalire al richiedente dello smarrimento password.</small></p>
						";
					
					echo MailClass::Send($rowRestore['resEmail'], SystemClass::Instance()->syPrivacyMail, "Cambio password di ".SystemClass::Instance()->syName, $message_);
					
					header("Location: ". SystemClass::Instance()->syUrl);
				}else{
					Internal_error::error("The password entered corresponds to the old password!");
				}
			}else{
				Internal_error::error("The wanted user does not exist in our databases!");
			}
			
			
		}else{
			Internal_error::error("Reset code is not valid!");
		}
	}

    public function restorePassword($recaptcha, $email){
        if(!empty($recaptcha)){
			$google_url="https://www.google.com/recaptcha/api/siteverify";
			$secret='6LecEGEUAAAAAKynhG-wsTqH5k7slY67EqVIoVjs';
			$ip=$_SERVER['REMOTE_ADDR'];
			$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
			$res=self::getCurlData($url);
			$res= json_decode($res, true);
			//reCaptcha success check 
			if($res['success']){
				
				$check = parent::$instance->prepare('select userEmail from '.parent::$prfx.'Users where userEmail=:email and oauth_provider=:provider');
				$check->execute(array('email' => $email, "provider" => 'gaia'));
				$row = $check->fetch();

				if($row != false){
					
					$checkRestore = parent::$instance->prepare('select * from '.parent::$prfx.'restorePassword where resEmail=?');
					$checkRestore->execute([$email]);
					$rowRestore = $checkRestore->fetch();
					if($rowRestore != false){
						$resPubID = $rowRestore['resPubID'];
					}else{
						$resPubID = base64_encode(md5($email."/".time()));
						$stmt = self::$instance->prepare('insert into '.self::$prfx.'restorePassword(resEmail, resIP, resData, resPubID) values (?,?,?,?)');
						$stmt->execute([$email, self::getUserIP(), date("Y-m-d H:i:s"), $resPubID]);
					}
					
					$message_ = "<h3>Gentile ".$email.", </h3>
						<p>E' stato richiesto un ripristino password del tuo account</p>
						</p>
						<p><b>Ip: ".self::getUserIP()."</b></p>
						</p>
						<p>Se non hai richiesto tu il ripristino password premi qui <a href='".SystemClass::Instance()->syUrl."support/restore".self::getUserIP()."'>Supporto</a>.</p>
						<p />
						<p>".SystemClass::Instance()->syUrl."support/restore".self::getUserIP()."</p>
						<p>-----</p>
						<p />
						<p>Se invece hai richiesto tu il ripristino della password clicca Qui</p>
						<p><a href='".SystemClass::Instance()->syUrl."Index/checkRestorePassword/".$resPubID."'>Ripristina Password</a></p>
						<p />
						<p>".SystemClass::Instance()->syUrl."Index/checkRestorePassword/".$resPubID."</p>";
					
					echo MailClass::Send($email, SystemClass::Instance()->syPrivacyMail, "Richiesta password smarrita ".SystemClass::Instance()->syName, $message_);
					
					echo "_true_";
				}else{
					echo "error_user_";
				}
			}else{
				echo "error_recaptcha";
			}
		}else{
			echo "error_recaptcha";
		}
    }

}

AuthClass::$_instance = new AuthClass();