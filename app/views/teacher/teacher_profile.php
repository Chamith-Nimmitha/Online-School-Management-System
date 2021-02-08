
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
		<h2>Teacher Profile</h2>
	</div>

	<div class="col-12">
			<form action="<?php if(isset($id) && !empty($id)){echo set_url('profile/teacher').'/'.$id; }else{echo set_url('profile');} ?>" method="post" class="col-12" enctype="multipart/form-data">
				<div class="col-4 flex-col  d-none d-md-flex align-items-center"  style=" padding-top: 100px;background: #ccf;">
					<div  class="col-12">
						<div  style="position: relative;">
							<img src="<?php echo set_url('public/uploads/teacher_profile_photo/'.$result['profile_photo']); ?>" alt="profile photo" onclick="upload_profile_photo('profile-photo')"  class="w-100">
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
						<p><code class="fs-18">DOB : <?php echo $result["dob"]; ?></code></p>
					</div>

				</div>
				<div style="background: #88f;" class="col-12 col-md-8 d-flex flex-col align-items-center">
						<div class="d-flex w-100">
							<label class="col-4" for="name-with-initials">Name With Initials</label>
							<input type="text" id="name-with-initials" name="name-with-initials" placeholder="Name With Initials" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['name_with_initials']));} ?>" oninput="validate_user_input(this,1,50,1)" <?php if(!$is_admin){echo "disabled='disabled'";}?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="first-name">First Name</label>
							<input type="text" id="first-name" name="first-name" placeholder="First Name" value="<?php if(isset($result)){ echo htmlspecialchars(stripslashes($result['first_name']));} ?>" oninput="validate_user_input(this,1,20,1)"  <?php if(!$is_admin){echo "disabled='disabled'";}?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="middle-name">Middle Name</label>
							<input type="text" id="middle-name" name="middle-name" placeholder="Middle Name" value="<?php if(isset($result)){ echo htmlspecialchars(stripslashes($result['middle_name']));} ?>" oninput="validate_user_input(this,0,50,0)"  <?php if(!$is_admin){echo "disabled='disabled'";}?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="last-name">Last Name</label>
							<input type="text" id="last-name" name="last-name" placeholder="Last Name" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['last_name']));} ?>" oninput="validate_user_input(this,1,20,1)"  <?php if(!$is_admin){echo "disabled='disabled'";}?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="male">Gender</label>
							<div class="d-flex">
								<label class="col-4 d-flex align-items-center" for="male" class="w-25"><input class="mr-2" type="radio" id="male" name="gender" value="male" <?php if(isset($result) && $result['gender'] == "male"){echo "checked='checked'";} ?>  <?php if(!$is_admin){echo "disabled='disabled'";}?>>Male</label>
								<label class="col-4 d-flex align-items-center" for="female" class="w-25"><input class="mr-2" type="radio" id="female" name="gender" value="female" <?php if(isset($result) && $result['gender'] == "female"){echo "checked='checked'";} ?>  <?php if(!$is_admin){echo "disabled='disabled'";}?>>Female</label>
							</div>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="address">Address</label>
							<input type="text" name="address" id="address" placeholder="Address" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['address']));} ?>"required="required" oninput="validate_user_input(this,0,100,1)" <?php if(!$editable){ echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="email">Email</label>
							<input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['email']));} ?>" oninput="validate_email(this,0,100,1)" <?php if(!$editable){ echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="contact-number">Contact Number</label>
							<input type="text" name="contact-number" id="contact-number" placeholder="Contact Number" value="<?php if(isset($result)){echo $result['contact_number'];} ?>" oninput="validate_contact_number(this)" <?php if(!$editable){ echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<?php if($editable || $is_admin){ ?>
							<div class="justify-content-end pr-5 col-12  d-flex">
								<input type="submit" value="save" name="submit" id="submit" class="btn btn-blue">
							</div>
						<?php } ?>
				</div>
			</form>
	</div>
		<div class="col-12 mt-5 d-flex flex-col align-items-center">
		<h2 class="mb-5">Links</h2>

		<div class="col-8 d-flex flex-col">
			<a href="<?php echo set_url("teacher/attendance/".$result['id']); ?>" class="profile-links">
				<p>Attendance</p>
			</a>
			<a href="<?php echo set_url("teacher/timetable/".$result['id']); ?>" class="profile-links">
				<p>Timetable</p>
			</a>

			<?php if(!empty($result['interview_panel_id']) && $_SESSION['role'] =="admin"){ ?>
				<a href="<?php echo set_url("interviewpanel/view/".$result['interview_panel_id']); ?>" class="profile-links">
					<p>Interview Panel</p>
				</a>
			<?php }else{  ?>
				<a href="<?php echo set_url("teacher/interview/panel/".$result['id']); ?>" class="profile-links">
					<p>Interview Panel</p>
				</a>
			<?php } ?>
			<a href="<?php echo set_url("teacher/subject/list/".$result['id']); ?>" class="profile-links">
					<p>Subject List</p>
				</a>
		</div>
	</div>
</div>
