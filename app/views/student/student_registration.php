<?php require_once("../php/common.php") ?>
<?php require_once("../php/database.php") ?>


<?php 
	
	$all_errors = array();

	$index_number = '';
	$name_with_initials = '';
	$first_name = '';
	$middle_name = '';
	$last_name = '';
	$grade='';
	$genfer = '';
	$dob = '';
	$address = '';
	$email = '';
	$contact_number = '';
	$father_name = '';
	$parent_type = "";
	$already_have_account = false;
	$parent_account_id = "";
	$father_occupation = '';
	$father_contact_number = '';
	$father_email = "";
	$mother_name = '';
	$mother_occupation = '';
	$mother_contact_number = '';
	$mother_email = "";
	$guardian_name = '';
	$guardian_occupation = '';
	$guardian_contact_number = '';
	$guardian_email = "";

	if(isset($_POST['submit'])){

		// $index_number = $_POST['index-number'];
		$name_with_initials = addslashes($_POST['name-with-initials']);
		$first_name = addslashes($_POST['first-name']);
		$middle_name = addslashes($_POST['middle-name']);
		$last_name = addslashes($_POST['last-name']);
		$grade =$_POST['grade'];
		$gender = $_POST['gender'];
		$dob = $_POST['dob'];
		$address = addslashes($_POST['address']);
		$email = addslashes($_POST['email']);
		if(!valid_email($email)){
			$all_errors[3] = "Invalid student email address.";
		}
		$contact_number = $_POST['contact-number'];
		$all_errors[5] = validate_contact_number($contact_number);

		if(isset($_POST['already-have-account']) && $_POST['already-have-account'] == true){
			$already_have_account = 1;
			$parent_account_id = $_POST['parent-account-id'];
		}else{
			$already_have_account = 0;
			$parent_type = $_POST['parent-type'];
			$father_name = addslashes($_POST['father-name']);
			$father_occupation = addslashes($_POST['father-occupation']);
			$father_contact_number = $_POST['father-contact-number'];
			$father_email = addslashes($_POST['father-email']);
			$mother_name = addslashes($_POST['mother-name']);
			$mother_occupation = addslashes($_POST['mother-occupation']);
			$mother_contact_number = $_POST['mother-contact-number'];
			$mother_email = addslashes($_POST['mother-email']);
			$guardian_name = addslashes($_POST['guardian-name']);
			$guardian_occupation = addslashes($_POST['guardian-occupation']);
			$guardian_contact_number = $_POST['guardian-contact-number'];
			$guardian_email = addslashes($_POST['guardian-email']);
		}




		$required_fields = array();
		// $required_fields['index-number']=6;
		$required_fields['name-with-initials']=50;
		$required_fields['first-name']=20;
		$required_fields['middle-name']=50;
		$required_fields['last-name']=20;
		$required_fields['grade']=2;
		$required_fields['gender']=10;
		$required_fields['dob']=Null;
		$required_fields['address']=100;
		$required_fields['email']=100;

		if($already_have_account == 1){
			$required_fields['parent-account-id']=7;
		}else{
			if($parent_type == "father"){
				$required_fields['father-name']=50;
				$required_fields['father-occupation']=50;
				$required_fields['father-contact-number']=10;
				$required_fields['father-email']=100;
			}else if($parent_type == "mother"){
				$required_fields['mother-name']=50;
				$required_fields['mother-occupation']=50;
				$required_fields['mother-contact-number']=10;
				$required_fields['mother-email']=100;
			}else{
				$required_fields['guardian-name']=50;
				$required_fields['guardian-occupation']=50;
				$required_fields['guardian-contact-number']=10;
				$required_fields['guardian-email']=100;
			}
		}


		$all_e = check_input_fields($required_fields);
		$all_errors[0] = $all_e[0];
		$all_errors[1] = $all_e[1];

		if($already_have_account == true){
			$con->where(array("id"=>$parent_account_id));
			$result = $con->select("parent");
			if(!$result){
				$all_errors[7] = "Parent id is not valid.";
			}
		}
		if(empty($all_errors[0]) && empty($all_errors[1]) && empty($all_errors[2]) && !isset($all_errors[3]) && empty($all_errors[5]) && !isset($all_errors[7])){
			$data = array();
			 // $data["index_number"]= $index_number;
			 $data["name_with_initials"]= $name_with_initials;
			 $data["first_name"]= $first_name;
			 $data["middle_name"]= $middle_name;
			 $data["last_name"]= $last_name;
			 $data["grade"]= $grade;
			 $data["gender"]= $gender;
			 $data["dob"]= $dob;
			 $data["address"]= $address;
			 $data["email"]= $email;
			 $data["contact_number"]= $contact_number;
			 $data['parent_type'] = $parent_type;
			 $data['already_have_account'] = $already_have_account;
			 if($already_have_account == false){
			 	if($parent_type == "father"){
					 $data["parent_name"]= $father_name;
					 $data["parent_occupation"]= $father_occupation;
					 $data["parent_contact_number"]= $father_contact_number;
					 $data["parent_email"]= $father_email;
				}else if($parent_type == "mother"){
					 $data["parent_name"]= $mother_name;
					 $data["parent_occupation"]= $mother_occupation;
					 $data["parent_contact_number"]= $mother_contact_number;
					 $data["parent_email"]= $mother_email;

				}else if($parent_type == "guardian"){
					 $data["parent_name"]= $guardian_name;
					 $data["parent_occupation"]= $guardian_occupation;
					 $data["parent_contact_number"]= $guardian_contact_number;
					 $data["parent_email"]= $guardian_email;
				}
			 }else{
				$data['parent_account_id'] = $parent_account_id;
			 	$data["parent_name"]= "";
				$data["parent_occupation"]= "";
				$data["parent_contact_number"]= "";
				$data["parent_email"]= "";
			 }

			$result = false;
			if(valid_email($data['parent_email'])){
				$all_errors[6] = validate_contact_number($data['parent_contact_number']);
				if(count($all_errors[6]) == 0 ){
					$result = $con ->insert('admission',$data);
				}
			}else{
				$all_errors[4] = "-Invalid parent email address.";
			}
			if($result){
				$info = "Admission send successfully.We will send you interview data as soon as posible.";
				unset($_POST);
			}else{
				$all_errors[8] = "Registration failed.";
			}
		}
	}
 ?>

<?php require_once("../templates/header.php"); ?>
<div id="content" class="col-12 flex-col align-items-center justify-content-start">
	<?php 
		if((isset($all_errors[0])) && (!empty($all_errors[0]) || isset($all_errors[2]) || isset($all_errors[3]) || isset($all_errors[4]) || !empty($all_errors[5]) || !empty($all_errors[6]) || isset($all_errors[7]))){
			echo "<div class='bg-red w-50' style=\"padding-left: 100px;\">";
			echo "<p class='p-3 fg-white'>";
			foreach ($all_errors[0] as $error) {
				echo "-".$error." is required.<br>";
			}
			if(isset($all_errors[1]) && !empty($all_errors[1])){
				foreach ($all_errors[1] as $error) {
					echo "-".$error." length must less than ".$required_fields[$error].".<br>";
				}
			}
			if(isset($all_errors[2])){
				echo $all_errors[2]."<br/>";
			}
			if(isset($all_errors[3])){
				echo $all_errors[3]."<br/>";
			}
			if(isset($all_errors[4])){
				echo $all_errors[4]."<br/>";
			}
			if(isset($all_errors[5])){
				if(isset($all_errors[5][0]) && !empty($all_errors[5][0]))
					echo "-Student contact number must be number"."<br/>";
				else if(isset($all_errors[5][1]))
					echo "-Student contact number must be 10 digits"."<br/>";
				else if(isset($all_errors[5][2]))
					echo "-Student contact number must be begin with 070,071,072,075,076,077,078."."<br/>";
			}
			if(isset($all_errors[6])){
				if(isset($all_errors[6][0]))
					echo "-Parent contact number must be number"."<br/>";
				else if(isset($all_errors[6][1]))
					echo "-Parent contact number must be 10 digits"."<br/>";
				else if(isset($all_errors[6][2]))
					echo "-Parent contact number must be begin with 070,071,072,075,076,077,078."."<br/>";
			}
			if(isset($all_errors[7])){
				echo $all_errors[7]."<br/>";
			}
			if(isset($all_errors[8])){
				echo $all_errors[8]."<br/>";
			}
			echo "</p>";
			echo "</div>";
		}
		if(isset($info)){
			echo "<p class='mt-5 w-75 bg-green p-5 text-center'>";
			echo $info;
			echo "</p>";
		}

	 ?>
	<div class="registration-form col-12 justify-content-center">
		<div class="admissions-header mt-5">
			<h2 class="fs-30">Student Registration Form</h2>
		</div> <!-- .admission-header -->
		<hr class="w-100">
		<form action="<?php echo set_url('pages/student_registration.php'); ?>" class="col-12 align-items-start" method="post">
			<div class="col-12 col-md-6 p-3">
				<fieldset class="p-3">
					<legend>Student Info</legend>
					<div class="form-group">
						<label for="name-with-initials">Name with initials (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['name-with-initials'])){echo $_POST['name-with-initials'];} ?>" name="name-with-initials" placeholder="Name with initials" id="name-with-initials" oninput="validate_user_input(this,0,50,1)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>

					<div class="form-group col-md-5 mr-5">
						<label for="first-name">Frist Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['first-name'])){echo $_POST['first-name'];} ?>" name="first-name" placeholder="First Name" id="first-name" oninput="validate_user_input(this,0,20,1)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>
					<div class="form-group col-md-5 ml-5">
						<label for="last-name">Last Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['last-name'])){echo $_POST['last-name'];} ?>" name="last-name" placeholder="Last Name" id="last-name"  oninput="validate_user_input(this,0,20,1)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>

					<div class="form-group col-12">
						<label for="middle-name">Middle Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['middle-name'])){echo $_POST['middle-name'];} ?>" name="middle-name" placeholder="Middle Name" id="middle-name"  oninput="validate_user_input(this,0,50,1)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
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
						<input type="date" value="<?php if(isset($_POST['dob'])){echo $_POST['dob'];} ?>" name="dob" id="dob" onchange="validate_birthday(this,6)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>

					<div class="form-group">
						<label for="address">Address (<code title="required"> * </code>)</label>
						<input type="text" value='<?php if(isset($_POST['address'])){echo $_POST['address'];} ?>' name="address" placeholder="Address" id="address"  oninput="validate_user_input(this,0,100,1)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>

					<div class="form-group">
						<label for="email">Email Address (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" name="email" placeholder="Email Address" id="email"  oninput="validate_email(this,0,100,1)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>

					<div class="form-group">
						<label for="contact-number">Contact Number (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($_POST['contact-number'])){echo $_POST['contact-number'];} ?>" name="contact-number" placeholder="Contact Number" id="contact-number" oninput="validate_contact_number(this)">
						<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
					</div>
				</fieldset>
			</div>
			<div  class="col-12 col-md-6 p-3 flex-col">
				<fieldset>
					<legend>Parent or Gurdian Info</legend>
					<div class="form-group">
						<label for="already-have-account" class="ml-5 d-flex align-items-center" style="color:red">
							<p class="d-inline">Alredy have Parent account </p>
							<input type="checkbox" onchange="already_have_parent_account(this,'parent-details-wrapper','parent-account-field')" name="already-have-account" id="already-have-account" class="ml-3">
						</label>
					</div>

					<div id="parent-account-field" class="col-12 no-collapsed">
						<div class="form-group">
							<label for="parent-account-id">Parent Account ID</label>
							<input type="text" name="parent-account-id" id="parent-account-id" placeholder="Parent account ID">
							<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
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
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="father-occupation">Father Occupation (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-occupation'])){echo $_POST['father-occupation'];} ?>" name="father-occupation" placeholder="Father Occupation" id="father-occupation" oninput="validate_user_input(this,0,50,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="father-contact-number">Father Contact Number (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-contact-number'])){echo $_POST['father-contact-number'];} ?>" name="father-contact-number" placeholder="Father Contact Number" id="father-contact-number"  oninput="validate_contact_number(this)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="father-email">Father Email (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['father-email'])){echo $_POST['father-email'];} ?>" name="father-email" placeholder="Father Email" id="father-email"  oninput="validate_email(this,0,100,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>
						</div>

						<div id="mother" class="no-collapsed">
							<div class="form-group">
								<label for="mother-name">Mother Name (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-name'])){echo $_POST['mother-name'];} ?>" name="mother-name" placeholder="Mother Name" id="mother-name"  oninput="validate_user_input(this,0,50,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="mother-occupation">Mother Occupation (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-occupation'])){echo $_POST['mother-occupation'];} ?>" name="mother-occupation" placeholder="Mother Occupation" id="mother-occupation"  oninput="validate_user_input(this,0,50,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="mother-contact-number">Mother Contact Number (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-contact-number'])){echo $_POST['mother-contact-number'];} ?>" name="mother-contact-number" placeholder="Mother Contact Number" id="mother-contact-number" oninput="validate_contact_number(this)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="mother-email">Mother Email (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['mother-email'])){echo $_POST['mother-email'];} ?>" name="mother-email" placeholder="Mother Email" id="mother-email"  oninput="validate_email(this,0,100,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>						
						</div>

						<div id="guardian" class="no-collapsed">
							<div class="form-group">
								<label for="guardian-name">Guardian Name (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-name'])){echo $_POST['guardian-name'];} ?>" name="guardian-name" placeholder="Guardian Name" id="guardian-name" oninput="validate_user_input(this,0,50,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="guardian-occupation">Guardian Occupation (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-occupation'])){echo $_POST['guardian-occupation'];} ?>" name="guardian-occupation" placeholder="Guardian Occupation" id="guardian-occupation" oninput="validate_user_input(this,0,50,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="guardian-contact-number">Guardian Contact Number (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-contact-number'])){echo $_POST['guardian-contact-number'];} ?>" name="guardian-contact-number" placeholder="Guardian Contact Number" id="guardian-contact-number" oninput="validate_contact_number(this)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>

							<div class="form-group">
								<label for="guardian-email">Guardian Email (<code title="required"> * </code>)</label>
								<input type="text" value="<?php if(isset($_POST['guardian-email">'])){echo $_POST['					</div>	'];} ?>" name="guardian-email" placeholder="Guardian Email" id="guardian-email"  oninput="validate_email(this,0,100,1)">
								<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
							</div>	
						</div>
						<div class="w-100 p-1"></div>
						<div class="form-group d-flex flex-row w-auto float-right">
							<a href="<?php echo set_url('pages/student_registration.php'); ?>" class="btn btn-blue m-1">Reset Form</a>
							<button type="submit" name="submit" id="submit" class="btn btn-blue w-auto m-1">Submit</button>
						</div>
					</div>
				</fieldset>
			</div>
		</form>
	</div>
</div>
<?php require_once("../templates/footer.php") ?>