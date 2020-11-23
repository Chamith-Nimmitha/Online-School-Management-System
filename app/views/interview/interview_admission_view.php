<?php include_once("session.php"); ?>
<?php require_once("../php/common.php") ?>
<?php require_once("../php/database.php") ?>


<?php 

	if(!isset($_GET['admission-id'])){
		header("Location:admission_interview_list.php");
	}
	$index_number = "";
	$name_with_initials = "";
	$first_name = "";
	$middle_name = "";
	$last_name = "";
	$grade="";
	$genfer = "";
	$dob = "";
	$address = "";
	$email = "";
	$contact_number = "";
	$father_name = "";
	$parent_type = "";
	$already_have_account = false;
	$parent_account_id = "";
	$father_occupation = "";
	$father_contact_number = "";
	$father_email = "";
	$mother_name = "";
	$mother_occupation = "";
	$mother_contact_number = "";
	$mother_email = "";
	$guardian_name = "";
	$guardian_occupation = "";
	$guardian_contact_number = "";
	$guardian_email = "";

	if(isset($_POST['submit'])){
		$con->get(array("state"));
		$is_interviewed = $con->select("interview",array("admission_id"=> $_GET['admission-id']))->fetch()['state'];
		$name_with_initials = $_POST['name-with-initials'];
		$first_name = $_POST['first-name'];
		$middle_name = $_POST['middle-name'];
		$last_name = $_POST['last-name'];
		$grade =$_POST['grade'];
		$gender = $_POST['gender'];
		$dob = $_POST['dob'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$contact_number = $_POST['contact-number'];
		if(isset($_POST['already-have-account']) && $_POST['already-have-account'] === "yes"){
			$already_have_account = 1;
			$parent_account_id = $_POST['parent-account-id'];
		}else{
			$already_have_account = 0;
			$parent_type = $_POST['parent-type'];
			$father_name = $_POST['father-name'];
			$father_occupation = $_POST['father-occupation'];
			$father_contact_number = $_POST['father-contact-number'];
			$father_email = $_POST['father-email'];
			$mother_name = $_POST['mother-name'];
			$mother_occupation = $_POST['mother-occupation'];
			$mother_contact_number = $_POST['mother-contact-number'];
			$mother_email = $_POST['mother-email'];
			$guardian_name = $_POST['guardian-name'];
			$guardian_occupation = $_POST['guardian-occupation'];
			$guardian_contact_number = $_POST['guardian-contact-number'];
			$guardian_email = $_POST['guardian-email'];
		}

		$required_fields = array();
		$required_fields['name-with-initials']=50;
		$required_fields['first-name']=20;
		$required_fields['middle-name']=50;
		$required_fields['last-name']=20;
		$required_fields['grade']=2;
		$required_fields['gender']=10;
		$required_fields['dob']=Null;
		$required_fields['address']=100;
		$required_fields['email']=100;

		if($already_have_account == true){
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


		$all_errors = check_input_fields($required_fields);

		foreach ($all_errors[0] as $error) {
			echo $error." is required.<br>";
		}

		foreach ($all_errors[1] as $error) {
			echo $error." length must less than ".$required_fields[$error].".<br>";
		}

		if($already_have_account == true){
			$con->where(array("id"=>$parent_account_id));
			$result = $con->select("parent");
			if(!$result){
				$all_errors[2] = "Parent id is not valid.";
				echo "Parent id is not valid.<br>";
			}
		}

		if(empty($all_errors[0]) && empty($all_errors[1]) && empty($all_errors[2])){
			$data = array();
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
			 if($already_have_account == 0){
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
			$data["state"] = "registered";
			$con->db->beginTransaction();
			$result = $con ->update('admission',$data,array("id"=>$_GET['admission-id']));
			
			if($result){
				try{
					if($data["already_have_account"] == 0){
						$parent_data['name'] = $data["parent_name"];
						$parent_data['type'] = $data["parent_type"];
						$parent_data['occupation'] = $data["parent_occupation"];
						$parent_data['address'] = $data["address"];
						$parent_data['contact_number'] = $data["parent_contact_number"];
						$parent_data['email'] = $data["parent_email"];
						$result = $con->insert("parent",$parent_data);
						if(!$result){
							throw new PDOException('Faild to insert to parent table', 1 );
						}
						$con->get(array("id"));
						$result = $con->select("parent",array("name"=>$parent_data['name'],"email"=>$parent_data["email"]));
						if($result->rowCount() == 0){
							throw new PDOException('Error when get parent id', 1 );
						}else if($result->rowCount() == 2){
							throw new PDOException('Already have parent account', 1 );
						}
						$parent_id = $result->fetch()['id'];
						$user_data = array();
						$user_data['email'] = $data["parent_email"];
						$user_data['role'] = "parent";
						$result = $con->insert("user",$user_data);
						if(!$result){
							throw new PDOException('Faild to insert  parent to user table', 1 );
						}
					}else{
						$parent_id = $data["parent_account_id"];
					}
					$student_data["name_with_initials"] = $data["name_with_initials"];
					$student_data["first_name"] = $data["first_name"];
					$student_data["middle_name"] = $data["middle_name"];
					$student_data["last_name"] = $data["last_name"];
					$student_data["grade"] = $data["grade"];
					$student_data["gender"] = $data["gender"];
					$student_data["dob"] = $data["dob"];
					$student_data["address"] = $data["address"];
					$student_data["email"] = $data["email"];
					$student_data["contact_number"] = $data["contact_number"];
					$student_data["parent_id"] = $parent_id;

					$result = $con->insert("student",$student_data);
					if(!$result){
						throw new PDOException('Faild to insert to student table', 1 );
					}
					$user_data = array();
					$user_data['email'] = $data["email"];
					$user_data['role'] = "student";
					$result = $con->insert("user",$user_data);
					if(!$result){
						throw new PDOException('Faild to insert student to user table', 1 );
					}
					$con->get(array("id"));
					$result = $con->select("student",array("name_with_initials"=>$student_data['name_with_initials'],"email"=>$student_data["email"]));
					if($result->rowCount() != 1){
						throw new PDOException('Faild to get student id', 1 );
					}
					$student_id = $result->fetch()['id'];

					$result = $con->update("interview",array("state"=>"interviewed"),array("admission_id"=>$_GET['admission-id']));
					if(!$result){
						throw new PDOException("Faild to update interview state.",1);
					}

					$con->db->commit();
					header("Location:". set_url('pages/admission_student_register.php?student-id='.$student_id));
				}catch(Exception $e){
					$con->db->rollback();
					$error = $e->getMessage();
				}

			}else{
				$error = "Account creation failed.";
			}
		}
	}

	$result = $con->select("admission",array("id"=>$_GET['admission-id']));
	if($result->rowCount() == 0){
		header("Location:admission_interview_list.php");
	}else{
		$result = $result->fetch();

		$name_with_initials = $result['name_with_initials'];
		$first_name = $result['first_name'];
		$middle_name = $result['middle_name'];
		$last_name = $result['last_name'];
		$grade =$result['grade'];
		$gender = $result['gender'];
		$dob = $result['dob'];
		$address = $result['address'];
		$email = $result['email'];
		$contact_number = $result['contact_number'];
		$is_interviewed = $result["state"];
		if($result['already_have_account'] == 1){
			$already_have_account = $result['already_have_account'];
			$parent_account_id = $result['parent_account_id'];
		}else{
			$parent_type = $result['parent_type'];
			switch ($parent_type) {
				case 'father':
					$father_name = $result['parent_name'];
					$father_occupation = $result['parent_occupation'];
					$father_contact_number = $result['parent_contact_number'];
					$father_email = $result['parent_email'];
					break;
				case 'mother':
					$mother_name = $result['parent_name'];
					$mother_occupation = $result['parent_occupation'];
					$mother_contact_number = $result['parent_contact_number'];
					$mother_email = $result['parent_email'];
					break;
				default:
					$guardian_name = $result['parent_name'];
					$guardian_occupation = $result['parent_occupation'];
					$guardian_contact_number = $result['parent_contact_number'];
					$guardian_email = $result['parent_email'];
					break;
			}
		}
	}
 ?>
<?php require_once("../templates/header.php") ?>
<?php require_once("../templates/aside.php") ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
			echo $error ."<br/>";
			echo "</p>";
		}
	 ?>
	<div class="registration-form col-12 justify-content-center">
		<div class="admissions-header mt-5">
			<h2 class="fs-30">Student Admission</h2>
		</div> <!-- .admission-header -->
		<hr class="w-100">
		<form action="<?php echo set_url('pages/interview_admission_view.php?admission-id='.$_GET['admission-id'].'&back='.$_GET['back']); ?>" class="col-12 align-items-start" method="post">
			<div class="col-12 col-md-6 p-3">
				<fieldset class="p-3">
					<legend>Student Info</legend>

					<!-- <div class="form-group">
						<label for="index-number">Index Number (<code title="required"> * </code>)</label>
						<input type="number" value="<?php //if(isset($_POST['index-number'])){echo $_POST['index-number'];} ?>" name="index-number" placeholder="Index Number" id="index-number">
					</div> -->

					<div class="form-group">
						<label for="name-with-initials">Name with initials (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($name_with_initials)){echo $name_with_initials;} ?>" name="name-with-initials" placeholder="Name with initials" id="name-with-initials">
					</div>

					<div class="form-group col-md-5 mr-5">
						<label for="first-name">Frist Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($first_name)){echo $first_name;} ?>" name="first-name" placeholder="First Name" id="first-name">
					</div>
					<div class="form-group col-md-5 ml-5">
						<label for="last-name">Last Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($last_name)){echo $last_name;} ?>" name="last-name" placeholder="Last Name" id="last-name">
					</div>

					<div class="form-group col-12">
						<label for="middle-name">Middle Name (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($middle_name)){echo $middle_name;} ?>" name="middle-name" placeholder="Middle Name" id="middle-name">
					</div>
					<div class="form-group">
						<label for="grade">Grade (<code title="required"> * </code>)</label>
						<select name="grade" id="grade" class="w-30">
							<option value="1" <?php if(isset($grade) && $grade==1){echo "selected='selected'";}?> >1</option>
							<option value="2" <?php if(isset($grade) && $grade==2){echo "selected='selected'";}?> >2</option>
							<option value="3" <?php if(isset($grade) && $grade==3){echo "selected='selected'";}?> >3</option>
							<option value="4" <?php if(isset($grade) && $grade==4){echo "selected='selected'";}?> >4</option>
							<option value="5" <?php if(isset($grade) && $grade==5){echo "selected='selected'";}?> >5</option>
							<option value="6" <?php if(isset($grade) && $grade==6){echo "selected='selected'";}?> >6</option>
							<option value="7" <?php if(isset($grade) && $grade==7){echo "selected='selected'";}?> >7</option>
							<option value="8" <?php if(isset($grade) && $grade==8){echo "selected='selected'";}?> >8</option>
							<option value="9" <?php if(isset($grade) && $grade==9){echo "selected='selected'";}?> >9</option>
							<option value="10" <?php if(isset($grade) && $grade==10){echo "selected='selected'";}?> >10</option>
							<option value="11" <?php if(isset($grade) && $grade==11){echo "selected='selected'";}?> >11</option>
							<option value="12" <?php if(isset($grade) && $grade==12){echo "selected='selected'";}?> > <?php if(isset($grade) && $grade==1){echo "selected='selected";}?> 12</option>
							<option value="12" <?php if(isset($grade) && $grade==13){echo "selected='selected'";}?> >13</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="gender">Gender (<code title="required"> * </code>)</label>
						<div id="gender" value="<?php if(isset($gender)){echo $gender;} ?>" class="w-100 d-flex nm-2">
							<label for="male" class="w-auto"><input type="radio" name="gender" id="male" value="M" checked>Male</label>
							<label for="female" class="w-auto"><input type="radio" name="gender" id="female" value="F">Female</label>
						</div>
					</div>

					<div class="form-group col-4">
						<label for="dob">Date of Birth (<code title="required"> * </code>)</label>
						<input type="date" value="<?php if(isset($dob)){echo $dob;} ?>" name="dob" id="dob" value="<?php echo date("Y-m-d"); ?>" onchange="validate_birthday(this,6)">
						<label style="color: red; display: none;" for="errors"></label>
					</div>

					<div class="form-group">
						<label for="address">Address (<code title="required"> * </code>)</label>
						<input type="text" value='<?php if(isset($address)){echo $address;} ?>' name="address" placeholder="Address" id="address">
					</div>

					<div class="form-group">
						<label for="email">Email Address (<code title="required"> * </code>)</label>
						<input type="email" value="<?php if(isset($email)){echo $email;} ?>" name="email" placeholder="Email Address" id="email">
					</div>

					<div class="form-group">
						<label for="contact-number">Contact Number (<code title="required"> * </code>)</label>
						<input type="text" value="<?php if(isset($contact_number)){echo $contact_number;} ?>" name="contact-number" placeholder="Contact Number" id="contact-number" oninput="validate_contact_number(this)">
						<label for="errors" style="color: red;display: none;"></label>
					</div>
				</fieldset>
			</div>
			<div  class="col-12 col-md-6 p-3 flex-col">
				<fieldset>
					<legend>Parent and Gurdian Info</legend>
					<div class="form-group">
						<label for="already-have-account" class="ml-5 d-flex" style="color:red">
							<p class="d-inline">Alredy have Parent account </p>
							<input type="checkbox" onchange="already_have_parent_account(this,'parent-details-wrapper','parent-account-field')" name="already-have-account" id="already-have-account" value="yes" class="ml-3" <?php if(isset($already_have_account) && $already_have_account=== true){echo "checked='checked'";} ?> >
						</label>
					</div>

					<div id="parent-account-field" class="col-12 no-collapsed">
						<div class="form-group">
							<label for="parent-account-id">Parent Account ID</label>
							<input type="text" name="parent-account-id" id="parent-account-id" value="<?php if(isset($parent_account_id)){echo $parent_account_id;} ?>" placeholder="Parent Account ID" >
						</div>
					</div>

					<div id="parent-details-wrapper">
						<div class="form-group">
							<label for="parent-type">Select parent or guardian : </label>
							<div class="d-flex ">
								<select name="parent-type"  onchange="registration_parent_change(this)" id="parent-type"  style="width: 200px;">
									<option value="father" <?php if(isset($parent_type)){if($parent_type == "father"){echo 'selected="selected"';}}else{echo "selected='selected'";} ?> >Father</option>
									<option value="mother" <?php if(isset($parent_type) && ($parent_type == "mother")){echo "selected='selected'";}  ?> >Mother</option>
									<option value="guardian" <?php if(isset($parent_type) && ($parent_type == "guardian")){echo "selected='selected'";}  ?> >Guardian</option>
								</select>
							</div>
						</div>
						<div id="father" class="collapsed">
							<div class="form-group">
								<label for="father-name">Father Name (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($father_name)){echo $father_name;} ?>' name="father-name" placeholder="Father Name" id="father-name"  >
							</div>

							<div class="form-group">
								<label for="father-occupation">Father Occupation (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($father_occupation)){echo $father_occupation;} ?>' name="father-occupation" placeholder="Father Occupation" id="father-occupation"  >
							</div>

							<div class="form-group">
								<label for="father-contact-number">Father Contact Number (<code title="required"> * </code>)</label>
								<input type="number" value='<?php if(isset($father_contact_number)){echo $father_contact_number;} ?>' name="father-contact-number" placeholder="Father Contact Number" id="father-contact-number" oninput="validate_contact_number(this)" >
								<label for="errors" style="color: red;display: none;"></label>
							</div>

							<div class="form-group">
								<label for="father-email">Father Email (<code title="required"> * </code>)</label>
								<input type="email" value='<?php if(isset($father_email)){echo $father_email;} ?>' name="father-email" placeholder="Father Email" id="father-email"  >
							</div>
						</div>

						<div id="mother" class="no-collapsed">
							<div class="form-group">
								<label for="mother-name">Mother Name (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($mother_name)){echo $mother_name;} ?>' name="mother-name" placeholder="Mother Name" id="mother-name" >
							</div>

							<div class="form-group">
								<label for="mother-occupation">Mother Occupation (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($mother_occupation)){echo $mother_occupation;} ?>' name="mother-occupation" placeholder="Mother Occupation" id="mother-occupation" >
							</div>

							<div class="form-group">
								<label for="mother-contact-number">Mother Contact Number (<code title="required"> * </code>)</label>
								<input type="number" value='<?php if(isset($mother_contact_number)){echo $mother_contact_number;} ?>' name="mother-contact-number" placeholder="Mother Contact Number" id="mother-contact-number" oninput="validate_contact_number(this)">
								<label for="errors" style="color: red;display: none;"></label>
							</div>

							<div class="form-group">
								<label for="mother-email">Mother Email (<code title="required"> * </code>)</label>
								<input type="email" value='<?php if(isset($mother_email)){echo $mother_email;} ?>' name="mother-email" placeholder="Mother Email" id="mother-email" >
							</div>						
						</div>

						<div id="guardian" class="no-collapsed">
							<div class="form-group">
								<label for="guardian-name">Guardian Name (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($guardian_name)){echo $guardian_name;} ?>' name="guardian-name" placeholder="Guardian Name" id="guardian-name" >
							</div>

							<div class="form-group">
								<label for="guardian-occupation">Guardian Occupation (<code title="required"> * </code>)</label>
								<input type="text" value='<?php if(isset($guardian_occupation)){echo $guardian_occupation;} ?>' name="guardian-occupation" placeholder="Guardian Occupation" id="guardian-occupation" >
							</div>

							<div class="form-group">
								<label for="guardian-contact-number">Guardian Contact Number (<code title="required"> * </code>)</label>
								<input type="number" value='<?php if(isset($guardian_contact_number)){echo $guardian_contact_number;} ?>' name="guardian-contact-number" placeholder="Guardian Contact Number" id="guardian-contact-number" oninput="validate_contact_number(this)">
								<label for="errors" style="color: red;display: none;"></label>
							</div>

							<div class="form-group">
								<label for="guardian-email">Guardian Email (<code title="required"> * </code>)</label>
								<input type="email" value='<?php if(isset($guardian_email)){echo $guardian_email;} ?>' name="guardian-email" placeholder="Guardian Email" id="guardian-email" >
							</div>	
						</div>
						<div class="w-100 p-1"></div>
						<div class="form-group d-flex flex-row w-auto float-right">
							<?php 
								if(isset($is_interviewed) && $is_interviewed != "registered"){
									echo "<a href='".$_GET['back'] ."' name=\"back\" class=\"btn btn-blue w-auto p-2 mr-3\" >back</a>";
									echo "<button type=\"submit\" name=\"submit\" id=\"submit\" class=\"btn btn-blue w-auto p-2\" >Submit</button>";
								}else{
									echo "<a href='".$_GET['back'] ."' name=\"back\" class=\"btn btn-blue w-auto p-2\" >back</a>";
								}
							 ?>
						</div>
					</div>
				</fieldset>
			</div>
		</form>
	</div>
</div>


<?php require_once("../templates/footer.php") ?>