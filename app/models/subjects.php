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
			$query = "SELECT `s`.*, `c`.`class` FROM `student` AS `s` INNER JOIN `tea_sub_student` AS `tss` ON `s`.`id`=`tss`.`student_id` INNER JOIN `classroom` AS `c` ON `c`.`id`=`s`.`classroom_id` WHERE `tss`.`teacher_subject_id`=?";
			return $this->con->pure_query($query,[$teacher_subject_id]);
		}

		// get student list without teacher_subject
		public function get_student_list_not_subject($teacher_subject_id, $student_id=NULL, $student_name=NULL,$classroom_id=NULL){
			$query = "SELECT COUNT(*) AS `count` FROM `tea_sub_student` AS `tss` INNER JOIN `teacher_subject` AS `ts` ON `tss`.`teacher_subject_id`=`ts`.`id` WHERE `tss`.`teacher_subject_id` = ? ";
			$result = $this->con->pure_query($query, [$teacher_subject_id]);
			if($result->fetch()['count'] > 0){
				$query = "SELECT `s`.`id`,`s`.`name_with_initials`,`s`.`contact_number`,`s`.`grade`,`s`.`email` FROM `teacher_subject` AS `ts` INNER JOIN `subject` AS `su` ON `su`.`id`=`ts`.`subject_id` INNER JOIN `student` AS `s` ON `s`.`grade`=`su`.`grade` LEFT JOIN `tea_sub_student` AS `tss` ON `tss`.`teacher_subject_id`=`ts`.`id`   WHERE `ts`.`id`= ?  && `s`.`id`!=`tss`.`student_id` ";
			}else{
				$query = "SELECT `s`.`id`,`s`.`name_with_initials`,`s`.`contact_number`,`s`.`grade`,`s`.`email` FROM `teacher_subject` AS `ts` INNER JOIN `subject` AS `su` ON `su`.`id`=`ts`.`subject_id` INNER JOIN `student` AS `s` ON `s`.`grade`=`su`.`grade` LEFT JOIN `tea_sub_student` AS `tss` ON `tss`.`teacher_subject_id`=`ts`.`id`   WHERE `ts`.`id`= ? ";
			}
			$params = [$teacher_subject_id];
			$flag = 0;
			if($student_id!==NULL){
				$query .= "&& (`s`.`id` LIKE ? ";
				array_push($params, "%{$student_id}%");
				$flag = 1;
			}
			if($student_id!==NULL){
				if($flag === 1){
					$query .= "|| `s`.`name_with_initials` LIKE ? ) ";
				}else{
					$query .= "&& `s`.`name_with_initials` LIKE ? ";
				}
				array_push($params, "%{$student_name}%");
				$flag = 2;
			}

			if($classroom_id!==NULL){
				if($flag === 1){
					$query .= ") && `s`.`classroom_id`= ? ";
				}else{
					$query .= " && `s`.`classroom_id`= ? ";
				}
				array_push($params, $classroom_id);
			}


			return $this->con->pure_query($query, $params);
		}

		// get teacher subject class list
		public function get_tea_sub_class_list($teacher_subject_id){
			$query = "SELECT `c`.* FROM `teacher_subject` AS `ts` INNER JOIN `subject` AS `su` ON `ts`.`subject_id`=`su`.`id` INNER JOIN `section` AS `s` ON `su`.`grade`=`s`.`grade` INNER JOIN `classroom` AS `c` ON `s`.`id`=`c`.`section_id` WHERE `ts`.`id`= ? ";
			return $this->con->pure_query($query,[$teacher_subject_id]);
		}

		// assign new students to the subject
		public function assign_student_to_subject($teacher_subject_id,$student_ids){
			try {
				$this->con->db->beginTransaction();

				foreach ($student_ids as $id) {
					$result = $this->con->insert("tea_sub_student", ["teacher_subject_id"=>$teacher_subject_id, "student_id"=>$id]);
					if(!$result){
						throw new Exception();
					}
				}

				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}
		}

		// remove students from the subject
		public function remove_student_from_subject($teacher_subject_id,$student_ids){
			try {
				$this->con->db->beginTransaction();

				foreach ($student_ids as $id) {
					$result = $this->con->delete("tea_sub_student", ["teacher_subject_id"=>$teacher_subject_id, "student_id"=>$id]);
					if(!$result){
						throw new Exception();
					}
				}

				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}
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

	    // update timetable 
	    public function update_timetable($subjects,$classroom_id){
	    	require_once(MODELS."classroom.php");
	    	require_once(MODELS."timetable.php");
	    	foreach ($subjects as $subject) {
	    		try {
					$this->con->db->beginTransaction();
					// update general subjects
					if(!empty($subjects['General'])){
						foreach ($subjects['General'] as $subject) {
							
							//NULL Previous timetable for this classroom
							$cls = new ClassroomModel();
							$cls->set_by_id($classroom_id);
							$grade = $cls->get_grade();
							$class = $cls->get_class();
							unset($cls);
							
							$result = $this->con->select("class_subject",["classroom_id"=>$classroom_id,"subject_id"=>$subject['id']]);
							if(!$result && $result->rowCount() != 1){
								throw new PDOException();
							}
							$tt_task = $grade."-".$class."-".$subject['id'];
							$old_teacher_id = $result->fetch()['teacher_id'];
							if($old_teacher_id != NULL && !empty($old_teacher_id) ){
								$tt = new TimetableModel();
								$tt->set_by_user_id($old_teacher_id,"teacher");
								$old_timetable_id = $tt->get_id();
								$query = "UPDATE `normal_day` SET `task`='FREE' WHERE `task`='${tt_task}' && `timetable_id`='${old_timetable_id}'";
								$result = $this->con->pure_query($query);
								if(!$result){
									throw new PDOException();
									
								}
							}

							unset($tt);
							// add new subjects to teacher
							$tt = new TimetableModel();
							if($subject['teacher_id'] != "None"){
								$tt->set_by_user_id($subject['teacher_id'],"teacher");
								$timetable_id = $tt->get_id();
								foreach ($subject["periods"] as $period) {
									$result = $this->con->update("normal_day",["task"=>"${tt_task}"],['timetable_id'=>$timetable_id,"day"=>$period['day'],"period"=>$period['period']]);
									if(!$result){
										throw new PDOException();
									}
								}
							}

							if($subject['teacher_id'] == "None"){
								$query = "UPDATE `class_subject` SET `teacher_id`= NULL WHERE `classroom_id`=? && `subject_id`=?";
								$result = $this->con->pure_query($query,[$classroom_id,$subject['id']]);
							}else{
								$result = $this->con->update("class_subject",["teacher_id"=>$subject['teacher_id']], ["classroom_id"=>$classroom_id,"subject_id"=>$subject['id']]);
							}
							if(!$result){
								throw new PDOException();
							}

						}
					}
					$this->con->db->commit();
					return TRUE;
				} catch (Exception $e) {
					$this->con->db->rollBack();
					return FALSE;
				}
	    	}
	    }
	}

 ?>