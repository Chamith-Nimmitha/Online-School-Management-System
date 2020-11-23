<?php 
	session_start();
	unset($_SESSION['loggedin']);
	unset($_SESSION['role']);
	unset($_SESSION['user_id']);
	unset($_SESSION['username']);
	session_destroy();
	header("Location: login.php");
?>