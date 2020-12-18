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

		// view classroom student list. this function can use any user role
		public function student_list($classroom_id=""){
			if(!$this->checkPermission->check_permission("classroom","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$role = $_SESSION['role'];
			if(empty($classroom_id)){
				$this->load->model("student");
				$result = $this->load->student->set_by_id($_SESSION['user_id']);
				if($result){
					$classroom_id = $this->load->student->get_classroom_id();
				}
			}

			if($role !== "admin"){
				$this->load->model("classroom");
				$result= $this->load->classroom->set_by_id($classroom_id);
				if(!$result){
					$data["student_list"]= [];
					$data["classroom_info"] = [];
				}else{
					$data["student_list"] = $this->load->classroom->get_studets_data();
					$data["classroom_info"] = $this->load->classroom->get_data();
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
					$data["student_list"] = $this->load->classroom->get_studets_data();
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
		public function classroom_list(){
			if(!$this->checkPermission->check_permission("classroom_list","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("classrooms");

			if(!isset($_POST['classroom-id']) || empty($_POST['classroom-id'])){
                $data['classroom_id'] = "";
                if(isset($_POST['grade']) && $_POST['grade'] != 'all'){
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list(null,$_POST['grade'],$_POST['class']);
                        $data['grade'] = $_POST['grade'];
                        $data['class'] = $_POST['class'];
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list(null,$_POST['grade']);
                        $data['grade'] = $_POST['grade'];
                    }
                }else{
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list(null,null,$_POST['class']);
                        $data['class'] = $_POST['class'];
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list();
                    }
                }
            }else{
                $data['classroom_id'] = $_POST['classroom-id'];
                if(isset($_POST['grade']) && $_POST['grade'] != 'all'){
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list($_POST['classroom-id'],$_POST['grade'],$_POST['class']);
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list($_POST['classroom-id'],$_POST['grade']);
                    }
                }else{
                    if(isset($_POST['class']) && $_POST['class'] != 'all'){
                        $result_set = $this->load->classrooms->get_classroom_list($_POST['classroom-id'],null,$_POST['class']);
                    }else{
                        $result_set = $this->load->classrooms->get_classroom_list($_POST['classroom-id']);
                    }
                }
            }

            unset($_POST);
			$data['result_set'] = $result_set;
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

		// get classroom timetable
		public function timetable($classroom_id){
			if(!$this->checkPermission->check_permission("classroom","view")){
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
			if(isset($_POST['submit'])){
				if(!$this->checkPermission->check_permission("classroom","update")){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}
				try {
					$con->db->beginTransaction();
					$where_data['type'] = "classroom";
					$where_data['user_id'] = $classroom_id;

					$found_timetable = $this->load->classroom->get_timetabel_object();
					if($found_timetable){
						$timetable_id = $found_timetable->get_id();;
						foreach ($_POST as $key => $value) {
							$tmp = explode("-", $key);
							if(count($tmp) == 2){
								$data = [];
								$data['day'] =  $tmp[0];
								$data['period'] =  $tmp[1];
								$data['timetable_id'] = $timetable_id;
								$result = $con->update("normal_day",array("task"=>$value),$data);
								if(!$result){
									throw new PDOException("Timetable create failed.",1);
								}
							}
						}
					}else{
						$result = $con->insert("normal_timetable",$where_data);
						if(!$result){
							throw new PDOException("Timetable create failed.",1);
						}
						$con->get(array("id"));
						$result = $con->select("normal_timetable",$where_data);

						if(!$result && $result->rowCount() != 1){
							throw new PDOException("Timetable create failed.",1);
						}
						$timetable_id = $result->fetch()['id'];
						foreach ($_POST as $key => $value) {
							$tmp = explode("-", $key);
							if(count($tmp) == 2){
								$data = [];
								$data['day'] =  $tmp[0];
								$data['period'] =  $tmp[1];
								$data['task'] = $value;
								$data['timetable_id'] = $timetable_id;
								$result = $con->insert("normal_day",$data);
								if(!$result){
									throw new PDOException("Timetable create failed.",1);
								}
							}
						}
					}
					$info = "Update successful..";
					$con->db->commit();
				} catch (Exception $e) {
					echo "catch";
					exit();
					$error = $e->getMessage();
					$con->db->rollback();
				}
			}
			
			//get all subjects related to the section
			$grade = $this->load->classroom->get_grade();
			$con->get(array("code","name"));
			$subjects = $con->select("subject",array("grade"=>$grade));
			if($subjects && $subjects->rowCount() !==0){
				$subjects = $subjects->fetchAll();
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
			$data['subjects'] = $subjects;
			$data['classroom_id'] = $classroom_id;
			$data['timetable_data'] = $timetable_data;

			$this->view_header_and_aside();
			$this->load->view("classroom/classroom_timetable_create",$data);
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
				$section = $_POST['section'];
				$grade = $_POST['grade'];
				$class = addslashes(trim($_POST['class']));
				$class_teacher_id = $_POST['class_teacher'];
				$description = addslashes(trim($_POST['description']));

				$details['section_id'] = $grade;
				$details['class'] = $class;
				if(!empty($class_teacher_id)){
					$details['class_teacher_id'] = $class_teacher_id;
				}
				$details['description'] = $description;
				$result = $this->load->classroom->update_classroom($classroom_id,$details);
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
	}

?>