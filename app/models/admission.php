<?php 

	class AdmissionModel extends Model{

		// insert data to the database
		public function insert_data($data){
			return $result = $this->con->insert("admission",$data);
		}

		public function change_admission_state($admission_id,$state){
			return $this->con->update("admission", ["state"=>$state],["id" =>$admission_id]);
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
		public function get_list($start, $count, $id=NULL,$name=NULL,$grade=NULL, $state=[]){
			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM `admission` ";
			$params = [];
			$flag = 0;
			if( !is_numeric($grade) || strlen($grade) >2 ){
				if($id !== NULL){
					$query .= " WHERE (`id` LIKE ?";
					array_push($params, "%{$id}%");
					$flag = 1;
				}

				if($name !== NULL){
					if($flag === 0){
						$query .= " WHERE (`name_with_initials` LIKE ?";
					}else{
						$query .= " || `name_with_initials` LIKE ?";
					}
					array_push($params, "%{$name}%");
					$flag = 1;
				}
				if($flag === 1){
					$query .= ")";
				}
			}else{
				if($grade !== NULL){
					if($flag === 0 ){
						$query .= "WHERE `grade` = ?";
					}else{
						$query .= " && `grade` = ?";
					}
					$flag = 1;
					array_push($params, $grade);
				}
			}


			if(count($state) != 0){
				if($flag === 0 ){
					$query .= "WHERE `state` IN (";
				}else{
					$query .= " && `state` IN (";
				}
				$s="";

				foreach ($state as $value) {
					if(strlen($s) != 0){
						$s .= ",";
					}
					$s .="?";
					array_push($params, $value);
				}
				$s .= ")";
				$query .= $s;
				$flag = 1;
			}
			$query .= " LIMIT $start,$count";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}
		// delete admission
		public function delete_admission($admission_id){
			$this->con->update("admission",array("state"=>"deleted"),array("id"=>$admission_id));
		}
		// get result count
		public function get_count(){
			return $this->con->get_count();
		}

		// check admission parent id
		public function check_parent_id($parent_id){
			return $this->con->select("parent",["id"=>$parent_id]);
		}

	}