<?php 

	class Attendance extends Controller{
		public function __construct(){
			parent::__construct();
		}

		// get classroom list
		public function classroom_list(){
			$this->load->model("classrooms");
			$data['result_set'] = $this->load->classrooms->get_classroom_list();
			$this->view_header_and_aside();
			$this->load->view("attendance/attendance_classroom_list",$data);
			$this->load->view("templates/footer");
		}

		// view classroom attendance
		public function classroom_view($classroom_id){
			$this->view_header_and_aside();
			$this->load->view("attendance/classroom_attendance_view");
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