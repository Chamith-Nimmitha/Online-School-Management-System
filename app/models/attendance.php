<?php 

	class AttendanceModel extends Model{
		public function __construct() {
			parent::__construct();
		}

		// get all classroom list
		public function get_classroom_attendance($classroom_id){
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
					$result = $this->con->select("stu_att", ["student_id"=>$students_list[$i]['id'], "classroom_id"=>$classroom_id]);
					if(!$result){
						throw new PDOException();
					}
					$stu_att_id = $result->fetch()['id'];
					$result = $this->con->select("student_attendance", ["id"=>$stu_att_id, "date"=>date("Y-m-d")]);
					if($result && $result->rowCount() === 1 ){
						$result = $result->fetch();
						$students_list[$i]['attendance'] = $result["attendance"];
						$students_list[$i]['note'] = $result["note"];
						$students_list[$i]['date'] = $result["date"];
					}
				}
				$this->con->db->commit();		
				return $students_list;
			} catch (Exception $e) {
				$this->con->db->rollback();		
				return FALSE;
			}
		}

		// mark classroom attendance
		public function mark_classroom_attendance($classroom_id,$students_list,$date){

			try {
				$this->con->db->beginTransaction();
				foreach ($students_list as $student) {
					$this->con->get(["id"]);
					$result = $this->con->select("stu_att",["student_id"=>$student['id'], "classroom_id"=>$classroom_id]);
					if(!$result){
						throw new PDOException();
					}
					if($result->rowCount() === 0){
						$result = $this->con->insert("stu_att",["student_id"=>$student['id'], "classroom_id"=>$classroom_id]);
						if(!$result){
							throw new PDOException();
						}
						$this->con->get(["id"]);
						$result = $this->con->select("stu_att",["student_id"=>$student['id'], "classroom_id"=>$classroom_id]);
						$stu_att_id = $result->fetch()['id'];

						$result = $this->con->insert("student_attendance",["id"=>$stu_att_id, "attendance"=> $student["attendance"],"note"=>$student['note'],"date"=>$date]);
						if(!$result){
							throw new PDOException();
						}
					}else{
						$stu_att_id = $result->fetch()['id'];
						$result = $this->con->insert("student_attendance",["id"=>$stu_att_id, "attendance"=> $student["attendance"],"note"=>$student['note'],"date"=>$date]);
						if(!$result){
							throw new PDOException();
						}
						if($result && $result->rowCount() === 0 ){
							$result = $this->con->update("student_attendance",["attendance"=> $student["attendance"],"note"=>$student['note']], ["id"=>$stu_att_id ,"date"=>$date]);
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
				

			unset($classroom);
			return $students_list;
		}

		// filter classroom attendance
		public function search($classroom_id,$student_id=NULL,$date=NULL){
			$params = [];
			$query = "SELECT SQL_CALC_FOUND_ROWS `s`.`id`,`s`.`name_with_initials`,`st_at`.`attendance`,`st_at`.`note`,`st_at`.`date` FROM `stu_att` AS `sa` INNER JOIN `student_attendance` AS `st_at` ON `sa`.`id`=`st_at`.`id` INNER JOIN `student` AS `s` ON `sa`.`student_id`=`s`.`id` WHERE `sa`.`classroom_id`=? ";
			array_push($params, $classroom_id);

			if($student_id !== NULL ){
				$query .= " && `sa`.`student_id` LIKE ? ";
				array_push($params, "%{$student_id}%");
			}

			if($date !== NULL){
				$query .= " && `st_at`.`date`= ? ";
				array_push($params, $date);
			}

			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get all attendance records by student id
		public function get_attendance_by_student_id($student_id){

			$query = "SELECT `st_at`.`date`,`st_at`.`attendance` FROM `student_attendance` AS `st_at` INNER JOIN `stu_att` AS `sa` ON `st_at`.`id`=`sa`.`id` WHERE `sa`.`student_id`= ? ORDER BY `st_at`.`date` DESC";
			$params = ["$student_id"];
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