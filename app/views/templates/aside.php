<?php
	if(!isset($_SESSION)){
		session_start();
	}
	if($_SESSION['role'] == "student"){
	 require_once("aside_student.php");
	}else if($_SESSION['role'] == "teacher"){
	 require_once("aside_teacher.php");
	}else if($_SESSION['role'] == "admin"){
	 require_once("aside_admin.php");
	}else if($_SESSION['role'] == "parent"){
	 require_once("aside_parent.php");
	}
?>

