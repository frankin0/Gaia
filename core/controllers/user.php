<?php



Gaia::get('/signin', function(){
	return view('Main::login'); 
});


Gaia::get('/home', function(){
	return view('Main::main'); 
});

Gaia::get('/signup', function(){
	return view('Main::register'); 
});
