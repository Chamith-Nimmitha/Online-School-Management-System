<?php 

	class InterviewPanel extends Controller{
		public function __construct() {
			parent::__construct();
		}

		// view list of interview panels
		public function list(){
			if(!$this->checkPermission->check_permission("interview_panel","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			$con->get(array("id","name","grade"));
			if(isset($_POST['interview-panel-grade']) && $_POST['interview-panel-grade'] !== 'all'){
				$con->where(['grade'=>$_POST['interview-panel-grade']]);
			}
			$result_set = $con->select("interview_panel");
			if($result_set){
				$data['result_set'] = $result_set->fetchAll();
			}else{
				echo "query error.";
				exit();
			}
			$this->view_header_and_aside();
			$this->load->view("interview/interview_panels_all",$data);
			$this->load->view("templates/footer");
		}

		// delete interview panel
		public function delete($panel_id){
			if(!$this->checkPermission->check_permission("interview_panel","delete")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			$con->update("interview_panel",['is_deleted'=>1],array("id"=>$panel_id));
			header("Location:". set_url("interviewpanel/list"));	
		}

		// view interview panel details
		public function view_panel($panel_id=NULL){
			if(!$this->checkPermission->check_permission("interview_panel","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$con = new Database();
			$error = "";
			$next_id = $con->get_next_auto_increment("interview_panel");
			$next_id = $next_id->fetch()['AUTO_INCREMENT'];
			
			$this->load->model("interviewPanel");
			// create new interview panel
			if(isset($_POST['create'])){
				if(!$this->checkPermission->check_permission("interview_panel","create")){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}
				$this->load->model("interviewPanel");
				$data['name'] = $_POST['panel-name'];
				$data['grade'] = $_POST['grade'];
				$teachers = [];
				foreach ($_POST as $key => $value) {
					if(strpos($key,"teacher") === 0 && $value !== ""){
						array_push($teachers, $value);
					}
				}
				$result = $this->load->interviewPanel->register($data,$teachers);
				if($result != FALSE){
					header("Location:".set_url("interviewpanel/timetable/").$result);
				}else{
					$error = "Interview Panel Creation Failed.";
				}
			}
			// when update the data
			else if(isset($_POST['update']) && !empty($panel_id)){
				if(!$this->checkPermission->check_permission("interview_panel","update")){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}
				$data['name'] = $_POST['panel-name'];
				$data['grade'] = $_POST['grade'];
				
				$teachers = [];
				foreach ($_POST as $key => $value) {
					if(strpos($key,"teacher") === 0 && $value !== ""){
						array_push($teachers, $value);
					}
				}

				$result = $this->load->interviewPanel->update_panel($panel_id,$data,$teachers);
				if($result===TRUE){
					header("Location:".set_url("interviewpanel/timetable/").$panel_id);
				}else{
					$error = "Interview Panel Update Failed.";
				}
			}

			$interview_panel = [];
			$interview_teachers = [];
			if($panel_id){
				$result_set = $con->select('interview_panel',['id'=>$panel_id]);
				if($result_set){
					if($panel_id !== NULL){
						$interview_panel = $result_set->fetch();
						$interview_teachers = $this->load->interviewPanel->get_interview_panel_teachers($panel_id);
						$interview_teachers = $interview_teachers->fetchAll();
					}
				}else{
					$error = "interview panel not found.";
				}
			}
			unset($_POST);
			$data['interview_panel'] = $interview_panel;
			$data['interview_teachers'] = $interview_teachers;
			$data['error'] = $error;
			$data['next_id'] = $next_id;

			$this->view_header_and_aside();
			$this->load->view("interview/interview_panel_create",$data);
			$this->load->view("templates/footer");	
		}

		// interviewpanel timetable
		public function timetable($panel_id){
			if(!$this->checkPermission->check_permission("interview_panel","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}

			$error = array();
			$info = array();
			$data = [];

			$this->load->model("timetable");
			$result = $this->load->timetable->set_by_user_id($panel_id,"interview");
			if(!$result){
				$error = "timetable Not found.";
			}else{
				$this->load->model("interviewPanel");
				$valid = $this->load->interviewPanel->get_interview_panels(array("id"=>$panel_id));
				if(!$valid || $valid->rowCount() !== 1){
					$error = "Interview Panel Not Found.";
				}
			}


			// when submit timetble
			if(isset($_POST['submit'])){
				if(!$this->checkPermission->check_permission("interview_panel","update")){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}
				$tt = [];
				foreach ($_POST as $key => $value) {
					if($key != "submit"){
						$exp = explode("-", $key);
						array_push($tt, ["day"=>$exp[0],"period"=>$exp[1],"task"=>$value]);
					}
				}
				// print_r($tt);
				// exit();
				$result = $this->load->timetable->update_timetable($tt);
				if(!$result){
					$error = "Timetable Update Failed.";
				}else{
					$info ="Timetable update successful.";
				}
			}
			if(empty($error)){
				$timetable = $this->load->timetable->get_timetable();
				if(!$timetable){
					$error = "Timetable Not found.";
				}
				$data['mon'] = $timetable['mon'];
				$data['tue'] = $timetable['tue'];
				$data['wed'] = $timetable['wed'];
				$data['thu'] = $timetable['thu'];
				$data['fri'] = $timetable['fri'];
				$data['errors'] = $error;
				$data['info'] = $info;
				$data['panel_id'] = $panel_id;
			}
			$data["error"] = $error;
			$data["info"] = $info;
			$this->view_header_and_aside();
			$this->load->view("interview/interviewpanel_timetable",$data);
			$this->load->view("templates/footer");
		}
	}
 ?>