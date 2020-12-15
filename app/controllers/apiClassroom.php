<?php 

	class apiClassroom extends Controller{
		public function __construct() {
			parent::__construct();
		}

		public function get_grades($category){
			$data['category'] = $category;
			$this->load->view("../../public/assets/api/classrooms",$data);
		}
	}

 ?>