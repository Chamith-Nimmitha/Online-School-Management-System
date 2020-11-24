
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($info)){
			echo "<p class='bg-green d-flex justify-content-center col-8 p-3'>";
			echo $info;
			echo "</p>";
		}
		if(isset($field_errors)){
			echo "<p class='bg-red d-flex justify-content-center col-8 p-3'>";
			echo "Update Failed.";
			echo "</p>";
		}
	 ?>
	<div class="mt-5">
		<h2>Admin Profile</h2>
	</div>

	<div class="col-12">
			<form action="<?php echo set_url('profile') ?>" method="post" class="col-12" enctype="multipart/form-data">
				<div class="col-4 flex-col  d-none d-md-flex align-items-center"  style=" padding-top: 100px;background: #ccf;">
					<div  class="col-12">
						<div  style="position: relative;">
							<img src="<?php echo set_url('public/uploads/admin_profile_photo/'.$_SESSION['profile_photo']); ?>" alt="profile photo" onclick="upload_profile_photo('profile-photo')"  class="w-100">
							<label for="profile-photo" class="p-2" style="position: absolute; bottom: 0px; right: 0px;">
								<img src="<?php echo set_url("public/assets/img/camera.png"); ?>" alt="upload photo" style="width: 50px; height: 50px; cursor: pointer;">
							</label>
						</div>
						<input type="file" name="profile-photo" id="profile-photo" accept="image/jpg,image/jpeg,image/png" onchange="check_input_image(this)" class="d-none">
						<p class="bg-red fg-white p-2 d-none"></p>
					</div>
					<p id="profile-photo-error" class="d-none"></p>
					<div class=" pt-5">
						<p><code class="fs-18">ID : <?php echo $result["id"]; ?></code></p>
						<p><code class="fs-18">Name : <?php echo $result["name_with_initials"]; ?></code></p>
					</div>
				</div>
				<div style="background: #88f;" class="col-12 col-md-8 d-flex flex-col align-items-center">
						<div class="form-group ">
							<label for="name-with-initials">Name With Initials</label>
							<input type="text" name="name-with-initials" placeholder="Name With Initials" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['name_with_initials']));} ?>" oninput="validate_user_input(this,1,50,1)" disabled="disabled">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="username">Username</label>
							<input type="text" placeholder="Username" name="username" value="<?php if(isset($result)){ echo htmlspecialchars(stripslashes($result['username']));} ?>" oninput="validate_user_input(this,1,20,1)">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="gender">Gender</label>
							<div class="d-flex">
								<label for="male" class="w-25"><input name="gender" type="radio" value="M" <?php if(isset($result) && $result['gender'] == "M"){echo "checked='checked'";} ?>  disabled="disabled">Male</label>
								<label for="female" class="w-25"><input name="gender" type="radio" value="F" <?php if(isset($result) && $result['gender'] == "F"){echo "checked='checked'";} ?>  disabled="disabled">Female</label>
							</div>
						</div>
						<div class="form-group ">
							<label for="address">Address</label>
							<input type="text" name="address" id="address" placeholder="Address" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['address']));} ?>"required="required" oninput="validate_user_input(this,0,100,1)">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="form-group ">
							<label for="email">Email</label>
							<input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['email']));} ?>" oninput="validate_email(this,0,100,1)">
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