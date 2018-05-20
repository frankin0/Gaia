<?php
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

 

class Tools extends Gaia{

	public static function login_google($code_){
		session_start();

		//Include Google client library 
		require_once('library/Google/Google_Client.php');
		require_once('library/Google/contrib/Google_Oauth2Service.php');

		/*
		 * Configuration and setup Google API
		 */
		$clientId = ''; //Google client ID
		$clientSecret = ''; //Google client secret
		$redirectURL = 'https://demo.espoweb.com/240217/?login&oauth_provider=google'; //Callback URL

		//Call Google API
		$gClient = new Google_Client();
		$gClient->setApplicationName('FreeCket');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectURL);

		$google_oauthV2 = new Google_Oauth2Service($gClient);



	if(isset($code_)){
			$gClient->authenticate($code_);
			$_SESSION['token'] = $gClient->getAccessToken();
			echo '<meta http-equiv="refresh" content="0;URL=\''.filter_var($redirectURL, FILTER_SANITIZE_URL).'\'" />';
		}

		if(isset($_SESSION['token'])){
			$gClient->setAccessToken($_SESSION['token']);
		}

		if($gClient->getAccessToken()){
			
			$gpUserProfile = $google_oauthV2->userinfo->get();
				
				
			//Insert or update user data to the database
			$gpUserData = array(
				'oauth_provider'=> 'google',
				'oauth_uid'     => $gpUserProfile['id'],
				'first_name'    => $gpUserProfile['given_name'],

			'last_name'     => $gpUserProfile['family_name'],
				'username'    	=> $gpUserProfile['given_name'].'_'.$gpUserProfile['family_name'],
				'email'         => $gpUserProfile['email'],
			);
			
			echo Gaia::access_guest($gpUserData);
		} else {
			$authUrl = $gClient->createAuthUrl();
			echo '<meta http-equiv="refresh" content="0;URL=\''.filter_var($authUrl, FILTER_SANITIZE_URL).'\'" />';
		}
	}
	
	public static function login_facebook(){
		require_once('library/Facebook/facebook.php');

		$facebook = new Facebook(array(
			'appId' => '',
			'secret' => ''
		));

		$user = $facebook->getUser();

		if($user){
			try{
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture,name');
			}catch(FacebookApiException $e){
				error_log($e);
				$user = null;
			}
			if(!empty($user_profile)){
		  
				$fbUserData = array(
					'oauth_provider'=> 'facebook',
					'oauth_uid'     => $user_profile['id'],
					'email'         => $user_profile['email'],
					'first_name'    => $user_profile['first_name'],
					'last_name'     => $user_profile['last_name'],
					'username'		=> preg_replace('/\s+/', '_', $user_profile['name'])
				);
				echo Gaia::access_guest($fbUserData);
				
			}else{
				# For testing purposes, if there was an error, let's kill the script
				die("There was an error.");
			}
		}else{
			# There's no active session, let's generate one
			$login_url = $facebook->getLoginUrl(array( 'scope' => 'email'));
			echo '<meta http-equiv="refresh" content="0;URL=\''.$login_url.'\'" />';
		}
	}
	
	public static function sendMail($nameSite, $emailTo, $emailFrom, $object, $message_client){

		$subject = $object;
		$headers = "From: ".$nameSite." <$emailFrom>\r\n";
		$headers .= "Reply-To: ".$nameSite." <".$emailFrom.">\r\n";
		$headers .= "Return-Path: ".$nameSite." <".$emailFrom.">\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Organization: ".$nameSite."\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "Content-Transfer-Encoding: 7bit\n\n";

		$message = "
		<html>
			<body>
				<p>
					".$message_client."
				</p>
			</body>
		</html>
		";
		mail($emailTo, $subject, $message, $headers);
		if(mail){
			echo "_SUCCESS_";
		}else{
			echo "_ERROR_EMAIL_PROV_";
		}
	}


}