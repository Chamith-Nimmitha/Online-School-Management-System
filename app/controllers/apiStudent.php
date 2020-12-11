<?php 

	class ApiStudent extends Controller{
		public function __construct() {
			parent::__construct();
		}

		public function search(){
			$post = json_decode(file_get_contents("php://input"));
			$data['id'] = $post->id;
			$data['name'] = $post->name;
			$data['grade'] = $post->grade;
			$data['class'] = $post->class;
			$this->load->view("../../public/assets/api/get_student_info",$data);
		}
	}


 ?>