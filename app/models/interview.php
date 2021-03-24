<?php 

	class InterviewModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		public function get_interview_data($admission_id){
			return $this->con->select("interview",array("admission_id"=>$admission_id));
		}

		public function set_interview_data($data){
			return $this->con->insert('interview',$data);
		}

		public function update_interview_data($admission_id,$data){
			return $this->con->update('interview',$data,['admission_id'=>$admission_id]);
		}

		public function search($start,$per_page,$admission_id=NULL,$panel_id=NULL,$state=NULL){
			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM `interview`";
			$where_flag = 0;
			$params = [];
			if($admission_id != NULL){
				$query .= " WHERE `admission_id` LIKE ? ";
				array_push($params, "%{$admission_id}%");
				$where_flag = 1;
			}

			if($panel_id != NULL){
				if($where_flag ===1){
					$query .= " && `interview_panel_id` LIKE ? ";
				}else{
					$query .= " WHERE `interview_panel_id` LIKE ? ";
				}
				array_push($params, "%{$panel_id}%");
				$where_flag = 1;
			}

			if($state != NULL && $state != 'all'){
				if($where_flag ===1){
					$query .= " && `state`= ? ";
				}else{
					$query .= " WHERE `state`=? ";
				}
				array_push($params, $state);
				$where_flag = 1;
			}
			$query .= " ORDER BY FIELD(state,'notInterviewed') DESC, `id` ASC  ";
			$query .=  "LIMIT $start,$per_page";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get result count
		public function get_count(){
			return $this->con->get_count();
		}

		// change interview state
		public function change_interview_state($admission_id,$state){
			return $this->con->update("interview",["state"=>$state],["admission_id"=>$admission_id]);
		}
	}

 ?>