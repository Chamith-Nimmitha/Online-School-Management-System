<?php 

	class InterviewPanel extends Controller{
		public function __construct() {
			parent::__construct();
		}

		// view list of interview panels
		public function list(){
			$con = new Database();
			$con->get(array("id","name","grade"));
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

		public function view_panel($panel_id){
			$con = new Database();
			$error = "";
			// when update the data
			if(isset($_POST['update'])){
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

			$this->view_header_and_aside();
			$this->load->view("interview/interview_panel_view",$data);
			$this->load->view("templates/footer");	
		}
	}
 ?>