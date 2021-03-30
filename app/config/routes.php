<?php 

	/**
	  * define routes here
	  * This roures are check top to bottom. So most specific routes must be in top.
	  */

	// homepage routes

	$routes['test'] = "home/test";

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
	$routes['school/notice/delete/$1'] = "home/delete_notice/$1";
	// $routes['dashboard/$1'] = "user/dashboard/$1";
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
	$routes['teacher/subject/student/add/$1'] = "teacher/student_add/$1";
	$routes['teacher/subject/timetable/$1'] = "teacher/subject_timetable/$1";
	$routes['teacher/attendance'] = "teacher/attendance";
	$routes['teacher/attendance/$1'] = "teacher/attendance/$1";
	$routes['teacher/classroom/attendance'] = "teacher/classroom_attendance";
	$routes['teacher/interview/panel'] = "teacher/interview_panel_view";
	$routes['teacher/interview/panel/$1'] = "teacher/interview_panel_view/$1";
	$routes['teacher/interviews'] = "teacher/interview_list";
	$routes['teacher/timetable'] = "teacher/teacher_timetable";
	$routes['teacher/timetable/$1'] = "teacher/teacher_timetable/$1";
	$routes['teacher/dashboard'] = "teacher/teacher_dashboard";

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
	$routes['classroom/subject/teacher/$1'] = "classroom/update_subjects/$1";
	$routes['classroom/notice/delete/$1'] = "classroom/delete_notice/$1";
	$routes['classroom/view'] = "classroom/classroom_view";
	$routes['classroom/view/$1'] = "classroom/classroom_view/$1";

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
	$routes['student/delete/$1/$2'] = "student/student_delete/$1/$2";
	$routes['student/attendance'] = "student/attendance";
	$routes['student/attendance/$1'] = "student/attendance/$1";
	$routes['student/attendance/report'] = "student/attendance_report";
	$routes['student/subject/list'] = "student/subject_list";
	$routes['student/view/parent/$2'] = "user/profile_view/$1/$2";
	$routes['student/csv'] = "student/student_upload";
	$routes['student/marks/report/$1'] = "marks/marks_report/$1";
	$routes['student/dashboard'] = "student/student_dashboard";

	//admin route --> only admin can access
	$routes['userrole'] = "userrole/permission";
	$routes['userrole/permission'] = "userrole/permission";
	$routes['userrole/permission/update'] = "userrole/update_permission";
	$routes['userrole/create'] = "userrole/create";
	$routes['userrole/model/create'] = "userrole/model_create";

	// parent routes
	$routes['parent/list'] = "parents/list";
	$routes['parent/student/list'] = "parents/student_list";
	$routes['parent/student/list/$1'] = "parents/student_list/$1";
	$routes['parent/delete/$1'] = "parents/delete/$1";
	$routes['parent/dashboard'] = "parents/parent_dashboard";

	// interview routes
	$routes['interview/set/$1'] = "interview/set/$1";
	$routes['interview/list'] = "interview/list";
	$routes['interview/view/$1'] = "interview/view_admission/$1";
	$routes['"interview/get_files/$1'] = "interview/get_files/$1";
	$routes['"interview/delete/$1'] = "interview/delete_interview/$1";


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

	// exam result routes
	$routes['exam/result'] = "marks/result_view";
	$routes['marks/classroom/list'] = "marks/classroom_list";
	$routes['marks/classroom/result/view/$1/$2'] = "marks/classroom_marks_result_view/$1/$2";
	$routes['marks/classroom/view/$1/$2'] = "marks/classroom_view/$1/$2";
	$routes['marks/classroom/view/$1/$2/$3'] = "marks/classroom_view/$1/$2/$3";
	$routes['marks/upload'] = "marks/marksheet_preview";

	// help center
	$routes['help_center'] = "helpCenter/help_center";



	// FOR APIS
	$routes['api/admission/search'] = "apiAdmission/search";
	$routes['api/admission/u_search'] = "apiAdmission/u_search";
	$routes['api/admission/parent/validation'] = "apiAdmission/parent_validation";
	$routes['api/classroom/search'] = "apiClassroom/search";
	$routes['api/classroom/timetable/update'] = "apiClassroom/update_timetable";
	$routes['api/classroom/notice/add'] = "apiClassroom/add_notice";
	$routes['api/school/notice/add'] = "apiHome/add_notice";
	$routes['api/classroom/notice/$1'] = "apiClassroom/get_notice/$1";
	$routes['api/school/notice/$1'] = "apiHome/get_notice/$1";
	$routes['api/classroom/notice/update/$1'] = "apiClassroom/update_notice/$1";
	$routes['api/school/notice/update/$1'] = "apiHome/update_notice/$1";
	$routes['api/classroom/get_class_list'] = "apiClassroom/get_class_list";
	$routes['api/student/search'] = "apiStudent/search";
	$routes['api/subject/search'] = "apiSubject/search";
	$routes['api/parent/search'] = "apiParent/search";
	$routes['api/interview/search'] = "apiInterview/search";
	$routes['api/teacher/search'] = "apiTeacher/search";
	$routes['api/teacher/subject/$1'] = "apiTeacher/subject/$1";
	$routes['api/teacher/subject/delete/$1/$2'] = "apiTeacher/delete_teacher_subject/$1/$2";
	$routes['api/teacher/subject'] = "apiTeacher/subject";
	$routes['api/timetable/teacher/conflit'] = "apiTeacher/timetable_conflit";
	$routes['api/teacher/subject/student/list'] = "apiTeacher/tea_sub_student";
	$routes['api/teacher/validate_id/$1'] = "apiTeacher/validate_teacher/$1";

	$routes['api/attendance/classroom/student/search'] = "apiAttendance/classroom_attendance_search";
	$routes['api/attendance/teacher/search'] = "apiAttendance/teacher_attendance_search";
	$routes['api/attendance/classroom/mark'] = "apiAttendance/mark_classroom_attendance";
	$routes['api/attendance/teacher/mark'] = "apiAttendance/mark_teacher_attendance";
	$routes['api/attendance/student/filter'] = "apiAttendance/student_attendance_filter";
	$routes['api/attendance/teacher/filter'] = "apiAttendance/teacher_attendance_filter";
	$routes['api/attendance/classroom/search'] = "apiAttendance/classroom_search";
	$routes['api/attendance/classroom/get/class/$1'] = "apiAttendance/get_classroom_list/$1";

	$routes['api/marks/classroom/search'] = "apiMarks/classroom_search";
	$routes['api/marks/classroom/student/search'] = "apiMarks/classroom_marks_search";
	
	// draw charts
	$routes['api/draw_charts/attendance/student'] = "apiDrawChart/student_attendance_overview_bar";
	$routes['api/draw_charts/attendance/student/week'] = "apiDrawChart/dashboard_student_attendance_week_bar";
	$routes['api/draw_charts/attendance/teacher/week'] = "apiDrawChart/dashboard_teacher_attendance_week_bar";
	$routes['api/draw_charts/attendance/teacher'] = "apiDrawChart/teacher_attendance_overview_bar";
	$routes['api/draw_charts/dashboard/attendance/student'] = "apiDrawChart/dashboard_student_attendance_overview_doughnut";
	$routes['api/draw_charts/dashboard/attendance/teacher'] = "apiDrawChart/dashboard_teacher_attendance_overview_doughnut";
	
	$routes['api/draw_charts/attendance/classroom/comparission'] = "apiDrawChart/classroom_attendance_comparission";

	$routes['api/draw_charts/dashboard/marks/student/$1'] = "apiDrawChart/dashboard_students_marks_overview_doughnut/$1";
	$routes['api/draw_charts/dashboard/marks/barchart/$1/$2'] = "apiDrawChart/students_marks_bar_chart/$1/$2";
	$routes['api/draw_charts/dashboard/marks/subject-avg/$1/$2'] = "apiDrawChart/subject_average_bar_chart/$1/$2";

	$routes['api/classroom/grade/$1'] = "apiClassroom/get_grades/$1";

	$routes['api/pagination'] = "apiPagination/pagination";



	// define as a global variable. Don't delete this
	$GLOBALS['routes'] = $routes;
