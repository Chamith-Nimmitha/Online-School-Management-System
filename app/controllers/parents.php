<?php 

	class Parents extends Controller{

		public function __construct() {
			parent::__construct();
		}

		// search and view parent list
		public function list($page=NULL,$per_page=NULL,$msg=""){
			if(!$this->checkPermission->check_permission("parent_list","view")){
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
			$result_set = $this->load->parents->search($start, $per_page,$parent_id,$parent_name,$occupation);
            $data['count'] = $this->load->parents->get_count()->fetch()['count'];
			$data['result_set'] = $result_set;
			$data['delete_msg'] = $msg;
			$this->view_header_and_aside();
			$this->load->view("parent/parent_list",$data);
			$this->load->view("templates/footer");
		}

		public function student_list($parent_id=NULL,$msg=""){
			if(!$this->checkPermission->check_permission("student","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			
			if($parent_id == NULL){
				$parent_id = $_SESSION['user_id'];
			}

			$this->load->model("parent");
			$result = $this->load->parent->set_by_id($parent_id);
			$result = $this->load->parent->get_student_list();
			if($result){
				$data['students'] = $result->fetchAll();
			}else{
				$data['students'] = [];
			}
			$this->view_header_and_aside();
			$this->load->view("parent/parent_student_list",$data);
			$this->load->view("templates/footer");
		}

		// delete a parent
		public function delete($parent_id){
			if(!$this->checkPermission->check_permission("parent","delete")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("parents");
			$result = $this->load->parents->delete_parent($parent_id);
			if($result){
				$this->list(NULL,NULL,"Parent {$parent_id} deleted.");
			}else{
				$this->list(NULL,NULL,"Parent Delete Failed");
			}
		}
	}
 ?>