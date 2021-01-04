<?php 

	class subjectsModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		// filter and get subject list
		public function get_subject_list($subject_id=NULL, $subject_name=NULL, $subject_code=NULL, $grade = NULL, $medium=NULL){

			$query = "SELECT * FROM `subject` ";
			$params = [];
			$flag = 0;

			if($subject_id != NULL || $subject_name != NULL || $subject_code != NULL){
				$query .= "WHERE (";
				if($subject_id !== NULL){
					$query .= "`id` LIKE ? ";
					array_push($params, "%{$subject_id}%");
					$flag = 1;
				}
				if($subject_id !== NULL){
					if($flag === 1){
						$query .= " || `name` LIKE ? ";
					}else{
						$query .= " `name` LIKE ? ";
					}
					array_push($params, "%{$subject_name}%");
					$flag = 1;
				}

				if($subject_code !== NULL){
					if($flag === 1){
						$query .= " || `code` LIKE ? ";
					}else{
						$query .= " `code` LIKE ? ";
					}
					array_push($params, "%{$subject_code}%");
					$flag = 1;
				}
				$query .= ")";
			}

			if($grade != NULL){
				if($flag === 1){
					$query .= " && `grade`= ? ";
				}else{
					$query .= " WHERE `grade`= ? ";
				}
				array_push($params, $grade);
				$flag = 1;
			}

			if($medium != NULL){
				if($flag === 1){
					$query .= " && `medium`= ? ";
				}else{
					$query .= " WHERE `medium`= ? ";
				}
				array_push($params, $medium);
				$flag = 1;
			}
			$stmt = $this->con->db->prepare($query);
			$result= $stmt->execute($params);
			if($result){
				return $stmt->fetchAll();
			}else{
				return FALSE;
			}
		}

		// register a new subject
		public function register($data){
			$temp = $data;
			unset($temp['description']);
			$result = $this->con->select("subject", $temp);
			if($result && $result->rowCount() !== 0 ){
				return FALSE;
			}
			return $this->con->insert("subject",$data);
		}

		// update a new subject
		public function update_subject($id,$data){
			$result = $this->con->select("subject", ['id'=>$id]);
			if(!$result || $result->rowCount() !== 1 ){
				return FALSE;
			}
			return $this->con->update("subject",$data,['id'=>$id]);
		}

		// delete a subject
		public function delete_subject($id){
			return $this->con->delete("subject",["id"=>$id]);
		}

		//import subject details
		public function submit_details($data)
	    {
		    $this->con->insert("subject", $data);
	    }
	}

 ?>