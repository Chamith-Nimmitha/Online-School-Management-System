<?php 

	class InterviewPanel extends Controller{
		public function __construct() {
			parent::__construct();
		}

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

		public function delete($panel_id){
			$con = new Database();
			$con->update("interview_panel",['is_deleted'=>1],array("id"=>$panel_id));
			header("Location:". set_url("interviewpanel/list"));	
		}
	}
 ?>