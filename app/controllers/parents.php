<?php 

	class Parents extends Controller{
		private $msg;
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
				$this->msg = "Parent {$parent_id} deleted.";
				// $this->list(NULL,NULL,"Parent {$parent_id} deleted.");
			}else{
				$this->msg = "Parent Delete Failed";
				// $this->list(NULL,NULL,"Parent Delete Failed");
			}
			header("Location:".set_url("parent/list"));
		}

		public function parent_dashboard(){
			if(!$this->checkPermission->check_permission("dashboard","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("user");
			$counts = $this->load->user->get_staticstic_count();
			$data['count'] = $counts;

			if(isset($_SESSION['login_msg'])){
				$data['msg'] = $_SESSION['login_msg'];
				unset($_SESSION['login_msg']);
			}
			if(isset($_SESSION['del_msg'])){
				$data['del_msg'] = $_SESSION['del_msg'];
				unset($_SESSION['del_msg']);
			}

			$is_classroom_teacher = 0;
			$show_notice_board = 0;
			$statics_link_show = 0;
			$statics_link_show = 1;


			if($_SESSION['role'] == "parent"){
				$this->load->model("parent");
				$this->load->model("student");
				$result = $this->load->parent->set_by_id($_SESSION['user_id']);
				$result = $this->load->parent->get_student_list();
				if($result){
					$students = $result->fetchAll();
					$classroom_notices = [];
					foreach ($students as $student) {
						$cls = $this->load->student->set_by_id($student['id']);
						$cls = $this->load->student->get_classroom_object();
						if($cls){
							$data['grade'] = $cls->get_grade();
							$data['class'] = $cls->get_class();
							$result = $cls->get_notices();
							if($result  && $result->rowCount() >0){
								array_push($classroom_notices,["notices"=>$result->fetchAll(),"grade"=>$cls->get_grade(),"class"=>$cls->get_class()]);
							}
						}
					}
					$data['classroom_notices'] = $classroom_notices;
				}
				$show_notice_board = 1;
				$statics_link_show = 0;
			}


			$data['is_classroom_teacher'] = $is_classroom_teacher;
			$data['show_notice_board'] = $show_notice_board;
			$data['statics_link_show'] = $statics_link_show;
			$this->view_header_and_aside();
			$this->load->view("parent/parent_dashboard", $data);
			$this->load->view("templates/footer");

		}
	}
 ?>