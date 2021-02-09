<?php 

	class MarksModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		// get all classroom list
		public function get_classroom_marks($classroom_id){
			require_once( dirname( __FILE__ )."/classroom.php");
			$classroom = new ClassroomModel();
			$result = $classroom->set_by_id($classroom_id);
			if(!$result){
				return FALSE;
			}
			// get only student id and name list
			$students_list = $classroom->get_students_data(["id","name_with_initials"]);
			try {
				$this->con->db->beginTransaction();
				for ($i=0; $i < count($students_list); $i++) { 
					$result = $this->con->select("stu-marks", ["student_id"=>$students_list[$i]['id'], "classroom_id"=>$classroom_id]);
					if(!$result){
						throw new PDOException();
					}
					$stu_marks_id = $result->fetch()['id'];
					$result = $this->con->select("student_marks", array("id"=>$stu_marks_id));
					if($result){
						$result = $result->fetchAll();
						//print_r($result);
						foreach ($result as $rls) {
							foreach ($rls as $key => $value) {
									/*echo $key;
									echo '-->';
									echo $value;
									echo '<br>';*/
							}

						}
						/*$students_list[$i]['marks'] = $result["marks"];
						$students_list[$i]['note'] = $result["note"];
						$students_list[$i]['subject_id'] = $result["subject_id"];*/
					}
				}
				$this->con->db->commit();		
				return $students_list;
			} catch (Exception $e) {
				$this->con->db->rollback();		
				return FALSE;
			}
		}

		public function get_marks_by_student_id($student_id,$term,$year){

			$query = "SELECT `st_m`.`subject_id`,`st_m`.`marks`,`st_m`.`note`, `st_m`.`term`,`st_m`.`year` FROM `student_marks` AS `st_m` INNER JOIN `stu-marks` AS `sm` ON `st_m`.`id`=`sm`.`id` WHERE `sm`.`student_id`= {$student_id} AND `st_m`.`term`= {$term} AND `st_m`.`year`={$year}";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute();
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// filter classroom marks
		public function classroom_marks_search($classroom_id,$student_id=NULL,$subject_id=NULL,$term,$year){
			$params = [];
			$query = "SELECT SQL_CALC_FOUND_ROWS `s`.`id`,`s`.`name_with_initials`,`st_ma`.`marks`,`st_ma`.`note`,`st_ma`.`subject_id` FROM `stu-marks` AS `sm` INNER JOIN `student_marks` AS `st_ma` ON `sm`.`id`=`st_ma`.`id` INNER JOIN `student` AS `s` ON `sm`.`student_id`=`s`.`id` WHERE `sm`.`classroom_id`=? ";
			array_push($params, $classroom_id);

			if($student_id !== NULL ){
				$query .= " && `sm`.`student_id` LIKE ? ";
				array_push($params, "%{$student_id}%");
			}

			if($subject_id !== NULL){
				$query .= " && `st_ma`.`subject_id`= ? ";
				array_push($params, $subject_id);
			}

			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		public function upload_classroom_marks($classroom_id,$students_list,$subject_id){

			try {
				$this->con->db->beginTransaction();
				foreach ($students_list as $student) {
					$this->con->get(["id"]);
					$result = $this->con->select("stu-marks",["student_id"=>$student['id'], "classroom_id"=>$classroom_id]);
					if(!$result){
						throw new PDOException();
					}
					if($result->rowCount() === 0){
						$result = $this->con->insert("stu-marks",["student_id"=>$student['id'], "classroom_id"=>$classroom_id]);
						if(!$result){
							throw new PDOException();
						}
						$this->con->get(["id"]);
						$result = $this->con->select("stu-marks",["student_id"=>$student['id'], "classroom_id"=>$classroom_id]);
						$stu_marks_id = $result->fetch()['id'];

						$result = $this->con->insert("student_marks",["id"=>$stu_marks_id, "marks"=> $student["marks"],"note"=>$student['note'],"subject_id"=>$subject_id]);
						if(!$result){
							throw new PDOException();
						}
					}else{
						$stu_marks_id = $result->fetch()['id'];
						$result = $this->con->insert("student_marks",["id"=>$stu_marks_id, "marks"=> $student["marks"],"note"=>$student['note'],"subject_id"=>$subject_id]);
						if(!$result){
							throw new PDOException();
						}
						if($result && $result->rowCount() === 0 ){
							$result = $this->con->update("student_marks",["marks"=> $student["marks"],"note"=>$student['note']], ["id"=>$stu_marks_id ,"subject_id"=>$subject_id]);
							if(!$result){
								throw new PDOException();
							}
						}
					}
				}
				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollback();
				return FALSE;
			}
		}




		public function upload_classroom_marks1($classroom_id,$marks_list,$term,$year){
			try{
				$this->con->db->beginTransaction();
				foreach ($marks_list as $key => $value) {
					if($key !==0){
						$txt = explode("-",$key);
						$st_id=$txt[0];
						$sub_id=$txt[1];
							
						if(empty($value)){
							$result = $this->con->select("stu-marks",["student_id"=>$st_id, "classroom_id"=>$classroom_id]);
							$stu_marks_id = $result->fetch()['id'];

							$result = $this->con->delete("student_marks",["id"=>$stu_marks_id, "subject_id"=>$sub_id, "term"=>$term]);
						}						
					}
				}
				foreach ($marks_list as $key => $value) {
				if($key !==0){
					$txt = explode("-",$key);
					$st_id=$txt[0];
					$sub_id=$txt[1];

					$result = $this->con->select("stu-marks",["student_id"=>$st_id, "classroom_id"=>$classroom_id]);
					if(!$result){
						throw new PDOException();
					}

					if($result->rowCount() === 0){
						$result = $this->con->insert("stu-marks",["student_id"=>$st_id, "classroom_id"=>$classroom_id,"first_term_total"=>""]);
						if(!$result){
							throw new PDOException();
						}
						$con->get(["id"]);
						$result = $this->con->select("stu-marks",["student_id"=>$st_id, "classroom_id"=>$classroom_id]);
						$stu_marks_id = $result->fetch()['id'];

						$result = $this->con->insert("student_marks",["id"=>$stu_marks_id, "marks"=> $value,"note"=>"","subject_id"=>$sub_id,"term"=>$term,"year"=>$year]);
						if(!$result){
							throw new PDOException();
						}
					}else{
						$stu_marks_id = $result->fetch()['id'];
						$result = $this->con->insert("student_marks",["id"=>$stu_marks_id, "marks"=> $value,"note"=>"","subject_id"=>$sub_id,"term"=>$term,"year"=>$year]);
						if(!$result){
							throw new PDOException();
						}
						if($result && $result->rowCount() === 0 ){
							$result = $this->con->update("student_marks",["marks"=> $value,"note"=>""], ["id"=>$stu_marks_id ,"subject_id"=>$sub_id,"term"=>$term,"year"=>$year]);
							if(!$result){
								throw new PDOException();
							}
						}
					}
				}
			}
				$this->con->db->commit();
				return TRUE;
				}catch (Exception $e) {
				$this->con->db->rollback();
				return FALSE;
			}
					
		}



		public function dashboard_student_marks_overview_bar($subject_id,$term){
			$query = "SELECT * FROM `student_marks` WHERE `subject_id` = ? AND `term`= ? ";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$subject_id,$term]);
			if($result){
				$result = $stmt->fetchAll();

				$no_of_students['A']=0;
				$no_of_students['B']=0;
				$no_of_students['C']=0;
				$no_of_students['S']=0;
				$no_of_students['F']=0;

				foreach ($result as $re) {
					if( ($re['marks'] >= 75 )  && ($re['marks'] <= 100 ) ){
						$no_of_students['A'] += 1;
					}
					elseif( ($re['marks'] >= 65 )  && ($re['marks'] <= 74 )  ){
						$no_of_students['B'] += 1;
					}
					elseif( ($re['marks'] >= 50 )  && ($re['marks'] <= 64 ) ){
						$no_of_students['C'] += 1;
					}
					elseif( ($re['marks'] >= 35 )  && ($re['marks'] <= 49 ) ){
						$no_of_students['S'] += 1;
					}
					else{
						$no_of_students['F'] += 1;
					}

				}
				return $no_of_students;
			}else{
				return FALSE;
			}
		}

		public function student_report_chart($student_id,$term,$year){
			$query = "SELECT `sm`.`student_id`,`st_ma`.`marks`,`st_ma`.`note`,`st_ma`.`subject_id` FROM `stu-marks` AS `sm` INNER JOIN `student_marks` AS `st_ma` ON `sm`.`id`=`st_ma`.`id` WHERE `sm`.`student_id`=? AND `term`=? AND `year` =? ";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$student_id,$term,$year]);
			if($result){
				return $stmt;
			}
			else{
				return FALSE;
			}

		}


		public function student_subject_list($student_id,$year){
			$query = "SELECT DISTINCT `sm`.`student_id`,`st_ma`.`subject_id`,`sub`.`name`,`sub`.`code` FROM `stu-marks` AS `sm` INNER JOIN `student_marks` AS `st_ma` ON `sm`.`id`=`st_ma`.`id` INNER JOIN `subject` AS `sub` ON `sub`.`id`=`st_ma`.`subject_id` WHERE `sm`.`student_id`=? AND `year` =? ";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$student_id,$year]);
			if($result){
				return $stmt;
			}
			else{
				return FALSE;
			}
		}

		public function student_subject_lists($grade){
			$query = "SELECT * FROM `subject` WHERE `grade`=?";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$grade]);
			if($result){
				return $stmt;
			}
			else{
				return FALSE;
			}


		}


		public function get_rank($term){
			if($term ==1){
				$t = 'first_term_total';
			}
			elseif($term ==2){
				$t = 'second_term_total';
			}
			elseif($term==3){
				$t = 'third_term_total';
			}

			$query = "SELECT *, @curRank := @curRank + 1 AS rank FROM `stu-marks` p, (SELECT @curRank := 0) r ORDER BY {$t} DESC ";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute();
			if($result){
				return $stmt;
			}
			else{
				return FALSE;
			}

		}


		public function dashboard_student_marks_bar_bar($classroom_id){
			$query = "SELECT `st_ma`.`id`,`sm`.`student_id`,`st_ma`.`subject_id`,`st_ma`.`marks`,`st_ma`.`term` FROM `student_marks` AS `st_ma` INNER JOIN `stu-marks` AS `sm` ON `sm`.`id`=`st_ma`.`id` WHERE `sm`.`classroom_id`=?";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$classroom_id]);

			if($result){
				$result = $stmt->fetchAll();
				return $result;
			}
			else{
				return FALSE;
			}

		}





	}
?>