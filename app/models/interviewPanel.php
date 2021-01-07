<?php 

	class InterviewPanelModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		public function get_interview_panels($where=[]){
			if(count($where) == 0){
				return $this->con->select("interview_panel");
			}else{
				return $this->con->select("interview_panel", $where);
			}
		}
	}
 ?>