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
	$routes['settings/website'] = "home/setting_website";

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
	$routes['admission/list/$1/$2'] = "admission/list/$1/$2";
	$routes['admission/delete/$1'] = "admission/delete/$1";
	$routes['admission/view/$1'] = "admission/view_admission/$1";

	// teacher routes
	$routes['teacher/list'] = "teacher/list";
	$routes['teacher/csv'] = "teacher/teacher_upload";
	$routes['teacher/registration'] = "teacher/new_teacher";
	$routes['teacher/update'] = "teacher/teacher_list_update";
	$routes['teacher/update/$1'] = "teacher/update_teacher/$1";
	$routes['teacher/delete/$1'] = "teacher/delete/$1";
	$routes['teacher/subject/list'] = "teacher/subject_list";
	$routes['teacher/subject/list/$1'] = "teacher/subject_list/$1";
	$routes['teacher/subject/student/list/$1'] = "teacher/student_list/$1";
	$routes['teacher/subject/timetable/$1'] = "teacher/subject_timetable/$1";
	$routes['teacher/attendance'] = "teacher/attendance";
	$routes['teacher/attendance/$1'] = "teacher/attendance/$1";
	$routes['teacher/classroom/attendance'] = "teacher/classroom_attendance";
	$routes['teacher/interview/panel'] = "teacher/interview_panel_view";
	$routes['teacher/interviews'] = "teacher/interview_list";

	//classroom routes
	$routes['classroom/list'] = "classroom/classroom_list";
	$routes['classroom/delete/$1'] = "classroom/delete/$1";
	$routes['classroom/update/$1'] = "classroom/update/$1";
	$routes['classroom/registration'] = "classroom/registration";
	$routes['classroom/student/list'] = "classroom/student_list";
	$routes['classroom/student/list/$1'] = "classroom/student_list/$1";
	$routes['classroom/student/add/$1'] = "classroom/add_student/$1";
	$routes['classroom/timetable/$1'] = "classroom/timetable/$1";
	$routes['classroom/timetable/view/$1'] = "classroom/timetable_view/$1";
	$routes['classroom/subjects/$1'] = "classroom/subjects/$1";

	// subject routes
	$routes['subject/list'] = "subject/list";
	$routes['subject/import_details'] = "subject/import";
	$routes['subject/registration'] = "subject/registration";
	$routes['subject/update/$1'] = "subject/update/$1";
	$routes['subject/delete/$1'] = "subject/delete/$1";

	// student route
	$routes['student/list'] = "student/list";
	$routes['student/list/$1/$2'] = "student/list/$1/$2";
	$routes['student/timetable/view'] = "student/timetable_view";
	$routes['student/timetable/view/$1'] = "student/timetable_view/$1";
	$routes['student/exam'] = "student/exam_report";
	$routes['student/exam/$1'] = "student/exam_report/$1";
	$routes['student/delete/$1'] = "student/student_delete/$1";
	$routes['student/attendance'] = "student/attendance";
	$routes['student/attendance/$1'] = "student/attendance/$1";
	$routes['student/attendance/report'] = "student/attendance_report";
	$routes['student/subject/list'] = "student/subject_list";
	$routes['student/view/parent/$2'] = "user/profile_view/$1/$2";

	//admin route --> only admin can access
	$routes['userrole'] = "userrole/permission";
	$routes['userrole/permission'] = "userrole/permission";
	$routes['userrole/permission/update'] = "userrole/update_permission";
	$routes['userrole/create'] = "userrole/create";
	$routes['userrole/model/create'] = "userrole/model_create";

	// parent routes
	$routes['parent/list'] = "parents/list";
	$routes['parent/student/list'] = "parents/student_list";
	$routes['parent/delete/$1'] = "parents/delete/$1";

	// interview routes
	$routes['interview/set/$1'] = "interview/set/$1";
	$routes['interview/list'] = "interview/list";
	$routes['interview/view/$1'] = "interview/view_admission/$1";
	$routes['"interview/get_files/$1'] = "interview/get_files/$1";


	// interview panel routes
	$routes['interviewpanel/list'] = "interviewpanel/list";
	$routes['interviewpanel/delete/$1'] = "interviewpanel/delete/$1";
	$routes['interviewpanel/view/$1'] = "interviewpanel/view_panel/$1";
	$routes['interviewpanel/timetable/$1'] = "interviewpanel/timetable/$1";
	$routes['interviewpanel/registration'] = "interviewpanel/view_panel";

	// attendance routes
	$routes['attendance/classroom/list'] = "attendance/classroom_list";
	$routes['attendance/classroom/view/$1'] = "attendance/classroom_view/$1";
	$routes['attendance/classroom/mark/$1'] = "attendance/mark_student_attendance/$1";
	$routes['attendance/teacher/list'] = "attendance/teacher_list";
	$routes['attendance/teacher/view/$1'] = "attendance/teacher_view/$1";



	// FOR APIS
	$routes['api/admission/search'] = "apiAdmission/search";
	$routes['api/admission/u_search'] = "apiAdmission/u_search";
	$routes['api/admission/parent/validation'] = "apiAdmission/parent_validation";
	$routes['api/classroom/search'] = "apiClassroom/search";
	$routes['api/student/search'] = "apiStudent/search";
	$routes['api/subject/search'] = "apiSubject/search";
	$routes['api/parent/search'] = "apiParent/search";
	$routes['api/teacher/search'] = "apiTeacher/search";
	$routes['api/teacher/subject/$1'] = "apiTeacher/subject/$1";
	$routes['api/teacher/subject/delete/$1/$2'] = "apiTeacher/delete_teacher_subject/$1/$2";
	$routes['api/teacher/subject'] = "apiTeacher/subject";

	$routes['api/attendance/classroom/student/search'] = "apiAttendance/classroom_attendance_search";
	$routes['api/attendance/teacher/search'] = "apiAttendance/teacher_attendance_search";
	$routes['api/attendance/classroom/mark'] = "apiAttendance/mark_classroom_attendance";
	$routes['api/attendance/teacher/mark'] = "apiAttendance/mark_teacher_attendance";
	$routes['api/attendance/student/filter'] = "apiAttendance/student_attendance_filter";
	$routes['api/attendance/teacher/filter'] = "apiAttendance/teacher_attendance_filter";
	$routes['api/attendance/classroom/search'] = "apiAttendance/classroom_search";

	// draw charts
	$routes['api/draw_charts/attendance/student'] = "apiDrawChart/student_attendance_overview_bar";
	$routes['api/draw_charts/attendance/teacher'] = "apiDrawChart/teacher_attendance_overview_bar";
	$routes['api/draw_charts/dashboard/attendance/student'] = "apiDrawChart/dashboard_student_attendance_overview_doughnut";
	$routes['api/draw_charts/dashboard/attendance/teacher'] = "apiDrawChart/dashboard_teacher_attendance_overview_doughnut";

	$routes['api/classroom/grade/$1'] = "apiClassroom/get_grades/$1";
	$routes['api/pagination'] = "apiPagination/pagination";



	// define as a global variable. Don't delete this
	$GLOBALS['routes'] = $routes;
