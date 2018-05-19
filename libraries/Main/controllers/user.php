<?php
Gaia::get('/signin', function(){ return User::signin_view(); });

Gaia::get('/home', function(){	return User::home(); });

Gaia::get('/signup', function(){ return User::signup_view(); });

Gaia::get('/logout', function(){
	// start session
	session_start();
	// Destroy user session
	unset($_SESSION['user_id']);
	// Redirect to index.php page
	header("Location: /signin");
});


Router::post('/reg', function($res){
	 return User::signUp($res);
});

Router::post('/log', function($res){
	 return User::signIn($res);
});
