<?php 

	class subjectsModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		// filter and get subject list
		public function get_subject_list($start,$count,$subject_id=NULL, $subject_name=NULL, $subject_code=NULL, $grade = NULL, $medium=NULL){

			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM `subject` ";
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
			$query .= " LIMIT $start,$count";
			$stmt = $this->con->db->prepare($query);
			$result= $stmt->execute($params);
			if($result){
				return $stmt->fetchAll();
			}else{
				return FALSE;
			}
		}

		// get result count
		public function get_count(){
			return $this->con->get_count();
		}

		// get student list for teacher_subject
		public function get_student_list($teacher_subject_id){
			$query = "SELECT `s`.* FROM `student` AS `s` INNER JOIN `tea_sub_student` AS `tss` ON `s`.`id`=`tss`.`student_id` WHERE `tss`.`teacher_subject_id`=?";
			return $this->con->pure_query($query,[$teacher_subject_id]);
		}

		// get teacher and subject data using teacher_subject_id
		public function get_teacher_subject_info($teacher_subject_id){
			$query = "SELECT `s`.*,`ts`.`teacher_id` AS `teacher_id` FROM `subject` AS `s` INNER JOIN `teacher_subject` AS `ts` ON `s`.`id`=`ts`.`subject_id` WHERE `ts`.`id`=? ";
			return $this->con->pure_query($query, [$teacher_subject_id]);
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

	    // get all general subjects for grade
	    public function get_general_subjects($grade){
	    	return $this->con->select("subject",["grade"=>$grade, "type"=>"General"]);
	    }

	    // get all optional subjects for grade
	    public function get_optional_subjects($grade){
	    	return $this->con->select("subject",["grade"=>$grade, "type"=>"Optional"]);
	    }

	    // get all optional subjects categories for grade
	    public function get_optional_subjects_distinct_category($grade){
	    	$query = 'SELECT DISTINCT 	`category` FROM `subject` WHERE `grade`=? AND `type`="Optional" ORDER BY `category`';
	    	return $this->con->pure_query($query, [$grade]);
	    }

	    // get other subjects for grade
	    public function get_other_subjects($grade){
	    	return $this->con->select("subject",["grade"=>$grade, "type"=>"Other"]);
	    }

	    // get teacher list acording to subjects
	    public function get_teachers($subject_list){
	    	require_once(MODELS."subject.php");
	    	$teacher_list = [];
	    	foreach ($subject_list as $sub) {
	    		$s = new SubjectModel();
	    		$result = $s->set_by_id($sub['id']);
	    		if(!$result){
	    			return FALSE;
	    		}
	    		$t_list = $s->get_teachers();
	    		if($t_list === FALSE){
	    			return FALSE;
	    		}
	    		$teacher_list[$sub['id']] = $t_list;
	    	}
	    	return $teacher_list;
	    }
	}

 ?>