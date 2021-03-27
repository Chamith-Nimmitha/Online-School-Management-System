<?php
     class Teacher extends Controller{
		
		//view the list of teachers
		public function list($page=Null, $per_page=Null){
			if($per_page === NULL){
				$per_page = PER_PAGE;
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

			if(isset($_POST['teacher-id']) && !empty($_POST['teacher-id'])){
				$teacher_search = $_POST['teacher-id'];
			}else{
				$teacher_search = NULL;
			}
			
			$data['teacher_search'] = $teacher_search;
			$this->load->model("teachers");
			$result_set = $this->load->teachers->get_teacher_list($start,$per_page,$teacher_search,$teacher_search);
			$data['result_set'] = $result_set;
			$data['count'] = $this->load->teachers->get_count()->fetch()['count'];
			
			$this->view_header_and_aside();
			$this->load->view("teacher/teacher_all",$data);
			$this->load->view("templates/footer");

		}
		//register new teachers
		public function new_teacher(){
			if(!$this->checkPermission->check_permission("teacher","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$field_errors = array();
			$info = "";
			$error = "";
			
			if(isset($_POST['submit'])){

				$name_with_initials = addslashes($_POST['name_with_initials']);
				$first_name = addslashes($_POST['first_name']);
				$middle_name = addslashes($_POST['middle_name']);
				$last_name = addslashes($_POST['last_name']);
				$gender = addslashes($_POST['gender']);
				$dob = addslashes($_POST['dob']);
				$address = addslashes($_POST['address']);
				$email = addslashes($_POST['email']);
				$nic = addslashes($_POST['nic']);

			
				if(!valid_email($email)){
					$field_errors["email"] = "Invalid email address.";
				}

				$contact_number = addslashes($_POST['contact_number']);
		

				$required_fields = array();
				$required_fields['name_with_initials']=[0,50,1,"Name with initials"];
				$required_fields['first_name']=[0,20,1,"First name"];
				$required_fields['middle_name']=[0,50,0,"Middle name"];
				$required_fields['last_name']=[0,20,1,"Last name"];
				$required_fields['gender']=[1,6,1,"Gender"];
				$required_fields['dob']=[10,10,1,"Dath of birth"];
				$required_fields['address']=[0,100,1,"Address"];
				$required_fields['email']=[0,100,1,"Email"];
				$required_fields['nic']=[10,12,1,"NIC"];
				$required_fields['contact_number']=[10,10,1,"Contact Number"];

				$c_result = validate_contact_number($_POST['contact_number']);
				if($c_result !== 1){
					$field_errors['contact-number'] = $c_result;
				}

				$field_errors = array_merge($field_errors,check_input_fields($required_fields));

				if(empty($field_errors)){
					$data = array();
					$data['name_with_initials']=$name_with_initials;
					$data['first_name']=$first_name;
					$data['middle_name']=$middle_name;
					$data['last_name']=$last_name;
					$data['gender']=$gender;
					$data['dob']=$dob;
					$data['address']=$address;
					$data['email']=$email;
					$data['nic']=$nic;
					$data['contact_number']=$contact_number;
					$data['username']="";

					if(!isset($middle_name)){
						$data['middle_name']="";
					}

				}

				if(count($field_errors) === 0 ){
					$this->load->model('teacher');
					$result = $this->load->teacher->insert_data($data);
					if($result){
						$info = "Teacher Registration Successful.";
						unset($_POST);
					}else{
						$error = "Registration failed.";
					}

				}else{
					$error="Registration failed.";
				}



			}


			$this->view_header_and_aside();
            $this->load->view("teacher/teacher_registration_form",["field_errors"=>$field_errors,"info"=>$info,"error"=>$error]);
            $this->load->view("templates/footer");
		}

		//update teacher details
		public function update_teacher($teacher_id){

			if(!$this->checkPermission->check_permission("teacher","update")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			$field_errors = array();
			$info = "";
			$error = "";
			
			if(isset($_POST['update'])){

				$name_with_initials = addslashes($_POST['name_with_initials']);
				$first_name = addslashes($_POST['first_name']);
				$middle_name = addslashes($_POST['middle_name']);
				$last_name = addslashes($_POST['last_name']);
				$gender = addslashes($_POST['gender']);
				$dob = addslashes($_POST['dob']);
				$address = addslashes($_POST['address']);
				$email = addslashes($_POST['email']);
				$nic = addslashes($_POST['nic']);

			
				if(!valid_email($email)){
					$field_errors["email"] = "Invalid email address.";
				}

				$contact_number = addslashes($_POST['contact_number']);
		

				$required_fields = array();
				$required_fields['name_with_initials']=[0,50,1,"Name with initials"];
				$required_fields['first_name']=[0,20,1,"First name"];
				$required_fields['middle_name']=[0,50,0,"Middle name"];
				$required_fields['last_name']=[0,20,1,"Last name"];
				$required_fields['gender']=[1,6,1,"Gender"];
				$required_fields['dob']=[10,10,1,"Dath of birth"];
				$required_fields['address']=[0,100,1,"Address"];
				$required_fields['email']=[0,100,1,"Email"];
				$required_fields['nic']=[10,12,1,"NIC"];
				$required_fields['contact_number']=[10,10,1,"Contact Number"];

				$c_result = validate_contact_number($_POST['contact_number']);
				if($c_result !== 1){
					$field_errors['contact-number'] = $c_result;
				}

				$field_errors = array_merge($field_errors,check_input_fields($required_fields));

				if(empty($field_errors)){
					$data = array();
					$data['name_with_initials']=$name_with_initials;
					$data['first_name']=$first_name;
					$data['middle_name']=$middle_name;
					$data['gender']=$gender;
					$data['dob']=$dob;
					$data['address']=$address;
					$data['nic']=$nic;
					$data['contact_number']=$contact_number;
					$data['email']=$email;
					$data['last_name']=$last_name;
					

					if(!isset($middle_name)){
						$data['middle_name']="";
					}

				}

				if(count($field_errors) === 0 ){
						$con->db->beginTransaction();
						try {
								$result=$con->update("teacher",$data,array("id"=>$teacher_id));
								if(!$result){
									throw new PDOException("Failed to Update.", 1);
								}else if(!$result || $result->rowCount() !== 1){
									throw new PDOException("Nothing to update.", 1);
								}

								$con->db->commit();	
						}catch (Exception $e) {
							$con->db->rollback();
							$error = $e->getMessage();
						}

					if(empty($error)){
						$info="Updated Successfully";
					}
					

				}else{
					$error="Registration failed.";
				}



			}


			$this->load->model("teacher");
			$this->load->teacher->set_by_id($teacher_id);
			$teacher_data=$this->load->teacher->get_data();
			$data1['data'] = $teacher_data;

			foreach ($teacher_data as $name => $value) {
				$row[$name]=$value;
			}


			$this->view_header_and_aside();
            $this->load->view("teacher/teacher_list_update",["data"=>$row,"field_errors"=>$field_errors,"info"=>$info,"error"=>$error]);
            $this->load->view("templates/footer");
		}

		// delete a teacher
		public function delete($teacher_id){
			if(!$this->checkPermission->check_permission("teacher","delete")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con=new Database();
			$result=$con->delete('teacher',array('id'=>$teacher_id));

			header("Location:". set_url("teacher/list"));
		}

		public function teacher_timetable($teacher_id=NULL){
			if($teacher_id == NULL){
				$teacher_id = $_SESSION['user_id'];
			}
			$error = "";
			$this->load->model("teacher");
			$result = $this->load->teacher->set_by_id($teacher_id);

			if(!$result){
				$error = "Teacher Not Found.";
			}else{
				$data['teacher_info'] = $this->load->teacher->get_data();
			}
			$result = $this->load->teacher->get_timetable();
			if($result){
				$data['timetable'] = $result;
			}

			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
			$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
			$data['time_map'] = $time_map;
			$data['day_map'] = $day_map;


			$data['error'] = $error;
			$this->view_header_and_aside();
			$this->load->view("teacher/teacher_timetable",$data);
			$this->load->view("templates/footer");
		}
		// teacher subject list
		public function subject_list($teacher_id=NULL){
			if(!$this->checkPermission->check_permission("subject","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			if($teacher_id==NULL){
				$teacher_id = $_SESSION['user_id'];
			}

			$con = new Database();
			$info = "";
			$error = "";
			$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
			if(isset($_POST['submit'])){
				$teacher_id = $_POST['id'];
				$result = $con->select("teacher",array("id"=>$teacher_id));
				if($result && $result->rowCount() == 1){
					if(!empty($teacher_id)){
						try{
							$con->db->beginTransaction();
							foreach ($_POST as $key => $value) {
								if( strpos($key, "subject") === 0 && strpos($key, "id") !== False){
									if(!empty($value)){
										$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$_POST["old-".$key]));
										if($result && $result->rowCount() >0){
											$result = $con->update("teacher_subject",array("subject_id"=>$value),array("teacher_id"=>$teacher_id, "subject_id"=>$_POST["old-".$key]));
											if(!$result){
												throw new PDOException("Subject update error.".$value	,1);
											}
										}else if($result){
											$result = $con->insert("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$value));
											if(!$result || $result->rowCount() ==0){
												throw new PDOException("Subject insertion error.",1);
											}
											$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$value));
											if(!$result || $result->rowCount() !==1){
												throw new PDOException("Subject insertion error.",1);
											}
											$result = $result->fetch();
											$user_id = $result['id'];
											$result = $con->insert("normal_timetable",array("type"=>"subject", "user_id"=>$user_id));
											if(!$result || $result->rowcount() !== 1){
												throw new PDOException("Timetable creation error.fff",1);
											}
											$result = $con->select("normal_timetable",array("type"=>"subject", "user_id"=>$user_id));
											if(!$result || $result->rowcount() !== 1 ){
												throw new PDOException("Timetable creation error.qqqqq",1);
											}
											$timetable_id = $result->fetch()['id'];
											for ($i=1; $i <= 5; $i++) { 
												for ($j=1; $j <= 8; $j++) { 
													$result = $con->insert("normal_day",array("timetable_id"=>$timetable_id, "day"=>$day_map[$i], "period"=>$j));
													if(!$result || $result->rowCount() !== 1){
														throw new PDOException("Timetable creation error.",1);
													}
												}
											}

										}
									}else{
										throw new PDOException("Subject Id is empty.",1);
									}
								}
							}
							$info = "Successfully Update.";
							$con->db->commit();
						}catch (Exception $e){
							$con->db->rollback();
							$error = $e->getMessage();
						}
					}else{
						$error = "Please fill teacher ID or Name.";
					}
				}else{
					$error = "Invalid teacher ID";
				}
			}
			
			$this->load->model("teacher");
			$foundTeacher = $this->load->teacher->set_by_id($teacher_id);
			if(!$foundTeacher){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;	
			}
			$result_set = $this->load->teacher->get_subjects();
			if($result_set){
				$data['subjects'] = $result_set->fetchAll();
			}else{
				$data['subjects'] = [];
			}

			$data['teacher_info']=$this->load->teacher->get_data();
			$data['info'] = $info;
			$data['error'] = $error;

			$this->view_header_and_aside();

			if(isset($_SESSION['role']) && $_SESSION['role']=='teacher'){
	            $this->load->view("teacher/teacher_subject_list_view",$data);
        	}
        	else if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){
	            $this->load->view("teacher/teacher_subject_list",$data);
        	}
            $this->load->view("templates/footer");
		}

		// teacher specific subject allocated sudent list
		public function student_list($teacher_subject_id){
			if(!$this->checkPermission->check_permission("student","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			$this->load->model("subjects");
			if(isset($_POST['submit'])){
				$student_ids = [];
				foreach ($_POST as $key => $value) {
					if( strpos($key, "student-") === 0){
						array_push($student_ids, $value);
					}
				}
				if(!empty($student_ids)){
					$result = $this->load->subjects->remove_student_from_subject($teacher_subject_id,$student_ids);
					if($result){
						$data['msg'] = "Students Remove Successful.";
					}else{
						$data['error'] = "Students Remove Failed";
					}
				}
			}
			$result_set = $this->load->subjects->get_student_list($teacher_subject_id);
			if($result_set){
				$data['student_list'] = $result_set->fetchAll();
			}else{
				$data['student_list'] = [];
			}

			$result_set = $this->load->subjects->get_teacher_subject_info($teacher_subject_id);
			if($result_set){
				$data['teacher_subject_info'] = $result_set->fetch();
			}else{
				$data['teacher_subject_info'] = [];
			}
			$data['teacher_subject_id'] = $teacher_subject_id;
			$this->view_header_and_aside();
			if(isset($_SESSION['role']) && $_SESSION['role']=='teacher'){
	            $this->load->view("teacher/teacher_subject_student_list_view",$data);
        	}
        	else if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){
	            $this->load->view("teacher/teacher_subject_student_list",$data);	
        	}
            $this->load->view("templates/footer");
		}
		
		// add new student to clasroom
		public function student_add($teacher_subject_id){


			$this->load->model("subjects");
			if(isset($_POST['submit'])){
				$student_ids = [];
				foreach ($_POST as $key => $value) {
					if( strpos($key, "student-") === 0){
						array_push($student_ids, $value);
					}
				}
				if(!empty($student_ids)){
					$result = $this->load->subjects->assign_student_to_subject($teacher_subject_id,$student_ids);
					if($result){
						$data['msg'] = "Student Assign Successful.";
					}else{
						$data['error'] = "Student Asign Failed";
					}
				}
			}

			$result_set = $this->load->subjects->get_student_list_not_subject($teacher_subject_id);
			if($result_set){
				$data['student_list'] = $result_set->fetchAll();
			}else{
				$data['student_list'] = [];
			}

			$result_set = $this->load->subjects->get_tea_sub_class_list($teacher_subject_id);
			if($result_set){
				$data['class_list'] = $result_set->fetchAll();
			}else{
				$data['class_list'] = [];
			}

			$result_set = $this->load->subjects->get_teacher_subject_info($teacher_subject_id);
			if($result_set){
				$data['teacher_subject_info'] = $result_set->fetch();
			}else{
				$data['teacher_subject_info'] = [];
			}

			$data['teacher_subject_id'] = $teacher_subject_id;
			$this->view_header_and_aside();
            $this->load->view("teacher/teacher_subject_student_add",$data);
            $this->load->view("templates/footer");

		}

		//import teacher details using csv files
		// upload csv files
        public function teacher_upload()
        {
            $field_errors = array();
            $col_error = array();
            $error = "";
            $info = "";

            if(isset($_POST["submit"]))
            {
                if($_FILES['file']['name'])
                {
                    $filename = explode(".", $_FILES['file']['name']);

                    if($filename[1] == 'csv')
                    {
                        $handle = fopen($_FILES['file']['tmp_name'], "r");

                        while($dataset = fgetcsv($handle))
                        {
                            //$error = '';
                            $colcount = count($dataset);
                            $info = '';
                            //echo '<tr>';

                            if($colcount != 3)
                            {
                                //$error = 'Column count incorrect';
                                //$field_errors['$colcount'] = "Column count incorrect";
                                $col_error[0] = "Column count incorrect";
                            }
                            else
                            {
                                if($colcount == 3)
                                {
                                    //checking data types
                                    if((is_numeric($dataset[0])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[0]'] = "Error";
                                    }

                                    if(!(is_string($dataset[1])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[1]'] = "Error";
                                    }

                                    if(!(is_numeric($dataset[2])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[2]'] = "Error";
									}
									
									if(!(is_string($dataset[3])))
                                    {
                                        //$error = 'error';
                                        $field_errors['dataset[3]'] = "Error";
                                    }

                                    
                                }
                                // else
                                // {
                                //     if(!(is_numeric($data[0])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }

                                //     if(!(is_string($data[1])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }

                                //     if(!(is_string($data[2])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }

                                //     if(!(is_string($data[3])))
                                //     {
                                //         //$error = 'error';
                                //         $field_errors['error'] = $error;
                                //     }
                                // }

                            }

                            $field_errors = array_merge($field_errors, $col_error);

                            if(empty($field_errors))
                            {
                                $data = array();

                                $data["name_with_initials"] = $dataset[0];
                                $data["email"] = $dataset[1];
								$data["contact_number"] = $dataset[2];
								$data["nic"] = $dataset[3];
                            }

                            if(count($field_errors) === 0)
                            {
                                $this->load->model("teacher");
                                $result = $this->load->teacher->insert_data($data);

                                if($result)
                                {
                                    $info = "File Uploaded Successfully.";
                                    //unset($_POST);
                                }
                                else
                                {
                                    $info = "File Uploading Fail.";
                                }
                                // else
                                // {
                                //     $this->load->view("teacher/teacher-upload");
                                // }
                            }
                            else
                            {
                                $info = "File Uploading Fail.......................";
                            }
                            // if(!(empty($field_error)))
                            // {
                            //     $this->load->view("teacher/teacher_upload");
                            // }


                            //echo '</tr>';


                         /*   if($error)
                            {
                                $this->load->view("subject/subject-upload");   
                            }
                            else
                            {
                                $this->load->view("subject/subject-upload");
                            }*/
                        }

                    /*if(!(empty($field_error)))
                        {
                            //$this->load->view("subject/subject_upload");
                            return;
                            //$this->view_header_and_aside();
                            //$this->load->view("subject/subject_upload", ["field_error"=>$field_error,"info"=>$info,"error"=>$error]);
                            //$this->load->view("templates/footer");
                        }*/
                    }

                    fclose($handle);
                }
            }
            

            $this->view_header_and_aside();
            $this->load->view("teacher/teacher_upload", ["field_errors"=>$field_errors,"info"=>$info,"error"=>$error]);
            $this->load->view("templates/footer");
        }

        
        // teacher specific subject timetable

        public function subject_timetable($teacher_subject_id){
        	if(!$this->checkPermission->check_permission("subject","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
			$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
			$data['time_map'] = $time_map;
			$data['day_map'] = $day_map;

			$this->load->model("subjects");
			$result = $this->load->subjects->get_teacher_subject_info($teacher_subject_id);
			$teacher_id = $result->fetch()['teacher_id'];


			// get subject and grade info
			$result = $this->load->subjects->get_teacher_subject_info($teacher_subject_id);
			if($result){
				$data['teacher_subject_info'] = $result->fetch();
			}
			$this->load->model("teacher");
			$this->load->teacher->set_by_id($teacher_id);
			$data['timetable'] = $this->load->teacher->get_timetable();
			$this->view_header_and_aside();

			$this->load->view("teacher/teacher_subject_timetable",$data);
			$this->load->view("templates/footer");

        } 

		public function import(){
			if(isset($_POST['save']))
			{
					$file = $_FILES['file']['tmp_name'];
					$handle = fopen($file, "r");
					$c = 0;/*
					while(($filesop = fgetcsv($handle, 1000, ",")) !== false)*/
					{
						$name_with_initials = $filesop[0];
						$email = $filesop[1];
						$contact_number = $filesop[2];
						$nic = $filesop[3];
						$data = array(
							'id'=> null,
							'name_with_initials' =>$name_with_initials,
							'email' =>$email,
							'contact_number' => $contact_number,
							'nic' => $nic
						);
						if($c<>0){					/*SKIP THE FIRST ROW*/
							$this->model->submit_details($data);
						}
						$c = $c + 1;
					}
					echo "Data imported successfully !"	;
			}
			$this->load->view('teacher/teacher_all');
		}

		// view individual teacher attendance
		public function attendance($teacher_id=NULL){

			if(!$this->checkPermission->check_permission("attendance","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			if($teacher_id == NULL){
                if(isset($_POST['id'])){
                    $teacher_id = $_POST['id'];
                }else{
                    $teacher_id = $_SESSION['user_id'];
                }
            }else{
                if($_SESSION['role'] == "teacher"){
                    $teacher_id = $_SESSION['user_id'];
                }
            }
			$data = [];
			$this->load->model("attendance");
            $result_set = $this->load->attendance->get_attendance_by_teacher_id($teacher_id);
            if($result_set){
                $data['result_set'] = $result_set->fetchAll();
            }else{
                $data['result_set'] = FALSE;
            }
            $data['teacher_id'] = $teacher_id;
			$this->view_header_and_aside();
            $this->load->view("attendance/teacher_attendance_view",$data);
            $this->load->view("templates/footer");
		}

		// interview panel view
		public function interview_panel_view($teacher_id=NULL){
			if(!$this->checkPermission->check_permission("interview_panel","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			if($teacher_id == NULL){
				$teacher_id = $_SESSION['user_id'];
			}

			$this->load->model("teacher");
			$this->load->teacher->set_by_id($teacher_id);
			$interview_panel_id = $this->load->teacher->get_interview_panel_id();

			$this->load->model("interviewPanel");
			$result = $this->load->interviewPanel->get_interview_panels(['id'=>$interview_panel_id]);
			if($result){
				$data['interview_panel'] = $result->fetch();
				$result = $this->load->interviewPanel->get_interview_panel_teachers($interview_panel_id);
				if($result){
					$data['interview_panel_teachers'] = $result->fetchAll();
				}
			}

			$this->view_header_and_aside();
			$this->load->view("teacher/teacher_interview_panel_view",$data);
			$this->load->view("templates/footer");
		}

		// get teacher related interview list
		public function interview_list($page=Null, $per_page=NULL){
			if(!$this->checkPermission->check_permission("interview_panel","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}


			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
			// count page info for pagination
			if($per_page === NULL){
				$per_page = PER_PAGE;
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

			$this->load->model("teacher");
			$this->load->teacher->set_by_id($_SESSION['user_id']);
			$interview_panel_id = $this->load->teacher->get_interview_panel_id();
			$data['panel_id'] = $interview_panel_id;
			$this->load->model("interview");
			$result = $this->load->interview->search($start,$per_page,NULL,$interview_panel_id);
			$data['time_map']= $time_map;
			if($result){
				$data['interviews'] = $result->fetchAll();
				$data['count'] = $this->load->interview->get_count()->fetch()['count'];
			}

			$this->view_header_and_aside();
			$this->load->view("teacher/teacher_interview_list",$data);
			$this->load->view("templates/footer");
		}

		// get classroom attendance
		public function classroom_attendance(){
			if(!$this->checkPermission->check_permission("attendance","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			$this->load->model("teacher");
			$result = $this->load->teacher->set_by_id($_SESSION['user_id']);
			if(!$result){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			$classroom_id = $this->load->teacher->get_classroom_id();
			if(!$classroom_id){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$attendance_controller = new Attendance();
			$attendance_controller->classroom_view($classroom_id);
		}

		public function teacher_dashboard(){

		if(!$this->checkPermission->check_permission("dashboard","view")){
						$this->view_header_and_aside();
						$this->load->view("common/error");
						$this->load->view("templates/footer");
						return;
					}
					$this->load->model("user");
					$counts = $this->load->user->get_staticstic_count();
					$data['count'] = $counts;

					if(isset($_SESSION['login_msg'])){
						$data['msg'] = $_SESSION['login_msg'];
						unset($_SESSION['login_msg']);
					}
					if(isset($_SESSION['del_msg'])){
						$data['del_msg'] = $_SESSION['del_msg'];
						unset($_SESSION['del_msg']);
					}

					$is_classroom_teacher = 0;
					$show_notice_board = 0;
					$statics_link_show = 0;
					$statics_link_show = 1;

					if($_SESSION['role'] == "teacher"){
						$this->load->model("teacher");
						$this->load->teacher->set_by_id($_SESSION['user_id']);
						$cls = $this->load->teacher->get_classroom_object();
						if($cls){
							$data['notice_classroom_id'] = $cls->get_id();
							$data['grade'] = $cls->get_grade();
							$data['class'] = $cls->get_class();
							$result = $cls->get_notices();
							if($result  && $result->rowCount() >0){
								$data['classroom_notices'][0] = ["notices"=>$result->fetchAll(),"grade"=>$cls->get_grade(),"class"=>$cls->get_class()];
							}
							$is_classroom_teacher = 1;
							$show_notice_board = 1;
						}
					}


					$data['is_classroom_teacher'] = $is_classroom_teacher;
					$data['show_notice_board'] = $show_notice_board;
					$data['statics_link_show'] = $statics_link_show;

						$teacher_id = $_SESSION['user_id'];
					$error = "";
					$this->load->model("teacher");
					$result = $this->load->teacher->set_by_id($teacher_id);

					if(!$result){
						$error = "Teacher Not Found.";
					}else{
						$data['teacher_info'] = $this->load->teacher->get_data();
					}
					$result = $this->load->teacher->get_timetable();
					if($result){
						$data['timetable'] = $result;
					}

					$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
					$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
					$data['time_map'] = $time_map;
					$data['day_map'] = $day_map;

					//echo "sdfsdf"."<br>"."<br>"."<br>"."<br>"."<br>"."<br>".substr(date(l), 0,3);
					//echo "sdfsdf"."<br>"."<br>"."<br>"."<br>"."<br>"."<br>"."sadfad";
					/*foreach ($data['timetable'] as $key => $value) {
						echo $key;
					}*/
					$data['cur_day'] = substr(date('l'),0,3);
					$this->load->model("attendance");
		            $result_set = $this->load->attendance->get_attendance_by_teacher_id($teacher_id);
		            if($result_set){
		                $data['result_set'] = $result_set->fetchAll();
		            }else{
		                $data['result_set'] = FALSE;
		            }
		            $data['teacher_id'] = $teacher_id;


					$this->view_header_and_aside();
					$this->load->view("teacher/teacher_dashboard",$data);
					$this->load->view("templates/footer");
	}
	 }
?>