<?php 

	class Attendance extends Controller{
		public function __construct(){
			parent::__construct();
		}

		// get classroom list
		public function classroom_list($page=NULL, $per_page=NULL){

			if(!$this->checkPermission->check_permission("attendance","view")){
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
			$data['result_set'] = $this->load->classrooms->get_classroom_list($start,$per_page);
			$data['count'] = $this->load->classrooms->get_count()->fetch()['count'];
			$this->view_header_and_aside();
			$this->load->view("attendance/attendance_classroom_list",$data);
			$this->load->view("templates/footer");
		}

		// view classroom attendance
		public function classroom_view($classroom_id){
			date_default_timezone_set("Asia/Colombo");
			if(!$this->checkPermission->check_permission("attendance","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			$this->load->model("classroom");
			$this->load->model("attendance");
			$result = $this->load->classroom->set_by_id($classroom_id);
			if(!$result){
				echo "classroom not found.";
				exit();
			}
			$data['classroom_data'] = $this->load->classroom->get_data();
			$data['student_list'] = $this->load->attendance->get_classroom_attendance($classroom_id);
			$data["classroom_id"] = $classroom_id;
			$this->view_header_and_aside();
			$this->load->view("attendance/classroom_attendance_view",$data);
			$this->load->view("templates/footer");	
		}

		// get teacher list
		public function teacher_list(){
			$this->load->model("teachers");
			$data['result_set'] = $this->load->teachers->get_teacher_list();
			$this->view_header_and_aside();
			$this->load->view("attendance/attendance_teacher_list",$data);
			$this->load->view("templates/footer");
		}

		// view teacher attendance
		public function teacher_view($cteacher_id){
			$this->view_header_and_aside();
			$this->load->view("attendance/teacher_attendance_view");
			$this->load->view("templates/footer");	
		}
	}

 ?>