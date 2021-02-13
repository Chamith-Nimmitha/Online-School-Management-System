<?php 
	
	class Interview extends Controller{

		public function __construct() {
			parent::__construct();
		}

		// set or update interview
		public function set($admission_id){
			if(!$this->checkPermission->check_permission("interview","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			$error = "";
			$info = "";
			$this->load->model("interview");
			$this->load->model("admission");
			$this->load->admission->change_state($admission_id,"Accepted");
			//when cre ate inteview
			if(isset($_POST['submit'])){
				try{
					$con->db->beginTransaction();
					if($_POST['interview-panel'] === "0"){
						throw new PDOException("Please select a interview panel.", 1);
					}
					if($_POST['interview-date'] === "0"){
						throw new PDOException("Please select a interview date.", 1);
					}
					if($_POST['interview-time'] === "0"){
						throw new PDOException("Please select a interview time.", 1);
					}

					$data['admission_id'] = $admission_id;
					$data['interview_panel_id'] = $_POST['interview-panel'];
					$data['date'] = explode("#",$_POST['interview-date'])[0];
					$data['period'] = $_POST['interview-time'];


					$result = $this->load->interview->get_interview_data($admission_id);
					if($result->rowCount() === 0){
						if(!$this->checkPermission->check_permission("interview","create")){
							$this->view_header_and_aside();
							$this->load->view("common/error");
							$this->load->view("templates/footer");
							return;
						}
						$result = $this->load->interview->set_interview_data($data);
						if(!$result || $result->rowCount() !== 1){
							throw new PDOException("Interview creation failed.", 1);
						}
					}else{
						if(!$this->checkPermission->check_permission("interview","update")){
							$this->view_header_and_aside();
							$this->load->view("common/error");
							$this->load->view("templates/footer");
							return;
						}
						$result = $this->load->interview->update_interview_data($admission_id,$data);
						if(!$result){
							throw new PDOException("Interview Update failed.", 1);
						}else{
							$result = $this->load->admission->change_state($admission_id,"Not Interview");
							if(!$result){
								throw new PDOException("Admission State update failed.");
							}
						}
					}
					$info = "Set Interview successful..";
					$con->db->commit();
				}catch( PDOException $e){
					$con->db->rollBack();
					$error = $e->getMessage();
				}
			}else{
				$result = $this->load->interview->get_interview_data($admission_id);
				if($result->rowCount() != 0){
					$result = $result->fetch();
					$_POST['interview-panel'] = $result["interview_panel_id"];
					$_POST['interview-date'] = ($result["date"])."#".strtolower(date("D",strtotime($result["date"])));
					$_POST['interview-time'] = $result["period"];
				}
			}

			if(isset($admission_id)){
				$con->where(array("id"=>$admission_id));
				$result = $con->select("admission")->fetch();
			}else{
				header("Location:". set_url("admission/list"));
			}
			$this->load->model("interviewPanel");
			$interview_panels = $this->load->interviewPanel->get_interview_panels(["grade"=>$result['grade']]);
			$valid_panels = [];
			$timetables = [];

			$day_map = ["mon"=>"monday", "tue"=>"tuesday", "wed"=>"wednesday", "thu"=>"thursday", "fri"=>"friday"];

			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
			
			foreach ($interview_panels as $row) {
				$timetable_id = $con->select('normal_timetable',array('user_id'=>$row['id'],"type"=>"interview"))->fetch()['id'];
				$days = $con->select("normal_day",array("timetable_id"=>$timetable_id));

				foreach ($days as $day){
					if($day['task'] == "1"){
						if(isset($timetables[$row['id']])){
							if(isset($timetables[$row['id']][$day['day']])){
								array_push($timetables[$row['id']][$day['day']], $day['period']);
							}else{
								$timetables[$row['id']][$day['day']] = [$day['period']];
							}
						}else{
							$d = [];
							$d[$day['day']] = [$day['period']];
							$timetables[$row['id']] = $d;
							array_push($valid_panels, [$row['id'],$row['name']]);
						}
					}
				}
			}
			$data['error'] = $error;
			$data['info'] = $info;
			$data['timetables'] = $timetables;
			$data['result'] = $result;
			$data['valid_panels'] = $valid_panels;
			$data['day_map'] = $day_map;
			$data['time_map'] = $time_map;
			$this->view_header_and_aside();
			$this->load->view("admission/admission_set_interview",$data);
			$this->load->view("templates/footer");
		}

		// get interview list
		public function list(){
			if(!$this->checkPermission->check_permission("interview","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$admission_id = NULL;
			$panel_id = NULL;
			$state = 'all';

			if(isset($_POST['search'])){
				$admission_id = addslashes(trim($_POST['admission-id']));
				$panel_id = addslashes(trim($_POST['panel-id']));
				$state = addslashes(trim($_POST['state']));
				if( strlen($admission_id) === 0){
					$admission_id = NULL;
				}
				if( strlen($panel_id) === 0){
					$panel_id = NULL;
				}
			}

			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];

			$this->load->model("interview");
			$result_set = $this->load->interview->search($admission_id,$panel_id,$state);
			if($result_set){
				$result_set = $result_set->fetchAll();
				$data['result_set'] = $result_set;
				$data['time_map'] = $time_map;
			}else{
				echo "query error";
				exit();
			}
			$this->view_header_and_aside();
			$this->load->view("interview/interview_list",$data);
			$this->load->view("templates/footer");
		}

		// view,update admission  and create user accounts
		public function view_admission($admission_id){
			if(!$this->checkPermission->check_permission("admission","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("admission");
			$this->load->model("interview");
			$con = new Database();
			$error = "";
			$info = "";
			$field_errors = [];
			// when submit the data
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
					$this->load->model("parent");
					$result = $this->load->parent->set_by_id($parent_account_id);
					if(!$result){
						$field_errors['parent_account_id'] = "Parent id is not valid.";
					}
				}
				$this->load->model("timetable");
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
					$data['already_have_account'] = $already_have_account;
					if($already_have_account == 0){
						$data['parent_type'] = $_POST["parent-type"];
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
					$data["state"] = "Registered";
					if(count($field_errors) === 0 ){
						if(!$this->checkPermission->check_permission("admission","update") || !$this->checkPermission->check_permission("user_account","create")){
							$this->view_header_and_aside();
							$this->load->view("common/error");
							$this->load->view("templates/footer");
							return;
						}
						$con->db->beginTransaction();
						$result = $con ->update('admission',$data,array("id"=>$admission_id));
						if($result){
							try{
								if($data["already_have_account"] == 0){
									$parent_data['name'] = $data["parent_name"];
									$parent_data['type'] = $data["parent_type"];
									$parent_data['occupation'] = $data["parent_occupation"];
									$parent_data['address'] = $data["address"];
									$parent_data['contact_number'] = $data["parent_contact_number"];
									$parent_data['email'] = $data["parent_email"];
									$con->get(array("id"));
									$result = $con->select("parent",array("email"=>$parent_data["email"]));
									if(!$result){
										throw new PDOException('Faild to insert to parent table', 1 );
									}else if($result->rowCount() == 1){
										$parent_id = $result->fetch()['id'];
									}else{
										$result = $con->insert("parent",$parent_data);
										$con->get(array("id"));
										$result = $con->select("parent",array("name"=>$parent_data['name'],"email"=>$parent_data["email"]));
										if($result->rowCount() == 0){
											throw new PDOException('Error when get parent id', 1 );
										}
										$parent_id = $result->fetch()['id'];
										$user_data = array();
										$user_data['email'] = $data["parent_email"];
										$user_data['role'] = "parent";
										$result = $con->insert("user",$user_data);
										if(!$result){
											throw new PDOException('Faild to insert  parent to user table', 1 );
										}
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
								if(!$result || $result->rowCount() ===0){
									throw new PDOException('Faild student insert to student table', 1 );
								}
								$user_data = array();
								$user_data['email'] = $data["email"];
								$user_data['role'] = "student";
								$result = $con->insert("user",$user_data);
								if(!$result || $result->rowCount()===0){
									throw new PDOException('Faild to insert student to user table', 1 );
								}
								$con->get(array("id"));
								$result = $con->select("student",array("name_with_initials"=>$student_data['name_with_initials'],"email"=>$student_data["email"]));
								if($result->rowCount() != 1){
									throw new PDOException('Faild to get student id', 1 );
								}
								$student_id = $result->fetch()['id'];

								$res1 =$con->update("admission", ["state"=>"Registered"],["id" =>$admission_id]);
								$res2 =$con->update("interview", ["state"=>"Interviewed"],["id" =>$admission_id]);

								if(!$res1 || !$res2){
									throw new PDOException("State Upadate Failed.", 1);
								}
								
								if(!$result){
									throw new PDOException("Faild to update interview state.",1);
								}

								$con->db->commit();
								$info = "Student and Parent Registration Successful.";
								// header("Location:". set_url("interview/get_files/".$admission_id));
							}catch(Exception $e){
								$con->db->rollback();
								$error = $e->getMessage();
							}
						}else{
							$error = "Account creation failed.";
						}
					}
				}
			}

			// view admission data
			$result = $this->load->admission->get_data($admission_id);
			if(!$result){
				echo "Admission Not Found";
				exit();
			}else{
				if($result['already_have_account'] != 1){
					$parent_type = $result['parent_type'];
					switch ($parent_type) {
						case 'father':
							$result['father_name'] = $result['parent_name'];
							$result['father_occupation'] = $result['parent_occupation'];
							$result['father_contact_number'] = $result['parent_contact_number'];
							$result['father_email'] = $result['parent_email'];
							break;
						case 'mother':
							$result['mother_name'] = $result['parent_name'];
							$result['mother_occupation'] = $result['parent_occupation'];
							$result['mother_contact_number'] = $result['parent_contact_number'];
							$result['mother_email'] = $result['parent_email'];
							break;
						default:
							$result['guardian_name'] = $result['parent_name'];
							$result['guardian_occupation'] = $result['parent_occupation'];
							$result['guardian_contact_number'] = $result['parent_contact_number'];
							$result['guardian_email'] = $result['parent_email'];
							break;
					}
				}
				$data['result'] = $result;
			}
			$data['error'] = $error;
			$data['info'] = $info;
			$this->view_header_and_aside();
			$this->load->view("interview/interview_admission_view",$data);
			$this->load->view("templates/footer");
		}

		// get documents
		public function get_files($admission_id){
			$this->view_header_and_aside();
			$this->load->view("admission/admission_student_register",$data);
			$this->load->view("templates/footer");
		}

	}

 ?>