<?php 
	
	// define routes here
	$routes[''] = "home/index";
	$routes['homepage'] = "home/index";
	$routes['school/contact'] = "home/contact";
	$routes['school/about'] = "home/about";
	$routes['login'] = "user/login";
	$routes['dashboard/$1'] = "user/dashboard/$1";
	$routes['dashboard'] = "user/dashboard";



	// define as a global variable
	$GLOBALS['routes'] = $routes;