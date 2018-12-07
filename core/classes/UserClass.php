<?php

namespace Gaia\core\classes;
use Gaia\core\Gaia;
use Gaia\core\classes\Mobile_Detect;
use Gaia\core\classes\SystemClass;
use Gaia\core\classes\DetectClass;
use Gaia\core\classes\AuthClass;
use Gaia\core\classes\FacebookClass;
use Gaia\core\classes\GoogleClass;

class UserClass extends Gaia{
	
	public static $_instance; 
	
	//Array Instance
	public $userID, $userName, $userEmail, $AdminStatus, $UserAccountsAssociated;
	
	public static function Instantiate( $id, Array $_row= null ){
        return call_user_func( self::$_instance, $id, $_row );
    }
	
	public function __construct($id, Array $_row = null){
		if($id <= 0 && $_row == null)
			throw new \Exception("invalid id $id");

		if($_row==null) {
            //global $DB;
			$stmt = parent::$instance->prepare('select * from '.parent::$prfx.'Users U, '.parent::$prfx.'UsersPersonal P where U.userID=? and U.userID=P.UserID ');
			$stmt->execute([$id]);
			$_row = $stmt->fetch();
		}
		
		$this->userID = (int)$_row["userID"];
		$this->userName = $_row["userName"];
		$this->userEmail = $_row["userEmail"];

        $this->AdminStatus = self::Admin($this->userID);
		
		$this->UserAccountsAssociated = (object)self::AccountAssociated($this->userID);
        		
		//if($this->userStat <= 0) header("Location: ".SystemClass::Instance()->syUrl."Index/Logout");
	}

	public static function Admin($id){

		if($id <= 0 )
			header("Location: ".SystemClass::Instance()->syUrl."Index/Logout# Error invalid ID");
			//throw new \Exception("invalid id $id");
			
		$stmt = parent::$instance->prepare('select * from '.parent::$prfx.'Users U, '.parent::$prfx.'Admins A where A.AdminUserID=? and A.AdminUserID=U.UserID ');
		$stmt->execute([$id]);
		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $row['AdminStatus'];

    }
    
	protected static function getUserIP(){
        switch(true){
          case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
          case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
          case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
          default : return $_SERVER['REMOTE_ADDR'];
        }
    }

	public static function UpdateInfo($arr){
		if(!empty($arr)){
            
            if($arr['type'] == "paypal_mail_update"){
                $paypalMail = $arr['email'];                
                
                $stmt = parent::$instance->prepare('select * from '.parent::$prfx.'Users where userID=? limit 1');
                $stmt->execute([AuthClass::Instance()->getUser()->userID]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                if($row != null){
                    
                    $stmt = parent::$instance->prepare('update '.parent::$prfx.'UsersPersonal set UserEmailPayPal=? where UserID=? ');
                    $stmt->execute([$paypalMail, AuthClass::Instance()->getUser()->userID]);
                    
                    $statArray = array('_SUCCESS_UPDATED_' => true);
                }else{
                    $statArray = array('_SUCCESS_UPDATED_' => false);
                }
            }else if($arr['type'] == "info_update"){
                $email = AuthClass::Instance()->getUser()->userEmail;//$arr['email'];
                $name = $arr['name'];
                $surname = $arr['surname'];
                $fiscal_code = $arr['fiscal_code'];
                
                
                $stmt = parent::$instance->prepare('select * from '.parent::$prfx.'Users where userID=? limit 1');
                $stmt->execute([AuthClass::Instance()->getUser()->userID]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                if($row != null){
                    if(AuthClass::Instance()->getUser()->oauth_provider != 'gaia'){
                        $email = AuthClass::Instance()->getUser()->userEmail;
                    }
                    
                    $stmt = parent::$instance->prepare('update '.parent::$prfx.'Users U, '.parent::$prfx.'UsersPersonal P set U.userEmail=?, P.UserRealName=?, P.UserRealSurname=?, P.UserPIVA=? where U.userID=P.UserID and U.userID=? ');
                    $stmt->execute([$email, $name, $surname, $fiscal_code, AuthClass::Instance()->getUser()->userID]);
                    
                    $statArray = array('_SUCCESS_UPDATED_' => true);
                }else{
                    $statArray = array('_SUCCESS_UPDATED_' => false);
                }
            }
			
			
			echo json_encode($statArray);

		}
    }

    public static function CloseAccount($post){

        if($post['status'] == 'false'){
            $stmt = parent::$instance->prepare('update '.parent::$prfx.'Users set userStat=? where userID=? ');
            $stmt->execute(['0', AuthClass::Instance()->getUser()->userID]);
            $statArray = array('_SUCCESS_UPDATED_' => false);
        }else if($post['status'] == 'true'){
            $stmt = parent::$instance->prepare('update '.parent::$prfx.'Users set userStat=? where userID=? ');
            $stmt->execute(['1', AuthClass::Instance()->getUser()->userID]);
            $statArray = array('_SUCCESS_UPDATED_' => true);
        }else{
            $statArray = array('_SUCCESS_UPDATED_' => '', '_MESSAGE_' => 'Error Input Status');
        }

          
		echo json_encode($statArray);

    }
    
    
    public static function UpdatePassword($post){
        $hold_password = $post['hold_password'];
        $new_password = $post['new_password'];

        $stmt = parent::$instance->prepare('select * from '.parent::$prfx.'Users where userID=? limit 1');
        $stmt->execute([AuthClass::Instance()->getUser()->userID]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($row != null){

            $old_password_encrypt = AuthClass::PasswordCrypt($hold_password);
            $new_password_encrypt = AuthClass::PasswordCrypt($new_password);
            if($old_password_encrypt == $row['userPassword']){
                if($new_password_encrypt != $row['userPassword']) {
                    $stmt = parent::$instance->prepare('update '.parent::$prfx.'Users set userPassword=? where userID=? ');
                    $stmt->execute([$new_password_encrypt, AuthClass::Instance()->getUser()->userID]);
                    $statArray = array('_SUCCESS_UPDATED_' => 'true');
                }else{
                    $statArray = array('_SUCCESS_UPDATED_' => 'false', '_MESSAGE_' => 'Non puoi ottenere una nuova password già utilizzata in precedenza!');
                }
            }else{
                $statArray = array('_SUCCESS_UPDATED_' => 'false', '_MESSAGE_' => 'La vecchia password non è corretta!');
            }
        }else {
            $statArray = array('_SUCCESS_UPDATED_' => 'false', '_MESSAGE_' => 'L\'utente non esiste!');
        }
          
		echo json_encode($statArray);

    }
	
}

UserClass::$_instance = function($id, Array $row = null){ return new UserClass($id, $row); }; 
