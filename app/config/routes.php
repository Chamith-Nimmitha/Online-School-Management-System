<?php 
	
	/**
	  * define routes here
	  * This roures are check top to bottom. So most specific routes must be in top.
	  */ 

	// homepage routes
	$routes[''] = "home/index";
	$routes['homepage'] = "home/index";
	$routes['school/contact'] = "home/contact";
	$routes['school/about'] = "home/about";
	$routes['settings_school'] = "home/settings_school";

	// login routes
	$routes['login'] = "user/login";
	$routes['forget_password'] = "user/forget_password";
	$routes['verification_code'] = "user/verification_code";
	$routes['change_password'] = "user/change_password";
	$routes['login/$1'] = "user/login/$1";
	$routes['logout'] = "user/logout";

	// common routes
	$routes['dashboard'] = "user/dashboard";
	$routes['dashboard/$1'] = "user/dashboard/$1";
	$routes['profile'] = "user/profile";

	// admission routes
	$routes['student/registration'] = "admission/new_admission";

	// teacher routes
	$routes['teacher_list'] = "teacher/teacher_list_view";
	$routes['teacher_registration'] = "teacher/teacher_registration_form";
	$routes['update_teacher_list'] = "teacher/teacher_list_update";

	//classroom routes
		// write here

	// subject routes
	$routes['subjectnew_view'] = "subject/subjectnew_view";
	$routes['subjectnew_add'] = "subject/subjectnew_add";
	$routes['subjectnew_update'] = "subject/subjectnew_update";

	// parent routes
		//write here

	// interview routes
		// write here

	// define as a global variable. Don't delete this
	$GLOBALS['routes'] = $routes;