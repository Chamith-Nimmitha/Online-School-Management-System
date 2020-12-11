<?php 

	class Parents extends Controller{

		public function __construct() {
			parent::__construct();
		}

		// search and view parent list
		public function list(){
			$parent_id = NULL;
			$parent_name = NULL;
			$occupation = NULL;
			if(isset($_POST['search'])){
				$parent_id = addslashes(trim($_POST['parent-id']));
				$parent_name = $parent_id;
				$occupation = addslashes(trim($_POST['occupation']));
				if(empty($parent_id)){
					$parent_id = NULL;
				}
				if(empty($parent_name)){
					$parent_name = NULL;
				}
				if(empty($occupation)){
					$occupation = NULL;
				}
			}

			$this->load->model("parents");
			$result_set = $this->load->parents->search($parent_id,$parent_name,$occupation);
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