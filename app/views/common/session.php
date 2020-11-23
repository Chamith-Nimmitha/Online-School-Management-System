<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
?>

<?php 
if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) || !isset($_SESSION['username'])) {
    	header("Location: login.php");
	}
?>