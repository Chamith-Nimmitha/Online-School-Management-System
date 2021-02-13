
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
			echo $error ."<br/>";
			echo "</p>";
		}
		if(isset($info) && !empty($info)){
			echo "<p class='w-75 bg-green fg-white p-2 text-center'>";
			echo $info ."<br/>";
			echo "</p>";
		}
	 ?>
	<div class="registration-form col-12 justify-content-center">
		<div class="admissions-header mt-5">
			<h2 class="fs-30">Student Admission</h2>
		</div> <!-- .admission-header -->
		<hr class="w-100">
		<form action="<?php echo set_url("interview/view/".$result['id']); ?>" class="col-12 align-items-start" method="post">
			<div class="col-12 col-md-6 p-3">
				<fieldset class="p-3">
					<legend>Student Info</legend>

					<div class="form-group">
						<label for="name-with-initials">Name with initials (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($result['name_with_initials'])){echo $result['name_with_initials'];} ?>" name="name-with-initials" placeholder="Name with initials" id="name-with-initials"  oninput="validate_user_input(this,0,50,1)">
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
						<input type="text" value="<?php if(isset($result['first_name'])){echo $result['first_name'];} ?>" name="first-name" placeholder="First Name" id="first-name"  oninput="validate_user_input(this,0,20,1)">
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
						<input type="text" value="<?php if(isset($result['last_name'])){echo $result['last_name'];} ?>" name="last-name" placeholder="Last Name" id="last-name"  oninput="validate_user_input(this,0,20,1)">
						<?php 
							if(isset($field_errors['last-name'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["last-name"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>

					<div class="form-group col-12">
						<label for="middle-name">Middle Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($result['middle_name'])){echo $result['middle_name'];} ?>" name="middle-name" placeholder="Middle Name" id="middle-name" oninput="validate_user_input(this,0,50,0)">
						<?php 
							if(isset($field_errors['middle-name'])){
								echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["middle-name"].'</p>';
							}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
							}
						 ?>
					</div>
					<div class="form-group">
						<label for="grade">Grade (<code title="required"> * </code>)</label>
						<select name="grade" id="grade" class="w-30">
							<option value="1" <?php if(isset($result['grade']) && $result['grade']==1){echo "selected='selected'";}?> >1</option>
							<option value="2" <?php if(isset($result['grade']) && $result['grade']==2){echo "selected='selected'";}?> >2</option>
							<option value="3" <?php if(isset($result['grade']) && $result['grade']==3){echo "selected='selected'";}?> >3</option>
							<option value="4" <?php if(isset($result['grade']) && $result['grade']==4){echo "selected='selected'";}?> >4</option>
							<option value="5" <?php if(isset($result['grade']) && $result['grade']==5){echo "selected='selected'";}?> >5</option>
							<option value="6" <?php if(isset($result['grade']) && $result['grade']==6){echo "selected='selected'";}?> >6</option>
							<option value="7" <?php if(isset($result['grade']) && $result['grade']==7){echo "selected='selected'";}?> >7</option>
							<option value="8" <?php if(isset($result['grade']) && $result['grade']==8){echo "selected='selected'";}?> >8</option>
							<option value="9" <?php if(isset($result['grade']) && $result['grade']==9){echo "selected='selected'";}?> >9</option>
							<option value="10" <?php if(isset($result['grade']) && $result['grade']==10){echo "selected='selected'";}?> >10</option>
							<option value="11" <?php if(isset($result['grade']) && $result['grade']==11){echo "selected='selected'";}?> >11</option>
							<option value="12" <?php if(isset($result['grade']) && $result['grade']==12){echo "selected='selected'";}?> >12</option>
							<option value="13" <?php if(isset($result['grade']) && $result['grade']==13){echo "selected='selected'";}?> >13</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="gender">Gender (<code title="required"> * </code>)</label>
						<div id="gender" value="<?php if(isset($result['gender'])){echo $result['gender'];} ?>" class="w-100 d-flex nm-2">
							<label for="male" class="w-auto"><input type="radio" name="gender" id="male" value="M" checked>Male</label>
							<label for="female" class="w-auto"><input type="radio" name="gender" id="female" value="F">Female</label>
						</div>
					</div>

					<div class="form-group col-4">
						<label for="dob">Date of Birth (<code title="required"> * </code>)</label>
						<input type="date" value="<?php if(isset($result['dob'])){echo $result['dob'];} ?>" name="dob" id="dob" value="<?php echo date("Y-m-d"); ?>" onchange="validate_birthday(this,6)">
						<label style="color: red; display: none;" for="errors"></label>
					</div>

					<div class="form-group">
						<label for="address">Address (<code title="required"> * </code>)</label>
						<input type="text" value='<?php if(isset($result['address'])){echo htmlspecialchars(stripslashes($result['address']));} ?>' name="address" placeholder="Address" id="address" oninput="validate_user_input(this,0,100,1)">
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
						<input type="email" value="<?php if(isset($result['email'])){echo htmlspecialchars(stripslashes($result['email']));} ?>" name="email" placeholder="Email Address" id="email" oninput="validate_email(this,0,100,1)">
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
						<input type="text" value="<?php if(isset($result['contact_number'])){echo $result['contact_number'];} ?>" name="contact-number" placeholder="Contact Number" id="contact-number" oninput="validate_contact_number(this)">
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
					<legend>Parent and Gurdian Info</legend>
					<div class="form-group">
						<label for="already-have-account" class="ml-5 d-flex" style="color:red">
							<p class="d-inline">Alredy have Parent account </p>
							<input type="checkbox" onchange="already_have_parent_account(this,'parent-details-wrapper','parent-account-field')" name="already-have-account" id="already-have-account" value="yes" class="ml-3" <?php if(isset($result['already_have_account']) && $result['already_have_account']== true){echo "checked='checked'";} ?> >
						</label>
					</div>

					<div id="parent-account-field" class="col-12 no-collapsed">
						<div class="form-group">
							<label for="parent-account-id">Parent Account ID</label>
							<input type="text" name="parent-account-id" id="parent-account-id" value="<?php if(isset($result['parent_account_id'])){echo $result['parent_account_id'];} ?>" placeholder="Parent Account ID" >
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
									<option value="father" <?php if(isset($result['parent_type'])){if($result['parent_type'] == "father"){echo 'selected="selected"';}}else{echo "selected='selected'";} ?> >Father</option>
									<option value="mother" <?php if(isset($result['parent_type']) && ($result['parent_type'] == "mother")){echo "selected='selected'";}  ?> >Mother</option>
									<option value="guardian" <?php if(isset($result['parent_type']) && ($result['parent_type'] == "guardian")){echo "selected='selected'";}  ?> >Guardian</option>
								</select>
							</div>
						</div>
						<div id="father" class="collapsed">
							<div class="form-group">
								<label for="father-name">Father Name (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($result['father_name'])){echo $result['father_name'];} ?>' name="father-name" placeholder="Father Name" id="father-name" oninput="validate_user_input(this,0,50,1)">
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
								<input type="text" value='<?php if(isset($result['father_occupation'])){echo $result['father_occupation'];} ?>' name="father-occupation" placeholder="Father Occupation" id="father-occupation" oninput="validate_user_input(this,0,50,1)">
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
								<input type="number" value='<?php if(isset($result['father_contact_number'])){echo $result['father_contact_number'];} ?>' name="father-contact-number" placeholder="Father Contact Number" id="father-contact-number" oninput="validate_contact_number(this)" >
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
								<input type="email" value='<?php if(isset($result['father_email'])){echo $result['father_email'];} ?>' name="father-email" placeholder="Father Email" id="father-email" oninput="validate_email(this,0,100,1)">
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
								<input type="text" value='<?php if(isset($result['mother_name'])){echo $result['mother_name'];} ?>' name="mother-name" placeholder="Mother Name" id="mother-name" oninput="validate_user_input(this,0,50,1)">
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
								<input type="text" value='<?php if(isset($result['mother_occupation'])){echo $result['mother_occupation'];} ?>' name="mother-occupation" placeholder="Mother Occupation" id="mother-occupation" oninput="validate_user_input(this,0,50,1)">
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
								<input type="number" value='<?php if(isset($result['mother_contact_number'])){echo $result['mother_contact_number'];} ?>' name="mother-contact-number" placeholder="Mother Contact Number" id="mother-contact-number" oninput="validate_contact_number(this)">
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
								<input type="email" value='<?php if(isset($result['mother_email'])){echo $result['mother_email'];} ?>' name="mother-email" placeholder="Mother Email" id="mother-email" oninput="validate_email(this,0,100,1)">
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
								<input type="text" value='<?php if(isset($result['guardian_name'])){echo $result['guardian_name'];} ?>' name="guardian-name" placeholder="Guardian Name" id="guardian-name" oninput="validate_user_input(this,0,50,1)">
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
								<input type="text" value='<?php if(isset($result['guardian_occupation'])){echo $result['guardian_occupation'];} ?>' name="guardian-occupation" placeholder="Guardian Occupation" id="guardian-occupation" oninput="validate_user_input(this,0,50,1)">
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
								<input type="number" value='<?php if(isset($result['guardian_contact_number'])){echo $result['guardian_contact_number'];} ?>' name="guardian-contact-number" placeholder="Guardian Contact Number" id="guardian-contact-number" oninput="validate_contact_number(this)">
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
								<input type="email" value='<?php if(isset($result['guardian_email'])){echo $result['guardian_email'];} ?>' name="guardian-email" placeholder="Guardian Email" id="guardian-email" oninput="validate_email(this,0,100,1)">
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
							<?php 
								if(isset($result['state']) && $result['state'] != "Registered"){
									echo "<button type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-blue w-auto p-2\" >Register</button>";
								}else{
									echo "<button type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-gray w-auto p-2\" disabled='disabled'>Already registered</button>";
								}
							 ?>
						</div>
					</div>
				</fieldset>
			</div>
		</form>
	</div>
</div>