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
	$routes['settings/school'] = "home/settings_school";
	$routes['settings/notice'] = "home/settings_notice";

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
	$routes['profile/$1/$2'] = "user/profile/$1/$2";

	// admission routes
	$routes['student/registration'] = "admission/new_admission";
	$routes['admission/list'] = "admission/list";
	$routes['admission/list/$1'] = "admission/list/$1";
	$routes['admission/delete/$1'] = "admission/delete/$1";
	$routes['admission/view/$1'] = "admission/view_admission/$1";

	// teacher routes
	$routes['teacher/list'] = "teacher/teacher_list_view";
	$routes['teacher/registration'] = "teacher/new_teacher";
	$routes['teacher/update'] = "teacher/teacher_list_update";

	//classroom routes
	$routes['classroom/list'] = "classroom/classroom_list";
	$routes['classroom/update/$1'] = "classroom/update/$1";
	$routes['classroom/registration'] = "classroom/registration";
	$routes['classroom/student/list'] = "classroom/student_list";
	$routes['classroom/student/list/$1'] = "classroom/student_list/$1";
	$routes['classroom/student/add/$1'] = "classroom/add_student/$1";
	$routes['classroom/timetable/$1'] = "classroom/timetable/$1";

	// subject routes
	$routes['subject/list'] = "subject/subjectnew_view";
	$routes['subject/registration'] = "subject/subjectnew_add";
	$routes['subject/update'] = "subject/subjectnew_update";

	// student route
	$routes['student/list'] = "student/list";
	$routes['student/timetable/view'] = "student/timetable_view";
	$routes['student/timetable/view/$1'] = "student/timetable_view/$1";
	$routes['student/exam/$1'] = "student/exam/$1";
	$routes['student/delete/$1'] = "admin/student_delete/$1";

	//admin route --> only admin can access
	$routes['userrole'] = "userrole/permission";
	$routes['userrole/permission'] = "userrole/permission";
	$routes['userrole/permission/update'] = "userrole/update_permission";
	$routes['userrole/create'] = "userrole/create";

	// parent routes
	$routes['parent/list'] = "Parents/list";
	
	// interview routes
	$routes['interview/set/$1'] = "interview/set/$1";
	$routes['interview/list'] = "interview/list";
	$routes['interview/view/$1'] = "interview/view_admission/$1";
	

	// interview panel routes
	$routes['interviewpanel/list'] = "interviewpanel/list";
	$routes['interviewpanel/delete/$1'] = "interviewpanel/delete/$1";
	$routes['interviewpanel/view/$1'] = "interviewpanel/view_panel/$1";
	$routes['interviewpanel/timetable/$1'] = "interviewpanel/timetable/$1";
	$routes['interviewpanel/registration'] = "interviewpanel/view_panel";

	// attendance routes
	$routes['attendance/classroom/list'] = "attendance/classroom_list";
	$routes['attendance/classroom/view/$1'] = "attendance/classroom_view/$1";
	$routes['attendance/teacher/list'] = "attendance/teacher_list";
	$routes['attendance/teacher/view/$1'] = "attendance/teacher_view/$1";

	// define as a global variable. Don't delete this
	$GLOBALS['routes'] = $routes;