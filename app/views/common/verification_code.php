<?php require_once("../php/database.php") ?>
<?php require_once("../php/common.php") ?>

<?php require_once( realpath(dirname( __FILE__ )). "/../php/config.php"); ?>
<?php require_once(realpath(dirname( __FILE__ )). "/../php/common.php"); ?>
<?php require_once(realpath(dirname( __FILE__ )). "/../php../database.php") ?>
<?php $con = new Database(); ?>

<?php 
	$query = "SELECT `name`,`value` FROM `website_data` WHERE `category`='school'";
	$header_result = $con->pure_query($query)->fetchAll();
	if($header_result){
		foreach ($header_result as $data) {
			$header[$data['name']] = $data['value'];
		}
	}
	session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>SMS</title>
	<link rel="stylesheet" href="<?php echo set_url('css/grid-system.css'); ?>">
	<!-- <link rel="stylesheet" href="../css/vimarsha.css"> -->
	<link rel="stylesheet" href="<?php echo set_url('css/main.css'); ?>">
	<link rel="stylesheet" href="<?php echo set_url('css/hemakanth.css'); ?>">
	<link rel="stylesheet" href="<?php echo set_url('css/chamith.css'); ?>">
</head>
<body>
	<div class="container bg-lightgray">
		<div class="row theme-header sticky-top" id="top-header">
			<div class="school-badge col-4 col-md-3 justify-content-center pt-2">
				<a href="<?php echo set_url('index.php'); ?>"><img src="<?php echo set_url('img/school_badge') ?><?php if(!empty($header)){echo $header['badge'];}?>" width="80px" alt=""  id="school-badge" ></a>
			</div> <!-- .school-badge -->
			<div id="header-school-info" class="col-6 col-md-6 flex-col align-items-center">
				<!-- <div class="d-flex flex-col bg-red align-items-start"> -->
					<h1 class ="school-name"><?php if(!empty($header)){echo $header['name'];} ?></h1>
					<div class="d-none d-md-flex flex-col" id="header-school-other-info">
						<span><?php if(!empty($header)){echo $header['address'];} ?></span>
						<span><?php if(!empty($header)){echo $header['contact_number'];} ?></span>
						<span><?php if(!empty($header)){echo  $header['email'];} ?></span>
						
					</div>
				</div>


					<?php
					$buttons = '<div class="login_buttons col-12 col-md-3 justify-content-end pr-5 d-flex align-items-center">
				<a class="btn btn-blue mr-5" href="' . set_url('pages/login.php').'">Log In</a>
				<a class="btn btn-blue" href="'.  set_url('pages/student_registration.php'). ' ">Registration</a>
			</div>';
			echo $buttons;

					?>
		<hr style="background-color: orange; height: 5px; width:100%; box-shadow: 0 10px 20px 3px black; padding: 0; margin: 0">
		</div> <!-- .row -->
		<div class="row sticky-top-m">



<?php

if(isset($_POST['submit'])){

	if(isset($_POST['ver-code']) && $_POST['ver-code']=='abc@1234'){
		header("Location:change_password.php");
	}
	else{
		$error="Incorrect Verification Code";
	}

}

?>


<div id="content" class="col-12 flex-col align-items-center justify-content-start fs-14">
<div class="row align-items-center justify-content-center">
<div class="col-3 align-items-center justify-content-start">

<form action="" method="post" enctype="multipart/form-data" >
<?php
	if(isset($error)){ 
	echo $error;
}
?>
		<fieldset class="col-12 justify-content-center align-items-center">
			<legend>Verification Code</legend>
			<div class="form-group">
			<label for="ver-code">Enter Your Verification Code</label>
			<input type="text" name="ver-code" id="ver-code" placeholder="Verification Code" >
			<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
			</div>

			<div class="form-group ">
			<div class="row justify-content-center align-items-center">
					<input type="submit" value="submit" name="submit" class="m-2 btn btn-blue" size="50">
			</div>
			</div>

		</fieldset>
	
</form>

</div>
</div>
</div>






<?php require_once("../templates/footer.php") ?>