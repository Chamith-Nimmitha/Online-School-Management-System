<?php
	class Classroom extends Controller{
		public function __construct(){
			parent::__construct();
		}

		// create new classroom
		public function registration(){
			if(!$this->checkPermission->check_permission("classroom","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("teachers");
			$this->load->model("classroom");
			$this->load->model("classrooms");

			// when submit the form
			if(isset($_POST['submit'])){
				$section = $_POST['section'];
				$grade = $_POST['grade'];
				$class = addslashes(trim($_POST['class']));
				$class_teacher_id = $_POST['class_teacher'];
				$description = addslashes(trim($_POST['description']));

				$details['section_id'] = $grade;
				$details['class'] = $class;
				$details['class_teacher_id'] = $class_teacher_id;
				$details['description'] = $description;
				$classroom_obj = $this->load->classroom->register($details);
				if($classroom_obj){
					$data['info'] = "Classroom registration successful";
				}else{
					$data["error"] = "Classroom registration failed.";
				}
			}

			$teachers = $this->load->teachers->get_not_class_teacher_list();
			if(!$teachers){
				echo "Query failed.";
				exit();
			}
			$categories = $this->load->classrooms->get_categories();
			if(!$categories){
				echo "Query Failed.";
				exit();
			}
			$data['teachers'] = $teachers;
			$data['categories'] = $categories;
			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_registration",$data);
			$this->load->view("templates/footer");
		}

		// delete a classroom
		public function delete($id){
			$this->load->model("classroom");
			$result = $this->load->classroom->delete_classroom($id);
			$info = "";
			$error = "";
			if($result){
				$info = "Deletion successful";
			}else{
				$error = "Deletion failed.";
			}
			$this->classroom_list(NULL,NULL,$info,$error);
		}
		// view classroom student list. this function can use any user role
		public function student_list($classroom_id=""){
			if(!$this->checkPermission->check_permission("classroom","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$role = $_SESSION['role'];

			
			if($role === "teacher"){
				$this->load->model("classroom");
				$this->load->model("teacher");
				$result = $this->load->teacher->set_by_id($_SESSION['user_id']);
				if($result){
					$classroom_id = $this->load->teacher->get_classroom_id();

					if($classroom_id){
						$result= $this->load->classroom->set_by_id($classroom_id);
						if(!$result){
							$data["student_list"]= [];
							$data["classroom_info"] = [];
						}else{
							$data["student_list"] = $this->load->classroom->get_students_data();
							$data["classroom_info"] = $this->load->classroom->get_data();
						}
					}else{
						$data["student_list"]= [];
						$data["classroom_info"] = [];
					}
				}

				$this->view_header_and_aside();
				$this->load->view("classroom/classroom_student_view",$data);
				$this->load->view("templates/footer");
			}else{
				// only admin can remove students
				if(!empty($classroom_id)){
					if(isset($_POST['submit'])){
						$con = new Database();
						$update_errors = array();
						foreach ($_POST as $key => $value) {
							if( stripos($key, "student-") === 0 ){
								$query = "UPDATE `student` SET `classroom_id`=NULL WHERE `id`=".$value;
								$result = $con->pure_query($query);
								if(!$result || $result->rowCount()!= 1){
									array_push($update_errors, "Student ".$value." removed failed.");
								}
							}
						}
						if(empty($update_errors)){
							$info = "Removed successful.";
						}
					}
					$this->load->model("classroom");
					$this->load->classroom->set_by_id($classroom_id);
					$data["student_list"] = $this->load->classroom->get_students_data();
					$data["classroom_info"] = $this->load->classroom->get_data();
				}else{
					$data["student_list"]= [];
					$data["classroom_info"] = [];
				}

				$this->view_header_and_aside();
				$this->load->view("classroom/classroom_student",$data);
				$this->load->view("templates/footer");
			}
		}

		// view classroom list for admin
		public function classroom_list($page=NULL, $per_page=NULL,$info="",$error=""){
			if(!$this->checkPermission->check_permission("classroom_list","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
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

			$this->load->model("classrooms");
			$this->load->model("classroom");
			if(isset($_SESSION['classroom_id']) && !empty($_SESSION['classroom_id'])){
			 	$result = $this->load->classroom->set_by_id($_SESSION['classroom_id']);
			 	if($result){
				 	$grade = $this->load->classroom->get_grade();
			 	}
			}else{
				if(isset($_POST['grade']) && $_POST['grade'] != 'all'){
					$grade = $_POST['grade'];
				}else{
					$grade = NULL;
				}
			}

			if(!isset($_POST['classroom-id']) || empty($_POST['classroom-id'])){
                $data['classroom_id'] = "";
                if(isset($_POST['grade']) && $_POST['grade'] != 'all'){
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,null,$grade,$_POST['class']);
                        $data['grade'] = $grade;
                        $data['class'] = $_POST['class'];
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,null,$grade);
                        $data['grade'] = $grade;
                    }
                }else{
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,null,null,$_POST['class']);
                        $data['class'] = $_POST['class'];
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,null,$grade);
                    }
                }
            }else{
                $data['classroom_id'] = $_POST['classroom-id'];
                if(isset($_POST['grade']) && $_POST['grade'] != 'all'){
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,$_POST['classroom-id'],$grade,$_POST['class']);
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,$_POST['classroom-id'],$grade);
                    }
                }else{
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,$_POST['classroom-id'],null,$_POST['class']);
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list($start,$per_page,$_POST['classroom-id']);
                    }
                }
            }

            unset($_POST);
			$data['result_set'] = $result_set;
			$data['count'] = $this->load->classrooms->get_count()->fetch()['count'];
			$data['info'] = $info;
			$data['error'] = $error;
			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_list",$data);
			$this->load->view("templates/footer");
		}

		// add new student to classroom. For only admin
		public function add_student($classroom_id=""){
			if(!$this->checkPermission->check_permission("classroom","update") && !$this->checkPermission->check_permission("student","update")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$role = $_SESSION['role'];
			$con = new Database();
			if(empty($classroom_id)){
				$this->load->model("student");
				$result = $this->load->student->set_by_id($_SESSION['user_id']);
				if($result){
					$classroom_id = $this->load->student->get_classroom_id();
				}
			}
			if(empty($classroom_id)){
				echo "classroom not found";
				exit();
			}

			// only admin can add students
			if(isset($_POST['submit'])){
				$update_errors = array();
				foreach ($_POST as $key => $value) {
					if( stripos($key, "student-") === 0 ){
						$result = $con->update("student", array("classroom_id"=>$classroom_id), array("id"=> $value));
						if(!$result || $result->rowCount()!= 1){
							array_push($update_errors, "Student ".$value." assign failed.");
						}
					}
				}
				if(empty($update_errors)){
					$info = "Removed successful.";
				}
			}
			$this->load->model("classroom");
			$this->load->classroom->set_by_id($classroom_id);
			$data["classroom_info"] = $this->load->classroom->get_data();

			$query = "SELECT `id`,`name_with_initials`,`email`,`contact_number`,`classroom_id` FROM `student` WHERE `classroom_id` IS NULL && `grade`=".$data['classroom_info']['grade']." LIMIT 10" ;
			$result = $con->pure_query($query);
			if(!$result){
				echo "query failed";
			}
			$data['student_list'] = $result->fetchAll();
			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_assign_student",$data);
			$this->load->view("templates/footer");
		}

		// get update classroom timetable
		public function timetable($classroom_id){
			if(!$this->checkPermission->check_permission("classroom","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
			$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];

			$con = new Database();

			// load classroom model
			$this->load->model("classroom");
			$found_classroom = $this->load->classroom->set_by_id($classroom_id);
			if(!$found_classroom){
				echo "classroom not found";
				exit();
			}

			// when update classroom timetable
			if(isset($_POST['timetable_submit'])){
				if(!$this->checkPermission->check_permission("classroom","update")){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}

				$found_timetable = $this->load->classroom->get_timetabel_object();
				$all_data = [];
				foreach ($_POST as $key => $value) {
					$tmp = explode("-", $key);
					if(count($tmp) == 2){
						$td = [];
						$td['day'] = $tmp[0];
						$td['period'] = $tmp[1];
						$td['task'] = $value;
						array_push($all_data, $td);
					}
				}

				try {
					if($found_timetable){
						$result = $found_timetable->update_timetable($all_data);
						if(!$result){
							throw new PDOException();
						}
					}else{
						$result = $found_timetable->create();
						if(!$result){
							throw new PDOException();
						}
						$result = $found_timetable->update_timetable($all_data);
						if(!$result){
							throw new PDOException();
						}
					}

					$info = "Update successful..";
				} catch (Exception $e) {
					$error = "Update Failed.";
				}
			}
			
			// get classroom timetable
			$this->load->model("classroom");
			$this->load->classroom->set_by_id($classroom_id);
			$timetable_obj = $this->load->classroom->get_timetabel_object();
			if($timetable_obj){
				$timetable_data = $timetable_obj->get_timetable();
			}else{
				$timetable_data = FALSE;
			}
			// get classroom subjects
			$subjects["general"] = $this->load->classroom->get_general_subjects();
			$subjects["optional"] = $this->load->classroom->get_optional_subjects();
			$subjects["other"] = $this->load->classroom->get_other_subjects();
			$this->load->model("subjects");
			$result = $this->load->subjects->get_teachers($subjects['general']);
			if($result){
				$data['subject_teachers'] = $result;
			}

			$data['subjects'] = $subjects;
			$data['classroom_id'] = $classroom_id;
			$data['grade'] = $this->load->classroom->get_grade();
			$data['class'] = $this->load->classroom->get_class();
			$data['classroom_id'] = $classroom_id;
			$data['timetable_data'] = $timetable_data;
			if(isset($_SESSION["info_teacher_update"])){
				$data['info'] = $_SESSION["info_teacher_update"];
				unset($_SESSION["info_teacher_update"]);
			}
			if(isset($_SESSION["error_teacher_update"])){
				$data['error'] = $_SESSION["error_teacher_update"];
				unset($_SESSION["error_teacher_update"]);
			}

			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_timetable_create",$data);
			$this->load->view("templates/footer");
		}

		// classroom timetable view
		public function timetable_view($classroom_id){
			if(!$this->checkPermission->check_permission("classroom","view")){
                $this->view_header_and_aside();
                $this->load->view("common/error");
                $this->load->view("templates/footer");
                return;
            }
            $time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
            $day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
            $timetable_data = [];
            
            $this->load->model("classroom");
            $result = $this->load->classroom->set_by_id($classroom_id);
            if(!$result){
            	$timetable_data = FALSE;
            }
            $timetable = $this->load->classroom->get_converted_timetable();
            $timetable_data =$timetable;

            $data = [
                'timetable_data'=>$timetable_data,
                'time_map'=>$time_map,
                "day_map"=>$day_map,
                "classroom_id" =>$classroom_id,
                "grade" =>$this->load->classroom->get_grade(),
                "class" =>$this->load->classroom->get_class(),
            ];
            $this->view_header_and_aside();
            $this->load->view("classroom/classroom_timetable_view",$data);
            $this->load->view("templates/footer");
		}
		// update classroom
		public function update($classroom_id){
			if(!$this->checkPermission->check_permission("classroom","update")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("classroom");
			$this->load->model("classrooms");


			//when user sumbit the updates
			if(isset($_POST['update'])){
				$result = $this->load->classroom->set_by_id($classroom_id);
				if(!$result){
					echo "classroom not found.";
					exit();
				}
				$section = $_POST['section'];
				$grade = $_POST['grade'];
				$class = addslashes(trim($_POST['class']));
				$class_teacher_id = $_POST['class_teacher'];
				$description = addslashes(trim($_POST['description']));

				$details['section_id'] = $grade;
				$details['class'] = $class;
				if(!empty($class_teacher_id)){
					$details['class_teacher_id'] = $class_teacher_id;
				}else{
					$details['class_teacher_id'] = NULL;
				}
				$details['description'] = $description;
				$result = $this->load->classroom->update_classroom($details);
				if($result){
					$data['info'] = "Classroom Update successful";
				}else{
					$data["error"] = "Classroom Update failed.";
				}
			}

			// set classroom object
			$result = $this->load->classroom->set_by_id($classroom_id);
			if(!$result){
				echo "classroom not found.";
				exit();
			}
			// get all distict section categories
			$categories = $this->load->classrooms->get_categories();
			if(!$categories){
				echo "Query Failed.";
				exit();
			}
			$data['categories'] = $categories;
			
			//get classroom information
			$data['result'] = $this->load->classroom->get_data();

			// get section information
			$section_data = $this->load->classroom->get_section_data();

			// get sections list
			$result = $this->load->classrooms->get_section_list_by_category($section_data['category']);
			if(!$result){
				echo "sections get failed.";
				exit();
			}
			$data['sections'] = $result;

			//get teacher list
			$this->load->model("teachers");
			$teachers = $this->load->teachers->get_not_class_teacher_list();
			$class_teacher_data = $this->load->classroom->get_class_teacher_data();
			if($class_teacher_data){
				array_unshift($teachers,$class_teacher_data);
			}
			if(!$teachers){
				echo "Query failed.";
				exit();
			}
			$data['teachers'] = $teachers;

			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_registration",$data);
			$this->load->view("templates/footer");
		}

		// assign, update and assign classroom subjects
		public function subjects($classroom_id){
			if(!$this->checkPermission->check_permission("classroom","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$error = "";
			$msg = "";
			$this->load->model("classroom");
			$result = $this->load->classroom->set_by_id($classroom_id);
			if(!$result){
				echo "Classroom not found.";
				exit();
			}

			// when update the classroom subjects
			if(isset($_POST['submit'])){
				$subjects = ["General"=>[],"Optional"=>[],"Other"=>[]];
				foreach ($_POST as $key => $value) {
					if($value=="None"){
						continue;
					}
					if( strpos($key, "subject") !== FALSE){
						$exp = explode("-", $key);
						$periods =  $_POST["periods-".$exp[1]."-".$exp[2]];
						if(empty($periods)){
							$periods = 0;
						}
						if($exp[1] == "general"){
							array_push($subjects['General'], ["id"=>$value,"periods"=>$periods]);
						}else if($exp[1] == "optional"){
							array_push($subjects['Optional'], ["category"=>$value,"periods"=>$periods]);
						}else if($exp[1] == "other"){
							array_push($subjects['Other'], ["id"=>$value,"periods"=>$periods]);
						}
					}
				}
				$result = $this->load->classroom->update_subjects($subjects);
				if(!$result){
					$error = "Update Failed.";
				}else{
					$msg = "Update Success.";
				}
			}
			$data['msg'] = $msg;
			$data['error'] = $error;
			$data["classroom_info"] = $this->load->classroom->get_data();
			$grade = $data['classroom_info']['grade'];
			$this->load->model("subjects");
			$data['classroom_general_subjects'] = $this->load->classroom->get_general_subjects();
			$data['classroom_optional_subjects'] = $this->load->classroom->get_optional_subjects();
			$data['classroom_other_subjects'] = $this->load->classroom->get_other_subjects();
			$data['general_subjects'] = $this->load->subjects->get_general_subjects($grade)->fetchAll();
			$data['optional_subjects'] = $this->load->subjects->get_optional_subjects_distinct_category($grade)->fetchAll();

			$data['other_subjects'] = $this->load->subjects->get_other_subjects($grade)->fetchAll();
			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_subjects",$data);
			$this->load->view("templates/footer");
		}


		public function delete_notice($notice_id){
			$this->load->model("classroom");
			$result = $this->load->classroom->delete_notice($notice_id);
			if($result){
				$_SESSION['del_msg'] = "Notice {$notice_id} deleted.";
			}else{
				$_SESSION['del_msg'] = "Deletion failed.";
			}
			header("Location: ".set_url("dashboard") );
		}

		// view and provide links for all classroom related staff
		public function classroom_view($classroom_id=NULL){

			$this->load->model("classroom");

			// set classroom object

			$error = "";
			if($classroom_id == NULL){
				if($_SESSION['role'] == 'student'){
					$this->load->model("student");
					$result = $this->load->student->set_by_id($_SESSION['user_id']);
					if(!$result){
						$error = "Student Not Found.";
					}else{
						$classroom_id = $this->load->student->get_classroom_id();
						if(!$classroom_id){
							$error = "Classroom Not Found.";
						}
					}
				}else if($_SESSION['role'] == "teacher"){
					$this->load->model("teacher");
					$result = $this->load->teacher->set_by_id($_SESSION['user_id']);
					if(!$result){
						$error = "Teacher Not Found.";
					}else{
						$classroom_id = $this->load->teacher->get_classroom_id();
						if(!$classroom_id){
							$error = "Classroom Not Found.";
						}
					}
				}
			}
			if(!empty($classroom_id)){
				$result = $this->load->classroom->set_by_id($classroom_id);
				if(!$result){
					$error = "classroom not found.";
				}

				$data['result'] = $this->load->classroom->get_data();
				//get classroom information
				if($data['result'] && !empty($data['result']['class_teacher_id'])){
					$t_data = $this->load->classroom->get_class_teacher_data();
					if($t_data){
						$data['result']['class_teacher_name'] =$t_data['name_with_initials'];
					}
				}
			}
			

			$data['error'] = $error;

			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_view",$data);
			$this->load->view("templates/footer");	
		}
	}

?>