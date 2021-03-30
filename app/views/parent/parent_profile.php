
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
	<div class="mt-5  w-75 d-flex flex-col align-items-center">
	    <h2 class="pt-3 pb-3">Parent Profile</h2>
	    <hr class="topic-hr w-100">
	</div>

	<div class="col-12">
			<form action="<?php if(isset($id) && !empty($id)){echo set_url('profile/parent').'/'.$id; }else{echo set_url('profile');} ?>" method="post" class="col-12" enctype="multipart/form-data">
				<div class="col-4 flex-col d-none d-md-flex align-items-center"  style=" padding-top: 100px;background: #ccf;">
					<div  class="col-8">
						<div  style="position: relative;">
							<img src="<?php echo set_url('public/uploads/parent_profile_photo/'.$result['profile_photo']); ?>" alt="profile photo"  onClick="open_image_viewer(this);" class="col-12">
							<label class="col-4" for="profile-photo" class="" style="position: absolute; bottom: 0px; right: 0px;">
								<img src="<?php echo set_url("public/assets/img/camera.png"); ?>" alt="upload photo" style="width: 50px; height: 50px; cursor: pointer;">
							</label>
						</div>
						<input type="file" name="profile-photo" id="profile-photo" accept="image/jpg,image/jpeg,image/png" onchange="check_input_image(this)" class="d-none">
						<p class="bg-red fg-white p-2 d-none"></p>
					</div>
					<p id="profile-photo-error" class="d-none"></p>
					<div class=" pt-5">
						<p><code class="fs-18">ID : <?php echo $result["id"]; ?></code></p>
						<p><code class="fs-18">Name : <?php echo $result["name"]; ?></code></p>
					</div>

				</div>
				<div style="background: #88f;" class="col-12 col-md-8 d-flex flex-col align-items-center">
						<div class="d-flex w-100">
							<label class="col-4" for="name-with-initials">Name With Initials</label>
							<input type="text" id="name-with-initials" name="name-with-initials"  placeholder="Name With Initials" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['name']));} ?>" oninput="validate_user_input(this,1,50,1)" <?php if(!$is_admin){echo "disabled='disabled'";}?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="occupation">Occupation</label>
							<input type="text" name="occupation" id="occupation" placeholder="Occupation" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['occupation']));} ?>"required="required" oninput="validate_user_input(this,0,50,1)" <?php if(!$editable){echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="address">Address</label>
							<input type="text" name="address" id="address" placeholder="Address" value="<?php if(isset($result)){echo htmlspecialchars(stripslashes($result['address']));} ?>"required="required" oninput="validate_user_input(this,0,100,1)" <?php if(!$editable){echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="email">Email</label>
							<input type="text" name="email" id="email" placeholder="Email" value="<?php if(isset($result)){echo  htmlspecialchars(stripslashes($result['email']));} ?>" oninput="validate_email(this,0,100,1)" <?php if(!$editable){echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<div class="d-flex w-100">
							<label class="col-4" for="contact-number">Contact Number</label>
							<input type="text" name="contact-number" id="contact-number" placeholder="Contact Number" value="<?php if(isset($result)){echo $result['contact_number'];} ?>" oninput="validate_contact_number(this)" <?php if(!$editable){echo "disabled='disabled'";} ?>>
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
						</div>
						<?php if($editable || $is_admin){ ?>
							<div class="justify-content-between pr-5 col-12  d-flex">
								<a href="<?php echo set_url('verification_code'); ?>" class="btn btn-lightred p-1 fs-12" style="margin-left: 220px;">Change Password</a>
								<input type="submit" value="save" name="submit" id="submit" class="btn btn-blue">
							</div>
						<?php } ?>
				</div>
			</form>
	</div>
	<div class="col-12 mt-5 d-flex flex-col align-items-center">
		<h2 class="mb-5">Links</h2>

		<div class="col-8 d-flex flex-col">
			<a href="<?php echo set_url("parent/student/list/".$result['id']); ?>" class="profile-links">
				<?php 
					if($_SESSION['role'] == "student"){ 
						echo "<p>View My Siblings</p>";
					}else{
						echo "<p>Children List</p>";
					}
				?>
			</a>
		</div>
	</div>
</div>