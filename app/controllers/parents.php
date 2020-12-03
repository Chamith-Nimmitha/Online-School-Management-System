<?php 

	class Parents extends Controller{

		public function __construct() {
			parent::__construct();
		}

		public function list(){
			$con = new Database();
			$result_set = $con->select("parent");
			if($result_set){
				$result_set = $result_set->fetchAll();
			}
			$data['result_set'] = $result_set;
			$this->view_header_and_aside();
			$this->load->view("parent/parent_list",$data);
			$this->load->view("templates/footer");
		}

		public function student_list(){
			$con = new Database();
			$result = $con->select("student",array("parent_id"=>$_SESSION['user_id']));
			if($result){
				$data['students'] = $result->fetchAll();
			}else{
				$data['students'] = [];
			}
			$this->view_header_and_aside();
			$this->load->view("parent/parent_student_list",$data);
			$this->load->view("templates/footer");
		}
	}
 ?>