<?php 

	class AttendanceModel extends Model{
		public function __construct() {
			parent::__construct();
		}

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

		public function mark_classroom_attendance($classroom_id,$students_list){

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

						$result = $this->con->insert("student_attendance",["id"=>$stu_att_id, "date"=>date("Y-m-d"), "attendance"=> $student["attendance"],"note"=>$student['note']]);
						if(!$result){
							throw new PDOException();
						}
					}else{
						$stu_att_id = $result->fetch()['id'];
						$result = $this->con->insert("student_attendance",["id"=>$stu_att_id, "date"=>date("Y-m-d"), "attendance"=> $student["attendance"],"note"=>$student['note']]);
						if(!$result){
							throw new PDOException();
						}
						if($result && $result->rowCount() === 0 ){
							$result = $this->con->update("student_attendance",["attendance"=> $student["attendance"],"note"=>$student['note']], ["id"=>$stu_att_id, "date"=>date("Y-m-d")]);
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
	}

 ?>