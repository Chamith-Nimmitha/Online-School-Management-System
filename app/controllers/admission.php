<?php 

	class Admission extends Controller{

		public function __construct() {
			parent::__construct();
		}

		// view student registration form and submit
		public function new_admission(){

			$field_errors = array();
			$info = "";
			$error = "";

			// if user submit a form
			if(isset($_POST['submit'])){
				$name_with_initials = addslashes($_POST['name-with-initials']);
				$first_name = addslashes($_POST['first-name']);
				$middle_name = addslashes($_POST['middle-name']);
				$last_name = addslashes($_POST['last-name']);
				$grade =addslashes($_POST['grade']);
				$gender = addslashes($_POST['gender']);
				$dob = addslashes($_POST['dob']);
				$address = addslashes($_POST['address']);
				$email = addslashes($_POST['email']);
				if(!valid_email($email)){
					$all_errors[3] = "Invalid student email address.";
				}
				$contact_number = addslashes($_POST['contact-number']);
				$all_errors[5] = validate_contact_number($contact_number);

				if(isset($_POST['already-have-account']) && $_POST['already-have-account'] == "yes"){
					$already_have_account = 1;
					$parent_account_id = $_POST['parent-account-id'];
				}else{
					$already_have_account = 0;
					$parent_type = addslashes($_POST['parent-type']);
					$father_name = addslashes($_POST['father-name']);
					$father_occupation = addslashes($_POST['father-occupation']);
					$father_contact_number =addslashes( $_POST['father-contact-number']);
					$father_email = addslashes($_POST['father-email']);
					$mother_name = addslashes($_POST['mother-name']);
					$mother_occupation = addslashes($_POST['mother-occupation']);
					$mother_contact_number = addslashes($_POST['mother-contact-number']);
					$mother_email = addslashes($_POST['mother-email']);
					$guardian_name = addslashes($_POST['guardian-name']);
					$guardian_occupation = addslashes($_POST['guardian-occupation']);
					$guardian_contact_number = addslashes($_POST['guardian-contact-number']);
					$guardian_email = addslashes($_POST['guardian-email']);
				}

				$required_fields = array();
				$required_fields['name-with-initials']=[0,50,1,"Name with initials"];
				$required_fields['first-name']=[0,20,1,"First name"];
				$required_fields['middle-name']=[0,50,0,"Middle name"];
				$required_fields['last-name']=[0,20,1,"Last name"];
				$required_fields['grade']=[1,2,1,"Grade"];
				$required_fields['gender']=[1,6,1,"Gender"];
				$required_fields['dob']=[10,10,1,"Dath of birth"];
				$required_fields['address']=[0,100,1,"Address"];
				$required_fields['email']=[0,100,1,"Email"];
				$c_result = validate_contact_number($_POST['contact-number']);
				if($c_result !== 1){
					$field_errors['contact-number'] = $c_result;
				}
				if($already_have_account == 1){
					$required_fields['parent-account-id']=[7,7,1,"Parent Account ID"];
				}else{
					if($parent_type == "father"){
						$required_fields['father-name']=[0,50,1,"Father name"];
						$required_fields['father-occupation']=[0,50,1,"Father Occupation"];
						$c_result = validate_contact_number($_POST['father-contact-number']);
						if($c_result !== 1){
							$field_errors['father-contact-number'] = $c_result;
						}
						$required_fields['father-email']=[0,100,1,"Father Email"];
					}else if($parent_type == "mother"){
						$required_fields['mother-name']=[0,50,1,"Mother name"];
						$required_fields['mother-occupation']=[0,50,1,"Mother Occupation"];
						$c_result = validate_contact_number($_POST['mother-contact-number']);
						if($c_result !== 1){
							$field_errors['mother-contact-number'] = $c_result;
						}
						$required_fields['mother-email']=[0,100,1,"Mother email"];
					}else{
						$required_fields['guardian-name']=[0,50,1,"Guardian name"];
						$required_fields['guardian-occupation']=[0,50,1,"Guardian Occupation"];
						$c_result = validate_contact_number($_POST['guardian-contact-number']);
						if($c_result !== 1){
							$field_errors['guardian-contact-number'] = $c_result;
						}
						$required_fields['guardian-email']=[0,100,1,"Guardian email"];
					}
				}

				$field_errors = array_merge($field_errors,check_input_fields($required_fields));

				if($already_have_account == true){
					$this->model("parent");
					$result = $this->parent->set_by_id($parent_account_id);
					if(!$result){
						$field_errors['parent_account_id'] = "Parent id is not valid.";
					}
				}
				if(empty($field_errors)){
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
						if(!valid_email($data['parent_email'])){
							$field_errors["{$parent_type}_email"] = "Invalid {$parent_type} email address.";
						}

						$contact_errors = validate_contact_number($data['parent_contact_number']);
						if($contact_errors !== 1){
							$field_errors['{$parent_type}_contact_number'] = "Invalid {$parent_type} Contact Number.";
						}
					 }else{
						$data['parent_account_id'] = $parent_account_id;
					 	$data["parent_name"]= "";
						$data["parent_occupation"]= "";
						$data["parent_contact_number"]= "";
						$data["parent_email"]= "";
					 }

					 if(count($field_errors) === 0 ){
						$this->load->model("admission");
						$result = $this->load->admission->insert_data($data);
						if($result){
						$info = "Admission send successfully.We will send you interview data as soon as posible.";
							unset($_POST);
						}else{
							$error = "Registration failed.";
						}
					}

				}
			}
			$this->view_header_and_aside();
			$this->load->view("student/student_registration",["field_errors"=>$field_errors,"info"=>$info,"error"=>$error]);
			$this->load->view("templates/footer");
		}

		// show admissions list
		public function list($page=Null, $per_page=Null){
			// check view  permissions
			if(!$this->checkPermission->check_permission("admission","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			// count page info for pagination
			if($per_page === NULL){
				$per_page = 1;
			}
			if($page === Null){
				$page = 1;
				$start = 0;
			}else{
				$start = ($page-1)*$per_page;
			}

			$data['page'] = $page;
			$data['per_page'] = $per_page;
			$data['start'] = $start;


			if(isset($_POST['admission-state']) && $_POST['admission-state'] != "all"){
				$admission_state = $_POST['admission-state'];
			}else{
				$admission_state = NULL;
			}
			if(isset($_POST['admission-search']) && !empty($_POST['admission-search'])){
				$admission_search = $_POST['admission-search'];
			}else{
				$admission_search = NULL;
			}
			$data['admission_search'] = $admission_search;
			$data['admission_state'] = $admission_state;
			$this->load->model("admission");
			$result_set = $this->load->admission->get_list($start,$per_page,$admission_search,$admission_state);
			if($result_set){
				$result_set = $result_set->fetchAll();
			}
			$data['result_set'] = $result_set;
			$data['count'] = $this->load->admission->get_count()->fetch()['count'];
			$this->view_header_and_aside();
			$this->load->view("admission/admission_list",$data);
			$this->load->view("templates/footer");
		}

		//delte a admission
		public function delete($admission_id){
			if(!$this->checkPermission->check_permission("admission","delete")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			$con->update("admission",array("state"=>"deleted"),array("id"=>$admission_id));
			header("Location:".set_url('admission/list/all'));
		}

		public function view_admission($admission_id){
			if(!$this->checkPermission->check_permission("admission","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			if(isset($_POST['accept'])){
				$con->update('admission',array("state"=>"accepted"),array("id"=>$admission_id));
				header("Location:".set_url("interview/set"));
			}else if(isset($_POST['reject'])){
				$con->update('admission',array("state"=>"rejected"),array("id"=>$admission_id));
				header("Location:".set_url('admission/list'));
			}else if(isset($_POST['delete'])){
				$con->update('admission',array("state"=>"deleted"),array("id"=>$admission_id));
				header("Location:".set_url('admission/list'));
			}
			$this->load->model("admission");
			$admission_data = $this->load->admission->get_data($admission_id);
			if(!$admission_data){
				echo "Admisiion not found";
				exit();
			}
			if($admission_data['state'] === "unread"){
				$con->update('admission',array("state"=>"read"),array("id"=>$admission_id));
			}

			$data['result'] = $admission_data;
			$this->view_header_and_aside();
			$this->load->view("admission/admission_view",$data);
			$this->load->view("templates/footer");
		}
	}