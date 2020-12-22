<?php 

	class AdmissionModel extends Model{

		// insert data to the database
		public function insert_data($data){
			return $result = $this->con->insert("admission",$data);
		}

		// get admission form data
		public function get_data($admission_id){
			$this->con->where(array("id"=>$admission_id));
			$result_set = $this->con->select('admission');
			if($result_set && $result_set->rowCount() === 1){
				return $result_set->fetch();
			}else{
				return FALSE;
			}
		}

		// get admission list
		public function get_list($start, $count, $id=NULL, $state=NULL){
			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM `admission` ";
			$params = [];
			$flag = 0;
			if($id !== NULL){
				$query .= "WHERE `id` LIKE ?";
				array_push($params, "%{$id}%");
				$flag = 1;
			}

			if($state !== NULL){
				if($flag === 0 ){
					$query .= "WHERE `state` = ?";
				}else{
					$query .= " && `state` = ?";
				}
				array_push($params, $state);
			}
			$query .= " LIMIT $start,$count";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			// print_r($query);
			// exit();
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

	}