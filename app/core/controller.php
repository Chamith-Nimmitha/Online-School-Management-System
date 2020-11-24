<?php 

	class Controller extends Load{
		protected $load;
		protected $header_data =[];
		protected $view_header_flag = 0;
		protected $view_aside_flag = 0;
		public function __construct(){
			// create Load object
			$this->load = new Load();
			$this->load->model("home");
			// if user not logged in, then redirect to the login page
			$curPageName = $_SERVER['QUERY_STRING'];
			$alloed_pages = ["homepage","login","student/registration","school/contact","school/about"];
			if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) || !isset($_SESSION['username']) ) {
				$flag = 0;
				echo strlen($curPageName);
				foreach ($alloed_pages as $page) {
					if( empty($curPageName) || strpos($curPageName, $page) !== FALSE ){
						$flag = 1;
						$this->view_header_flag = 1;
						$this->view_aside_flag = 0;
					}
				}
				if($flag !== 1){
			    	header("Location:". set_url("login"));
				}
			}else{
				$this->view_header_flag = 1;
				$this->view_aside_flag = 1;
				foreach ($alloed_pages as $page) {
					if( empty($curPageName) || strpos($curPageName, $page) !== FALSE ){
						$this->view_header_flag = 1;
						$this->view_aside_flag = 0;
					}
				}
			}


			// view header and main navigation bar
			
		}

		protected function view_header_and_aside(){
			if($this->view_header_flag === 1){
				$result = $this->load->home->get_header_data();
				if($result){
					$header_result = $result->fetchAll();
					foreach ($header_result as $data) {
						$this->header_data[$data['name']] = $data['value'];
					}
					$this->load->view("templates/header",["header"=>$this->header_data]);
				}else{
					echo "header data not found.";
				}
			}
			if($this->view_aside_flag === 1){
				if($_SESSION['role'] == "student"){
					$this->load->model('student');
					$this->load->student->set_by_id($_SESSION['user_id']);
					$parent_id = $this->load->student->get_parent_id();
					$this->load->view("templates/aside_student",["parent_id"=>$parent_id]);
				}else if($_SESSION['role'] == "teacher"){
					$this->load->model('teacher');
					$this->load->teacher->set_by_id($_SESSION['user_id']);
					$panel_id = $this->load->teacher->get_interview_panel_id();
					$this->load->view("templates/aside_teacher",["interview_panel_id"=>$panel_id]);
				}else if($_SESSION['role'] == "admin"){
					$this->load->view("templates/aside_admin");
				}else if($_SESSION['role'] == "parent"){
					$this->load->view("templates/aside_parent");
				}
			}
		}
	}