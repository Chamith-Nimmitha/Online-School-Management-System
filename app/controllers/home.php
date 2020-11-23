<?php 

	class Home extends Controller{

		public function index(){
			$data['title'] = "myApp";
			$data['content'] = "myApp";
			$student = $this->load->model("student");
			$this->load->student->set_by_id(1100017);
			$data['students'] = $this->load->student->get_data();
			$this->load->view("homepage",$data);
		}
	}