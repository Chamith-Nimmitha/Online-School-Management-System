<?php
	class Classroom extends Controller{
		public function __construct(){
			parent::__construct();
		}

		// view classroom student list. this function can use any user role
		public function student_list($classroom_id=""){
			$role = $_SESSION['role'];
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

			if($role !== "admin"){
				$this->load->model("classroom");
				$this->load->classroom->set_by_id($classroom_id);
				$data["student_list"] = $this->load->classroom->get_studets_data();
				$data["classroom_info"] = $this->load->classroom->get_data();

				$this->view_header_and_aside();
				$this->load->view("classroom/classroom_student_view",$data);
				$this->load->view("templates/footer");
			}else{
				// only admin can remove students
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

				$this->view_header_and_aside();
				$this->load->view("classroom/classroom_student",$data);
				$this->load->view("templates/footer");
			}
		}

		// view classroom list for admin
		public function classroom_list(){
			$this->load->model("classrooms");
			$data['result_set'] = $this->load->classrooms->get_classroom_list();
			$this->view_header_and_aside();
			$this->load->view("classroom/classroomsnew-view",$data);
			$this->load->view("templates/footer");
		}

		// add new student to classroom. For only admin
		public function add_student($classroom_id=""){
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

		public function timetable($classroom_id){
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
	}

?>