<?php 

	class InterviewModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		public function search($admission_id=NULL,$panel_id=NULL,$state=NULL){
			$query = "SELECT * FROM `interview`";
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

			if($state != 'all'){
				if($where_flag ===1){
					$query .= " && `state`= ? ";
				}else{
					$query .= " WHERE `state`=? ";
				}
				array_push($params, $state);
				$where_flag = 1;
			}
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}
	}

 ?>