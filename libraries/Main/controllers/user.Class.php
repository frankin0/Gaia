<?php

class User extends Gaia{


	public function __construct(){



	}

	public static function signUp($postArray){

		if(empty($postArray->username) && empty($postArray->password) && empty($postArray->email)){
			echo json_encode("_error_text_not_found_");
			exit();
		}

		$password = htmlspecialchars($postArray->password);
		$hashed_pass = hash('sha512', $password);

		Gaia::insert('Users', 'UserName,UserPassword, UserEmail, UserRealName, UserDateReg, UserIP, UserDevice, UserType', '?,?,?,?,?,?,?,?', [
										$postArray->username,
										$hashed_pass,
										$postArray->email,
										'',
										date('Y-m-d H:i:s'),
										$_SERVER['REMOTE_ADDR'],
										$_SERVER['HTTP_USER_AGENT'],
										0
									], 'UserName', $postArray->username, function($var){
										echo $var;
									});
	}

	public static function signIn($postArray){
		$password = htmlspecialchars($postArray->password);
		$hashed_pass = hash('sha512', $password);

		if(empty($postArray->username) && empty($postArray->password)){
			echo json_encode(['stat' => '_error_user_not_found_']);
			exit();
		}

		Gaia::select('*','Users', 'where UserName=:a and UserPassword=:b',['a' => $postArray->username, 'b' => $hashed_pass],function($row){
			if($row){
				@session_start();
				$_SESSION['user_id'] = $row[0]['UserID'];
				echo json_encode(['stat' => '_success_']);
				exit();
			}else{
				echo json_encode(['stat' => '_error_user_not_found_']);
				exit();
			}
		});
	}


	public static function signin_view(){
		// Start Session
		@session_start();

		// check user login
		if(!empty($_SESSION['user_id'])){
			header("Location: /home");
			exit();
		}

		return view('Main::login');
	}

	public static function signup_view(){
		// Start Session
		@session_start();

		// check user login
		if(!empty($_SESSION['user_id'])){
		    header("Location: /home");
			exit();
		}

 		return view('Main::register');
	}

	public static function home(){
		// Start Session
		@session_start();

		// check user login
		if(empty($_SESSION['user_id'])){
		    header("Location: /signin");
			exit();
		}
		Gaia::select('*','Users', 'where UserID=:a',['a' => @$_SESSION['user_id']], function($row){
			if($row){
				echo view('Main::main', [
					'username' => $row[0]['UserName'],
					'email' => $row[0]['UserEmail'], 
					'ip' => $row[0]['UserIP'],
					'device' => $row[0]['UserDevice']
				]);
			}
		});

	}

}
