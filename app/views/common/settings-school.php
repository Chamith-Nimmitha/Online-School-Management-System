<?php include_once("session.php"); ?>
<?php require_once("../php/database.php") ?>
<?php require_once("../php/common.php") ?>

<?php 	

	$query = "SELECT * FROM `website_data` WHERE `category`='school'";
	$result_set = $con->pure_query($query)->fetchAll();
	
	if($result_set){
		foreach ($result_set as $data) {
			$result[$data['category']."_".$data['name']] = $data['value'];
		}
	}

	if(isset($_POST['submit'])){
		$is_ok = 1;
		$errors = array();
		$info = array();
    
		$errors2 = array();
		$info2 = array();

		$errors3 = array();
		$info3 = array();

		$errors4 = array();
		$info4 = array();

		$errors5 = array();
		$info5 = array();

		if(isset($_FILES['school-flag']['tmp_name']) && !empty($_FILES['school-flag']['tmp_name'])){
			$target2 = "../img/school_badge/";
			$target_file2 = $target2 . basename($_FILES['school-flag']['name']);
			$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
			$check2 = getimagesize($_FILES['school-flag']['tmp_name']);

			//check file size
			if($is_ok && $_FILES['school-flag']['size'] > 2000000){
				$error = "Sorry, file is too large";
				array_push($errors2, $error);
				$is_ok = 0;
			}

			if(!$is_ok || ($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg")){
				$error = "Sorry, Only jpg,png,jpeg files are allowed.";
				array_push($errors2, $error);
				$is_ok = 0;
			}
		}

		if(isset($_FILES['school-image']['tmp_name']) && !empty($_FILES['school-image']['tmp_name'])){
			$target3 = "../img/school_badge/";
			$target_file3 = $target3 . basename($_FILES['school-image']['name']);
			$imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
			$check3 = getimagesize($_FILES['school-image']['tmp_name']);

			//check file size
			if($is_ok && $_FILES['school-image']['size'] > 2000000){
				$error = "Sorry, file is too large";
				array_push($errors3, $error);
				$is_ok = 0;
			}

			if(!$is_ok || ($imageFileType3 != "jpg" && $imageFileType3 != "png" && $imageFileType3 != "jpeg")){
				$error = "Sorry, Only jpg,png,jpeg files are allowed.";
				array_push($errors3, $error);
				$is_ok = 0;
			}
		}

		if(isset($_FILES['school-map']['tmp_name']) && !empty($_FILES['school-map']['tmp_name'])){
			$target4 = "../img/school_badge/";
			$target_file4 = $target4 . basename($_FILES['school-map']['name']);
			$imageFileType4 = strtolower(pathinfo($target_file4,PATHINFO_EXTENSION));
			$check4 = getimagesize($_FILES['school-map']['tmp_name']);

			//check file size
			if($is_ok && $_FILES['school-map']['size'] > 2000000){
				$error = "Sorry, file is too large";
				array_push($errors4, $error);
				$is_ok = 0;
			}

			if(!$is_ok || ($imageFileType4 != "jpg" && $imageFileType4 != "png" && $imageFileType4 != "jpeg")){
				$error = "Sorry, Only jpg,png,jpeg files are allowed.";
				array_push($errors4, $error);
				$is_ok = 0;
			}
		}

		if(isset($_FILES['bg-image']['tmp_name']) && !empty($_FILES['bg-image']['tmp_name'])){
			$target5 = "../img/school_badge/";
			$target_file5 = $target5 . basename($_FILES['bg-image']['name']);
			$imageFileType5 = strtolower(pathinfo($target_file5,PATHINFO_EXTENSION));
			$check5 = getimagesize($_FILES['bg-image']['tmp_name']);

			//check file size
			if($is_ok && $_FILES['bg-image']['size'] > 2000000){
				$error5 = "Sorry, file is too large";
				array_push($errors5, $error5);
				$is_ok = 0;
			}

			if(!$is_ok || ($imageFileType5 != "jpg" && $imageFileType5 != "png" && $imageFileType5 != "jpeg")){
				$error5 = "Sorry, Only jpg,png,jpeg files are allowed.";
				array_push($errors5, $error5);
				$is_ok = 0;
			}
		}

      	$target = "../img/school_badge/";
		$school['name'] = $_POST['school-name']; 
		$school['address'] = $_POST['school-address']; 
		$school['contact_number'] = $_POST['school-contact-number']; 
		$school['email'] = $_POST['school-email'];
		$school['vision'] = $_POST['school-vision'];
		$school['mission'] = $_POST['school-mission'];
		$school['principal_message'] = $_POST['school-principal-message'];
		$school['welcome_message'] = $_POST['school-welcome-message'];
		$school['description'] = $_POST['school-description'];
		$school['website'] = $_POST['school-website'];
		$school['brief_history'] = $_POST['school-brief-history'];
		$school['fb_id'] = $_POST['school-fb-id'];
		$school['twitter_id'] = $_POST['school-twitter-id'];
		$school['insta_id'] = $_POST['school-insta-id'];
		$school['linkedin_id'] = $_POST['school-linkedin-id'];

		if(isset($_FILES['school-badge']['tmp_name']) && !empty($_FILES['school-badge']['tmp_name'])){
			$result = upload_file($_FILES['school-badge'],$target,2000000);
			$errors = $result[1];
			$info = $result[2];
			if(count($info) == 1){
				$school['badge'] = $_FILES['school-badge']['name'];
				foreach ($school as $name => $value) {
					$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
					if(!$result){
						$con->update("website_data",array("value"=>$value),array("name"=>$name));
					}
				}
			}else{
				$error = "Error occured while uploading.<br>";
				array_push($errors, $error);
			}
		}else{
			$school['badge'] = $result["school_badge"];
			$in = "Successfully updated.";
			foreach ($school as $name => $value) {
				$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
				if(!$result){
					$con->update("website_data",array("value"=>$value),array("name"=>$name));
				}
			}
	      	array_push($info,$in);
	    }

		if(isset($_FILES['school-flag']['tmp_name']) && !empty($_FILES['school-flag']['tmp_name'])){
			$school['flag'] = $_FILES['school-flag']['name'];
			if(move_uploaded_file($_FILES['school-flag']['tmp_name'], $target_file2)){
				$in2 = "Successfully updated.";
				foreach ($school as $name => $value) {
					$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
					if(!$result){
						//echo "test";
						$con->update("website_data",array("value"=>$value),array("name"=>$name));
					}
				}
				array_push($info2,$in2);
			}else{
				$error = "Error occured while uploading.<br>";
				array_push($errors2, $error);
			}
		}

		if(isset($_FILES['school-image']['tmp_name']) && !empty($_FILES['school-image']['tmp_name'])){
			$school['image'] = $_FILES['school-image']['name'];
			if(move_uploaded_file($_FILES['school-image']['tmp_name'], $target_file3)){
				$in3 = "Successfully updated.";
				foreach ($school as $name => $value) {
					$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
					if(!$result){
						//echo "test";
						$con->update("website_data",array("value"=>$value),array("name"=>$name));
					}
				}
				array_push($info3,$in3);
			}else{
				$error = "Error occured while uploading.<br>";
				array_push($errors3, $error);
			}
		}

		if(isset($_FILES['school-map']['tmp_name']) && !empty($_FILES['school-map']['tmp_name'])){
			$school['map'] = $_FILES['school-map']['name'];
			if(move_uploaded_file($_FILES['school-map']['tmp_name'], $target_file4)){
				$in4 = "Successfully updated.";
				foreach ($school as $name => $value) {
					$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
					if(!$result){
						//echo "test";
						$con->update("website_data",array("value"=>$value),array("name"=>$name));
					}
				}
				array_push($info4,$in4);
			}else{
				$error = "Error occured while uploading.<br>";
				array_push($errors4, $error);
			}
		}

		if(isset($_FILES['bg-image']['tmp_name']) && !empty($_FILES['bg-image']['tmp_name'])){
			$school['background'] = $_FILES['bg-image']['name'];
			if(move_uploaded_file($_FILES['bg-image']['tmp_name'], $target_file5)){
				$in5 = "Successfully updated.";
				foreach ($school as $name => $value) {
					$result = $con->insert("website_data",array("category"=>"school","name"=>$name, "value"=>$value));
					if(!$result){
						//echo "test";
						$con->update("website_data",array("value"=>$value),array("name"=>$name));
					}
				}
				array_push($info5,$in5);
			}else{
				$error5 = "Error occured while uploading.<br>";
				array_push($errors5, $error5);
			}
		}

		foreach ($school as $key => $value) {
			$con->update('website_data',array("value"=>$value),array('name'=>$key));
		}



	}
	$query = "SELECT * FROM `website_data`";
	$result_set = $con->pure_query($query)->fetchAll();
	$result = array();
	if($result_set){
		foreach ($result_set as $data) {
			$result[$data['category']."_".$data['name']] = $data['value'];
		}
	}
 ?>

<?php require_once("../templates/header.php") ?>
<?php require_once("../templates/aside.php") ?>
<div id="content" class="col-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($errors) && !empty($errors)){
			echo "<p class='float-left w-75 bg-red p-2'>";
			foreach ($errors as $error) {
				echo $error . "<br>";
			}
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='float-left w-75 bg-green p-2'>";
			foreach ($info as $in) {
				echo $in . "<br>";
			}
			echo "</p>";
		}
	 ?>
	<form action="settings-school.php" method="post" enctype="multipart/form-data">
		
		<fieldset>	
			<legend>Site Header Settings</legend>
				<div class="form-group">
					<label for="school-name">School Name</label>
					<input type="text" name="school-name" id="school-name" value="<?php if(!empty($result)){echo $result['school_name'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-address">School Address</label>
					<input type="text" name="school-address" id="school-address" value="<?php if(!empty($result)){echo $result['school_address'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-contact-number">School Contact Number</label>
					<input type="text" name="school-contact-number" id="school-contact-number" value="<?php if(!empty($result)){echo $result['school_contact_number'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-email">School Email</label>
					<input type="text" name="school-email" id="school-email" value="<?php if(!empty($result)){echo $result['school_email'];} ?>">
				</div>

				<div class="form-group">
					<label for="bg-image">Background Image</label>
					<input type="file" name="bg-image" id="bg-image">
				</div>

				<div class="form-group">
					<label for="school-badge">School Badge</label>
					<input type="file" name="school-badge" id="school-badge">
				</div>

				<div class="form-group">
					<label for="school-flag">School Flag</label>
					<input type="file" name="school-flag" id="school-flag">
				</div>

				<div class="form-group">
					<label for="school-image">School Image</label>
					<input type="file" name="school-image" id="school-image">
				</div>

				<div class="form-group">
					<label for="school-map">School Map </label>
					<input type="file" name="school-map" id="school-map">
				</div>

				<div class="form-group">
					<label for="school-vision">School Vision</label>
					<input type="text" name="school-vision" id="school-vision" value="<?php if(!empty($result)){echo $result['school_vision'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-mission">School Mission</label>
					<input type="text" name="school-mission" id="school-mission" value="<?php if(!empty($result)){echo $result['school_mission'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-welcome-message">School Welcome Message</label>
					<input type="text" name="school-welcome-message" id="school-welcome-message" value="<?php if(!empty($result)){echo $result['school_welcome_message'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-description">School Description</label>
					<input type="text" name="school-description" id="school-description" value="<?php if(!empty($result)){echo $result['school_description'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-principal-message">School Principal's Message</label>
					<input type="text" name="school-principal-message" id="school-principal-message" value="<?php if(!empty($result)){echo $result['school_principal_message'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-brief-history">School Brief History</label>
					<input type="text" name="school-brief-history" id="school-brief-history" value="<?php if(!empty($result)){echo $result['school_brief_history'];} ?>">
				</div>


				<div class="form-group">
					<label for="school-website">School Website</label>
					<input type="text" name="school-website" id="school-website" value="<?php if(!empty($result)){echo $result['school_website'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-fb-id">School Facebook</label>
					<input type="text" name="school-fb-id" id="school-fb-id" value="<?php if(!empty($result)){echo $result['school_fb_id'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-twitter-id">School Twitter</label>
					<input type="text" name="school-twitter-id" id="school-twitter-id" value="<?php if(!empty($result)){echo $result['school_twitter_id'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-insta-id">School Instagram</label>
					<input type="text" name="school-insta-id" id="school-insta-id" value="<?php if(!empty($result)){echo $result['school_insta_id'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-linkedin-id">School Linkedin</label>
					<input type="text" name="school-linkedin-id" id="school-linkedin-id" value="<?php if(!empty($result)){echo $result['school_linkedin_id'];} ?>">
				</div>

				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-blue">Submit</button>
				</div>

		</fieldset>
	</form>

</div> <!-- #content -->

<?php 	require_once("../templates/footer.php") ?>

