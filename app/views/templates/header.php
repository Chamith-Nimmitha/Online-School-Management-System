<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>SMS</title>
	<link rel="stylesheet" href="<?php echo set_url('public/assets/css/grid-system.css'); ?>">
	<link rel="stylesheet" href="<?php echo set_url('public/assets/css/hemakanth.css'); ?>">
	<link rel="stylesheet" href="<?php echo set_url('public/assets/css/main.css'); ?>">
	<link rel="stylesheet" href="<?php echo set_url('public/assets/css/themes/default.css'); ?>">
	<link rel="stylesheet" href="<?php echo set_url('public/assets/css/timetable.css'); ?>">
	<link id="user-theme" rel="stylesheet" href="">
</style>
	<script src="https://kit.fontawesome.com/970e009013.js" crossorigin="anonymous"></script>
</head>
<body>
	<?php require_once(ASSETS."gadgets/goToTop.html"); ?>
	<?php require_once(ASSETS."gadgets/preLoader.html"); ?>
	<?php require_once(ASSETS."gadgets/loader.html"); ?>
	<?php require_once(ASSETS."gadgets/dialog_box.html"); ?>
	<?php require_once(ASSETS."gadgets/snackbar.html"); ?>
	<?php require_once(ASSETS."gadgets/input.html"); ?>
	<?php require_once(ASSETS."gadgets/image_viewer.html"); ?>
	<div class="container">
		<div class="row theme-header sticky-top" id="top-header">
			<div class="school-badge col-4 col-md-3 justify-content-center pt-2">
				<a href="<?php echo set_url(''); ?>"><img src="<?php echo set_url('public/assets/img/school_badge') ?><?php if(!empty($header)){echo $header['badge'];}?>" width="80px" alt=""  id="school-badge" ></a>
			</div> <!-- .school-badge -->
			<div id="header-school-info" class="col-6 col-md-6 flex-col align-items-center">
				<!-- <div class="d-flex flex-col bg-red align-items-start"> -->
					<h1 class ="school-name"><?php if(!empty($header)){echo $header['name'];} ?></h1>
					<div class="d-none d-md-flex flex-col" id="header-school-other-info">
						<span><?php if(!empty($header)){echo $header['address'];} ?></span>
						<span><?php if(!empty($header)){echo $header['contact_number'];} ?></span>
						<span><?php if(!empty($header)){echo  $header['email'];} ?></span>
						
					</div>
				<!-- </div> -->
			</div> <!-- #header-school-info -->
			<?php if(isset($_SESSION['username'])){
				$user_info = '
			<div  class="col-2 col-md-3 d-flex flex-col justify-content-center" style="position:relative;" id="user_nav_wrapper">
				<div  id="header-user-info" class="header-user-info d-flex align-items-center justify-content-center mr-5" target="user-nav">
					<div class="d-none d-md-flex">
						<div>
							<img src="';
							if(isset($_SESSION['profile_photo']) && $_SESSION['profile_photo'] !=""){
								$user_info .= set_url("public/uploads/".$_SESSION['role']."_profile_photo/".$_SESSION['profile_photo']);
							}else{
								$user_info .= "";
							}
						$user_info .= '" alt="" style="width:50px; height:50px; border: 2px solid orange;">
						</div>
						<div class="mr-3 d-lg-flex flex-col justify-content-center d-md-none">
							<span >'.$_SESSION['username'].'</span>
						</div>
					</div>
					<button class="toggle-button" target="user-nav" id="user_toggle_button">
						<img src="'.set_url('public/assets/img/menu_arrow.png').'" width="20px" height="20px" alt="">
					</button>
				</div>
				<div class="no-collapsed theme-darkblue w-100" id="user-nav">
					<ul class="nav">
						<li class="nav-item"><a href="'.set_url("dashboard").'" class="nav-link">Dashboard</a></li>
						<li class="nav-item"><a href="'.set_url("profile").'" class="nav-link">Profile</a></li>
						<li class="nav-item"><a href="" class="nav-link">Notifications</a></li>
						<li class="nav-item"><a href="' . set_url('logout').'" class="nav-link">Log out</a></li>
					</ul>
				</div>
			</div> <!-- #header-user-info -->';
			echo $user_info;
			}
			else{
				$buttons = '<div class="login_buttons col-12 col-md-3 justify-content-end pr-5 d-flex align-items-center">
				<a class="btn btn-blue mr-5" href="' . set_url('login').'">Log In</a>
				<a class="btn btn-blue" href="'.  set_url('student/registration'). ' ">Registration</a>
			</div>';
			echo $buttons;
			}
			?>
		<hr class="header-hr">
		</div> <!-- .row -->
		<div class="row sticky-top-m" id="middle-wrapper">


