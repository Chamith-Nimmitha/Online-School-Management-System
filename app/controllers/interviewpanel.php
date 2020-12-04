<?php 

	class InterviewPanel extends Controller{
		public function __construct() {
			parent::__construct();
		}

		// view list of interview panels
		public function list(){
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
			$con = new Database();
			$con->update("interview_panel",['is_deleted'=>1],array("id"=>$panel_id));
			header("Location:". set_url("interviewpanel/list"));	
		}

		// view interview panel details
		public function view_panel($panel_id=""){
			$con = new Database();
			$error = "";
			$next_id = $con->get_next_auto_increment("interview_panel");
			$next_id = $next_id->fetch()['AUTO_INCREMENT'];
			
			// create new interview panel
			if(isset($_POST['create'])){
				try {
					$con->db->beginTransaction();
					$data['name'] = $_POST['panel-name'];
					$data['grade'] = $_POST['grade'];
					$result = $con->insert("interview_panel",$data);
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException("Panel creation failed.", 1);
					}
					$con->get(['id']);
					$result = $con->select("interview_panel",$data);
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException("Panel creation failed.", 1);
					}
					$panel_id = $result->fetch()['id'];

					$this->load->model("timetable");
					$result = $this->load->timetable->create($panel_id,"interview");
					if(!$result){
						throw new PDOException("Timetable creation failed.", 1);	
					}

					foreach ($_POST as $key => $value) {
						if(strpos($key,"teacher") === 0 && $value !== ""){
							$result = $con->update("teacher",array("interview_panel_id"=>$next_id),array("id"=>$value));
							if(!$result){
								throw new PDOException("Teacher update failed.", 1);
							}
						}
					}
					$con->db->commit();
					header("Location:".set_url("interviewpanel/timetable/").$panel_id);
				} catch (Exception $e) {
					$error = $e->getMessage();
					$con->db->rollBack();
				}
				
			}
			// when update the data
			else if(isset($_POST['update']) && !empty($panel_id)){
				$data['name'] = $_POST['panel-name'];
				$data['grade'] = $_POST['grade'];
				$result = $con->update("interview_panel",$data,array('id'=>$panel_id));
				
				if($result){
					$old_teachers = $con->select("teacher",array("interview_panel_id"=>$panel_id));
					$teachers = array();
					if($old_teachers){
						$old_teachers = $old_teachers->fetchAll();
						foreach ($old_teachers as $t) {
							array_push($teachers, $t['id']);
						}
					}
					try{
						$con->db->beginTransaction();
						foreach ($_POST as $key => $value) {
							if(strpos($key,"teacher") === 0){
								if (($k = array_search($value, $teachers)) !== false) {
								    unset($teachers[$k]);
								}else{
									$result = $con->update("teacher",array("interview_panel_id"=>$panel_id),array("id"=>$value));
									if($result->rowCount()!=1){
										throw new PDOException("Update failed.",1);
									}
								}
							}
						}
						if( count($teachers) > 0){
							foreach ($teachers as $value) {
								$query = "UPDATE `teacher` SET `interview_panel_id`=NUll WHERE `id`=${value}";
								$result = $con->pure_query($query);
								if($result->rowCount()!=1){
									throw new PDOException("Update failed.",1);
								}
							}
						}
						$con->db->commit();
						header("Location:".set_url("interviewpanel/timetable/").$panel_id);
					}catch(Exception $e){
						$error = $e->getMessage();
						$con->db->rollback();
					}
				}
			}

			$con->where(array('id'=>$panel_id));
			$result_set = $con->select('interview_panel');
			if($result_set){
				$interview_panel = $result_set->fetch();
				$con->where(array('interview_panel_id'=>$panel_id));
				$interview_teachers = $con->select('teacher');
				$interview_teachers = $interview_teachers->fetchAll();
			}else{
				echo "interview panel not found.";
				exit();
			}

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
			$con = new Database();
			$errors = array();
			$info = array();
			$this->load->model("timetable");
			$result = $this->load->timetable->set_by_user_id($panel_id,"interview");
			if(!$result){
				echo "timetable Not found.";
				exit();
			}

			$valid = $con->select("interview_panel",array("id"=>$panel_id));
			if(!$valid || $valid->rowCount() !== 1){
				header("Location:".set_url("interviewpanel/registration"));
			}

			// when submit timetble
			if(isset($_POST['submit'])){
				$con->db->beginTransaction();
				try{
					$result = $this->load->timetable->update_timetable();
					if(!$result){
						throw new PDOException("Timetable update failed.", 1);
					}
					array_push($info,"Timetable update successful.");
					$con->db->commit();
				}catch(Exception $e){
					$con->db->rollback();
					array_push($errors,$e->getMessage());
				}
			}

			$timetable = $this->load->timetable->get_timetable();
			if(!$timetable){
				echo "Timetable Not found.";
			}
			$data['mon'] = $timetable['mon'];
			$data['tue'] = $timetable['tue'];
			$data['wed'] = $timetable['wed'];
			$data['thu'] = $timetable['thu'];
			$data['fri'] = $timetable['fri'];
			$data['errors'] = $errors;
			$data['info'] = $info;
			$data['panel_id'] = $panel_id;
			$this->view_header_and_aside();
			$this->load->view("interview/interviewpanel_timetable",$data);
			$this->load->view("templates/footer");
		}

		public function registration(){

		}
	}
 ?>