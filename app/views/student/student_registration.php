
<div id="content" class="col-12 flex-col align-items-center justify-content-start">
	<?php 
		
		if(isset($error) && !empty($error)){
			echo "<p class='mt-5 w-75 bg-red p-5 text-center'>";
			echo $error;
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='mt-5 w-75 bg-green p-5 text-center'>";
			echo $info;
			echo "</p>";
		}

	 ?>
	<div class="registration-form col-12 justify-content-center">
		<div class="admissions-header mt-5  w-75 d-flex flex-col align-items-center">
			<h2 class="fs-30">Student Registration Form</h2>
			<hr class="topic-hr w-100">
		</div> <!-- .admission-header -->
		<form action="<?php echo set_url('student/registration') ?>" class="col-12 align-items-start" method="post">
			<div class="col-12 col-md-6 p-3">
				<fieldset class="p-3">
					<legend>Student Info</legend>
					<div class="form-group">
						<label for="name-with-initials">Name with initials (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['name-with-initials'])){echo $_POST['name-with-initials'];} ?>" name="name-with-initials" placeholder="Name with initials" id="name-with-initials" oninput="validate_user_input(this,0,50,1)">
						<?php 
							if(isset($field_errors['name-with-initials'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["name-with-initials"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>

					<div class="form-group col-md-5 mr-5">
						<label for="first-name">Frist Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['first-name'])){echo $_POST['first-name'];} ?>" name="first-name" placeholder="First Name" id="first-name" oninput="validate_user_input(this,0,20,1)">
						<?php 
							if(isset($field_errors['first-name'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["first-name"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>
					<div class="form-group col-md-5 ml-5">
						<label for="last-name">Last Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['last-name'])){echo $_POST['last-name'];} ?>" name="last-name" placeholder="Last Name" id="last-name" oninput="validate_user_input(this,0,20,1)">
						<?php 
							if(isset($field_errors['last-name'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["last-name"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>

					<div class="form-group col-12">
						<label for="middle-name">Middle Name</label>
						<input type="text" value="<?php if(isset($_POST['middle-name'])){echo $_POST['middle-name'];} ?>" name="middle-name" placeholder="Middle Name" id="middle-name" oninput="validate_user_input(this,0,50,0)">
						<?php 
							if(isset($field_errors['middle-name'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["middle-name"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>
					<div class="form-group col-md-3">
						<label for="grade">Grade (<code title="required"> * </code>)</label>
						<select name="grade" id="grade" id="grade" >
						<option value="1" <?php if(isset($_POST['grade']) && $_POST['grade']== '1'){echo "selected='selected'";} ?>>1</option>
						<option value="2" <?php if(isset($_POST['grade']) && $_POST['grade']== '2'){echo "selected='selected'";} ?>>2</option>
						<option value="3" <?php if(isset($_POST['grade']) && $_POST['grade']== '3'){echo "selected='selected'";} ?>>3</option>
						<option value="4" <?php if(isset($_POST['grade']) && $_POST['grade']== '4'){echo "selected='selected'";} ?>>4</option>
						<option value="5" <?php if(isset($_POST['grade']) && $_POST['grade']== '5'){echo "selected='selected'";} ?>>5</option>
						<option value="6" <?php if(isset($_POST['grade']) && $_POST['grade']== '6'){echo "selected='selected'";} ?>>6</option>
						<option value="7" <?php if(isset($_POST['grade']) && $_POST['grade']== '7'){echo "selected='selected'";} ?>>7</option>
						<option value="8" <?php if(isset($_POST['grade']) && $_POST['grade']== '8'){echo "selected='selected'";} ?>>8</option>
						<option value="9" <?php if(isset($_POST['grade']) && $_POST['grade']== '9'){echo "selected='selected'";} ?>>9</option>
						<option value="10" <?php if(isset($_POST['grade']) && $_POST['grade']== '10'){echo "selected='selected'";} ?>>10</option>
						<option value="11" <?php if(isset($_POST['grade']) && $_POST['grade']== '11'){echo "selected='selected'";} ?>>11</option>
						<option value="12" <?php if(isset($_POST['grade']) && $_POST['grade']== '12'){echo "selected='selected'";} ?>>12</option>
						<option value="13" <?php if(isset($_POST['grade']) && $_POST['grade']== '13'){echo "selected='selected'";} ?>>13</option>
					</select>
					</div>

					<div class="form-group col-md-4">
						<label for="gender">Gender (<code title="required"> * </code>)</label>
						<div id="gender" class="w-100 d-flex nm-2">
							<label for="male" class="w-auto"><input type="radio" name="gender" id="male" value="M" <?php if(isset($_POST['gender']) && $_POST['gender'] == "M"){echo "checked='checked'";}else if(!isset($_POST['gender'])){echo "checked='checked'";} ?>>Male</label>
							<label for="female" class="w-auto"><input type="radio" name="gender" id="female" value="F" <?php if(isset($_POST['gender']) && $_POST['gender'] == "F"){echo "checked='checked'";} ?>>Female</label>
						</div>
					</div>

					<div class="form-group col-4">
						<label for="dob">Date of Birth (<code title="required"> * </code>)</label>
						<input type="date" value="<?php if(isset($_POST['dob'])){echo $_POST['dob'];}else{ echo date("Y-m-d");} ?>" name="dob" id="dob" onchange="validate_birthday(this,6)">
						<?php 
							if(isset($field_errors['dob'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["dob"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>

					<div class="form-group">
						<label for="address">Address (<code title="required"> * </code>)</label>
						<input type="text" value='<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>' name="address" placeholder="Address" id="address"  oninput="validate_user_input(this,0,100,1)">
						<?php 
							if(isset($field_errors['address'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["address"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>

					<div class="form-group">
						<label for="email">Email Address (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" name="email" placeholder="Email Address" id="email"  oninput="validate_email(this,0,100,1)">
						<?php 
							if(isset($field_errors['email'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["email"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>

					<div class="form-group">
						<label for="contact-number">Contact Number (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['contact-number'])){echo $_POST['contact-number'];} ?>" name="contact-number" placeholder="Contact Number" id="contact-number" oninput="validate_contact_number(this)">
						<?php 
							if(isset($field_errors['contact-number'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["contact-number"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>
					

				</fieldset>
			</div>
			<div  class="col-12 col-md-6 p-3 flex-col">
				<fieldset>
					<legend>Parent or Gurdian Info</legend>
					<div class="form-group">
						<label for="already-have-account" class="ml-5 d-flex align-items-center" style="color:red">
							<p class="d-inline">Alredy have Parent account </p>
							<input type="checkbox" onchange="already_have_parent_account(this,'parent-details-wrapper','parent-account-field')" name="already-have-account" id="already-have-account" value="yes" class="ml-3" <?php if(isset($_POST['already-have-account']) && $_POST['already-have-account'] == "yes"){echo "checked='checked'";} ?>>
						</label>
					</div>

					<div id="parent-account-field" class="col-12 no-collapsed">
						<div class="form-group">
							<label for="parent-account-id">Parent Account ID</label>
							<input type="text" name="parent-account-id" id="parent-account-id" placeholder="Parent account ID">
							<?php 
							if(isset($field_errors['parent-account-id'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["parent-account-id"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
						</div>
					</div>

					<div id="parent-details-wrapper">
						<div class="form-group">
							<label for="parent-type">Select parent or guardian : </label>
							<div class="d-flex ">
								<select name="parent-type"  onchange="registration_parent_change(this)" id="parent-type"  style="width: 200px;">
									<option value="father" <?php if(isset($_POST['parent-type'])){if($_POST['parent-type'] == "father"){echo 'selected="selected"';}}else{echo "selected='selected'";} ?> >Father</option>
									<option value="mother" <?php if(isset($_POST['parent-type']) && ($_POST['parent-type'] == "mother")){echo "selected='selected'";}  ?> >Mother</option>
									<option value="guardian" <?php if(isset($_POST['parent-type']) && ($_POST['parent-type'] == "guardian")){echo "selected='selected'";}  ?> >Guardian</option>
								</select>
							</div>
						</div>
						<div id="father" class="collapsed">
							<div class="form-group">
								<label for="father-name">Father Name (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-name'])){echo $_POST['father-name'];} ?>" name="father-name" placeholder="Father Name" id="father-name" oninput="validate_user_input(this,0,50,1)">
								<?php 
									if(isset($field_errors['father-name'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["father-name"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="father-occupation">Father Occupation (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-occupation'])){echo $_POST['father-occupation'];} ?>" name="father-occupation" placeholder="Father Occupation" id="father-occupation" oninput="validate_user_input(this,0,50,1)">
								<?php 
									if(isset($field_errors['father-occupation'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["father-occupation"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="father-contact-number">Father Contact Number (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-contact-number'])){echo $_POST['father-contact-number'];} ?>" name="father-contact-number" placeholder="Father Contact Number" id="father-contact-number"  oninput="validate_contact_number(this)">
								<?php 
									if(isset($field_errors['father-contact-number'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">Father '.$field_errors["father-contact-number"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="father-email">Father Email (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-email'])){echo $_POST['father-email'];} ?>" name="father-email" placeholder="Father Email" id="father-email" oninput="validate_email(this,0,100,1)">
								<?php 
									if(isset($field_errors['father-email'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["father-email"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>
						</div>

						<div id="mother" class="no-collapsed">
							<div class="form-group">
								<label for="mother-name">Mother Name (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-name'])){echo $_POST['mother-name'];} ?>" name="mother-name" placeholder="Mother Name" id="mother-name" oninput="validate_user_input(this,0,50,1)">
								<?php 
									if(isset($field_errors['mother-name'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["mother-name"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="mother-occupation">Mother Occupation (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-occupation'])){echo $_POST['mother-occupation'];} ?>" name="mother-occupation" placeholder="Mother Occupation" id="mother-occupation" oninput="validate_user_input(this,0,50,1)">
								<?php 
									if(isset($field_errors['mother-occupation'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["mother-occupation"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="mother-contact-number">Mother Contact Number (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-contact-number'])){echo $_POST['mother-contact-number'];} ?>" name="mother-contact-number" placeholder="Mother Contact Number" id="mother-contact-number" oninput="validate_contact_number(this)">
								<?php 
									if(isset($field_errors['mother-contact-number'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">Mother '.$field_errors["mother-contact-number"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="mother-email">Mother Email (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-email'])){echo $_POST['mother-email'];} ?>" name="mother-email" placeholder="Mother Email" id="mother-email" oninput="validate_email(this,0,100,1)">
								<?php 
									if(isset($field_errors['mother-email'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["mother-email"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>						
						</div>

						<div id="guardian" class="no-collapsed">
							<div class="form-group">
								<label for="guardian-name">Guardian Name (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-name'])){echo $_POST['guardian-name'];} ?>" name="guardian-name" placeholder="Guardian Name" id="guardian-name" oninput="validate_user_input(this,0,50,1)">
								<?php 
									if(isset($field_errors['guardian-name'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["guardian-name"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="guardian-occupation">Guardian Occupation (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-occupation'])){echo $_POST['guardian-occupation'];} ?>" name="guardian-occupation" placeholder="Guardian Occupation" id="guardian-occupation" oninput="validate_user_input(this,0,50,1)">
								<?php 
									if(isset($field_errors['guardian-occupation'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["guardian-occupation"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="guardian-contact-number">Guardian Contact Number (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-contact-number'])){echo $_POST['guardian-contact-number'];} ?>" name="guardian-contact-number" placeholder="Guardian Contact Number" id="guardian-contact-number" oninput="validate_contact_number(this)">
								<?php 
									if(isset($field_errors['guardian-contact-number'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">Guardian '.$field_errors["guardian-contact-number"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>

							<div class="form-group">
								<label for="guardian-email">Guardian Email (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-email">'])){echo $_POST['					</div>	'];} ?>" name="guardian-email" placeholder="Guardian Email" id="guardian-email"  oninput="validate_email(this,0,100,1)">
								<?php 
									if(isset($field_errors['guardian-email'])){
										echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["guardian-email"].'</p>';
									}else{
										echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
									}
								 ?>
							</div>	
						</div>
					
						<div class="w-100 p-1"></div>
						<div class="form-group d-flex flex-row w-auto float-right">
							<a href="<?php echo set_url('student/registration'); ?>" class="btn btn-blue m-1">Reset Form</a>
							<button type="submit" name="submit" id="submit" class="btn btn-blue w-auto m-1">Submit</button>
						</div>
					</div>

				</fieldset>
			</div>
		</form>
	</div>
</div>