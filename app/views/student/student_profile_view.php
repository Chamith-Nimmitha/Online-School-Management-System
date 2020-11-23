<?php include_once("session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php
	if(!isset($_GET["student_id"])){
		$error = "Account not found.";
	}else{
		$re = $con->select("student",array("id"=>$_GET['student_id']));
		if($re && $re->rowCount() == 1){
			$result = $re->fetch();
		}
	}
 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>


<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($error)){
			echo "<div class='bg-red col-8 p-3'><p >";
			echo  $error."<br/>";
			echo 'Check in -><a class="pl-5" href="'.set_url('pages/student_list.php').'">Student List</a>';
			echo "</p></div>";
		}
	 ?>
	<div class="mt-5">
		<h2>Student Profile</h2>
	</div>

	<div class="col-12">
			<form action="student_profile.php" method="post" class="col-12" enctype="multipart/form-data">
				<div class="col-4  flex-col  d-none d-md-flex align-items-center"  style=" padding-top: 100px;background: #ccf;">
					<div  class="col-12">
						<div  style="position: relative;">
							<img src="<?php if(isset($result)){echo set_url('img/student_profile_photo/'.$result['profile_photo']);} ?>" alt="profile photo" onclick="upload_profile_photo('profile-photo')"  class="w-100">
							<label for="profile-photo" class="p-2" style="position: absolute; bottom: 0px; right: 0px;">
								<img src="<?php echo set_url("img/camera.png"); ?>" alt="upload photo" style="width: 50px; height: 50px; cursor: pointer;">
							</label>
						</div>
						<input type="file" name="profile-photo" id="profile-photo" accept="image/jpg,image/jpeg,image/png" onchange="check_input_image(this)" class="d-none">
						<p class="bg-red fg-white p-2 d-none"></p>
					</div>
					<p id="profile-photo-error" class="d-none"></p>
					<div class=" pt-5">
						<p><code class="fs-18">ID : <?php if(isset($result)){echo $result["id"];} ?></code></p>
						<p><code class="fs-18">Name : <?php if(isset($result)) {echo $result["name_with_initials"];} ?></code></p>
						<p><code class="fs-18">DOB : <?php if(isset($result)){echo $result["dob"];} ?></code></p>
					</div>

				</div>
				<div style="background: #88f;"  class="col-12 col-md-8 d-flex flex-col align-items-center">
						<div class="form-group ">
							<label for="name-with-initials">Name With Initials</label>
							<input type="text"  placeholder="Name With Initials" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['name_with_initials']));} ?>" oninput="validate_user_input(this,1,50,1)" disabled="disabled">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="first-name">First Name</label>
							<input type="text" placeholder="First Name" value="<?php if(isset($result)){ echo htmlspecialchars(stripslashes($result['first_name']));} ?>" oninput="validate_user_input(this,1,20,1)"  disabled="disabled">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="middle-name">Middle Name</label>
							<input type="text" placeholder="Middle Name" value="<?php if(isset($result)){ echo htmlspecialchars(stripslashes($result['middle_name']));} ?>" oninput="validate_user_input(this,1,50,1)"  disabled="disabled">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="last-name">Last Name</label>
							<input type="text" placeholder="Last Name" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['last_name']));} ?>" oninput="validate_user_input(this,1,20,1)"  disabled="disabled">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="grade">Grade</label>
							<select  disabled="disabled">
								<option value="1" <?php if(isset($result) && $result['grade']== '1'){ "selected='selected'";} ?>>1</option>
								<option value="2" <?php if(isset($result) && $result['grade']== '2'){echo "selected='selected'";} ?>>2</option>
								<option value="3" <?php if(isset($result) && $result['grade']== '3'){echo "selected='selected'";} ?>>3</option>
								<option value="4" <?php if(isset($result) && $result['grade']== '4'){echo "selected='selected'";} ?>>4</option>
								<option value="5" <?php if(isset($result) && $result['grade']== '5'){echo "selected='selected'";} ?>>5</option>
								<option value="6" <?php if(isset($result) && $result['grade']== '6'){echo "selected='selected'";} ?>>6</option>
								<option value="7" <?php if(isset($result) && $result['grade']== '7'){echo "selected='selected'";} ?>>7</option>
								<option value="8" <?php if(isset($result) && $result['grade']== '8'){echo "selected='selected'";} ?>>8</option>
								<option value="9" <?php if(isset($result) && $result['grade']== '9'){echo "selected='selected'";} ?>>9</option>
								<option value="10" <?php if(isset($result) && $result['grade']== '10'){echo "selected='selected'";} ?>>10</option>
								<option value="11" <?php if(isset($result) && $result['grade']== '11'){echo "selected='selected'";} ?>>11</option>
								<option value="12" <?php if(isset($result) && $result['grade']== '12'){echo "selected='selected'";} ?>>12</option>
								<option value="13" <?php if(isset($result) && $result['grade']== '13'){echo "selected='selected'";} ?>>13</option>
							</select>
						</div>
						<div class="form-group ">
							<label for="gender">Gender</label>
							<div class="d-flex">
								<label for="male" class="w-25"><input type="radio" value="M" <?php if(isset($result) && $result['gender'] == "M"){echo "checked='checked'";} ?>  disabled="disabled">Male</label>
								<label for="female" class="w-25"><input type="radio" value="F" <?php if(isset($result) && $result['gender'] == "F"){echo "checked='checked'";} ?>  disabled="disabled">Female</label>
							</div>
						</div>
						<div class="form-group ">
							<label for="address">Address</label>
							<input type="text" name="address" id="address" placeholder="Address" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['address']));} ?>"required="required" oninput="validate_user_input(this,0,100,1)">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="email">Email</label>
							<input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['email']));} ?>" oninput="validate_user_input(this,0,100,1)">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="contact-number">Contact Number</label>
							<input type="text" name="contact-number" id="contact-number" placeholder="Contact Number" value="<?php if(isset($result)){echo $result['contact_number'];} ?>" oninput="validate_contact_number(this)">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="justify-content-end pr-5 col-12  d-flex">
							<input type="submit" value="save" name="submit" id="submit" class="btn btn-blue">
						</div>
				</div>
			</form>
	</div>
</div>


<?php require_once("../templates/footer.php"); ?>