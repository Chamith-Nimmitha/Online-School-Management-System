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
		}

		// filter classroom attendance
		public function classroom_attendance_search($classroom_id,$student_id=NULL,$date=NULL){
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

			$query = "SELECT `st_at`.`date`,`st_at`.`attendance`,`st_at`.`note` FROM `student_attendance` AS `st_at` INNER JOIN `stu_att` AS `sa` ON `st_at`.`id`=`sa`.`id` WHERE `sa`.`student_id`= ? ORDER BY `st_at`.`date` DESC LIMIT 10";
			$params = ["$student_id"];
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// filter specific student attendance by year,month,week
		public function student_attendance_filter($student_id,$year,$month,$week){
			$query = "SELECT `st_at`.`date`,`st_at`.`attendance`,`st_at`.`note` FROM `student_attendance` AS `st_at` INNER JOIN `stu_att` AS `sa` ON `st_at`.`id`=`sa`.`id` WHERE `sa`.`student_id`= ? ";
			$params = ["$student_id"];

			if($year !== NULL){
				$query .= " AND YEAR(`st_at`.`date`)= ? ";
				array_push($params,$year);
			}
			if($month !== NULL){
				$query .= " AND MONTH(`st_at`.`date`)= ? ";
				array_push($params,$month);
			}
			if($week !== NULL){
				$query .= " AND WEEK(`st_at`.`date`,5)= ? ";
				array_push($params,$week-1);
			}
			$query .= "ORDER BY `st_at`.`date` DESC";

			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get attendance data for bar chart
		public function student_attendance_overview_bar($student_id,$year=NULL,$month=NULL,$state=1){
			$query = " FROM `student_attendance` AS `st_at` INNER JOIN `stu_att` AS `sa` ON `st_at`.`id`=`sa`.`id` WHERE `sa`.`student_id`= ? AND `st_at`.`attendance`= ? ";
			$params = ["$student_id"];
			array_push($params,$state);
			$month_flag = 0;

			if($year !== NULL){
				$query .= " AND YEAR(`st_at`.`date`)= ? ";
				array_push($params,$year);
			}
			if($month !== NULL){
				$query .= " AND MONTH(`st_at`.`date`)= ? ";
				array_push($params,$month);
				$month_flag = 1;
				$query = "SELECT WEEK(`st_at`.`date`,5) AS `week`, COUNT(*)AS `count` ". $query;
				$query .= "GROUP BY WEEK(`st_at`.`date`,5) ORDER BY WEEK(`st_at`.`date`,5) DESC";
			}else{
				$query = "SELECT MONTH(`st_at`.`date`) AS `month`, COUNT(*)AS `count` ". $query;
				$query .= "GROUP BY MONTH(`st_at`.`date`) ORDER BY MONTH(`st_at`.`date`) ASC";
			}
			// print_r($query);
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get school attendance for dashboard
		public function dashboard_student_attendance_overview_bar($date,$attendance){
			$query = "SELECT COUNT(*) AS `count` FROM `student_attendance` WHERE `date` = ? AND `attendance`= ?";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$date,$attendance]);
			if($result){
				return $stmt->fetch()['count'];
			}else{
				return FALSE;
			}
		}

		// classroom aatendance_count using student id
		public function classroom_attendance_count($student_id,$year=NULL,$month=NULL,$state=1){
			$query = " FROM `student_attendance` AS `st_at` INNER JOIN `stu_att` AS `sa` ON `st_at`.`id`=`sa`.`id` INNER JOIN `student` AS `s` ON `sa`.`classroom_id`=`s`.`classroom_id` WHERE `s`.`id`= ? AND `st_at`.`attendance`= ? ";
			$params = ["$student_id"];
			array_push($params,$state);
			$month_flag = 0;

			if($year !== NULL){
				$query .= " AND YEAR(`st_at`.`date`)= ? ";
				array_push($params,$year);
			}
			if($month !== NULL){
				$query .= " AND MONTH(`st_at`.`date`)= ? ";
				array_push($params,$month);
				$month_flag = 1;
				$query = "SELECT WEEK(`st_at`.`date`,5) AS `week`, COUNT(*)AS `count` ". $query;
				$query .= "GROUP BY WEEK(`st_at`.`date`,5) ORDER BY WEEK(`st_at`.`date`,5) DESC";
			}else{
				$query = "SELECT MONTH(`st_at`.`date`) AS `month`, COUNT(*)AS `count` ". $query;
				$query .= "GROUP BY MONTH(`st_at`.`date`) ORDER BY MONTH(`st_at`.`date`) ASC";
			}
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get teacher list
		public function get_teacher_attendance(){
			$this->con->get(['id','name_with_initials']);
			$teacher_list = $this->con->select("teacher",['is_deleted'=>0]);
			$teacher_list = $teacher_list->fetchAll();

			try {
				$this->con->db->beginTransaction();
				for ($i=0; $i < count($teacher_list); $i++) { 
					$result = $this->con->select("teacher_attendance", ["teacher_id"=>$teacher_list[$i]['id'], "date"=>date("Y-m-d")]);
					if($result && $result->rowCount() === 1 ){
						$result = $result->fetch();
						$teacher_list[$i]['attendance'] = $result["attendance"];
						$teacher_list[$i]['note'] = $result["note"];
						$teacher_list[$i]['date'] = $result["date"];
					}
				}
				$this->con->db->commit();		
				return $teacher_list;
			} catch (Exception $e) {
				$this->con->db->rollback();		
				return FALSE;
			}
		}

		// mark teacher attendance
		public function mark_teacher_attendance($teacher_list,$date){

			try {
				$this->con->db->beginTransaction();
				foreach ($teacher_list as $teacher) {
					$result = $this->con->select("teacher_attendance",["teacher_id"=>$teacher['id'],"date"=>$date]);
					if(!$result){
						throw new PDOException();
					}
					if($result->rowCount() === 0){
						$result = $this->con->insert("teacher_attendance",["teacher_id"=>$teacher['id'], "attendance"=> $teacher["attendance"],"note"=>$teacher['note'],"date"=>$date]);
						if(!$result){
							throw new PDOException();
						}
					}else{
						$result = $this->con->update("teacher_attendance",["attendance"=> $teacher["attendance"],"note"=>$teacher['note']],["teacher_id"=>$teacher['id'],"date"=>$date]);
						if(!$result){
							throw new PDOException();
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

		// filter teacher attendance
		public function teacher_attendance_search($teacher_id=NULL,$teacher_name=NULL,$date=NULL){
			$params = [];
			$query = "SELECT SQL_CALC_FOUND_ROWS `t`.`id`,`t`.`name_with_initials`,`ta`.`attendance`,`ta`.`note`,`ta`.`date` FROM `teacher_attendance` AS `ta` INNER JOIN `teacher` AS `t` ON `ta`.`teacher_id`=`t`.`id` ";

			$flag = 0;
			$name_flag = 0;
			if($teacher_id !== NULL ){
				$query .= " WHERE (`ta`.`teacher_id` LIKE ? ";
				array_push($params, "%{$teacher_id}%");
				$flag = 1;
			}

			if($teacher_name !== NULL ){
				if( $flag === 0){
					$query .= " WHERE `t`.`name_with_initials` LIKE ? ";
				}else{
					$query .= " OR `t`.`name_with_initials` LIKE ? ) ";
				}
				array_push($params, "%{$teacher_name}%");
				$flag = 1;
				$name_flag = 1;
			}

			if($date !== NULL){
				if($flag === 0){
					$query .= " WHERE `ta`.`date`= ? ";
				}else{
					if($name_flag===0){
						$query .= ") && `ta`.`date`= ? ";
					}else{
						$query .= " && `ta`.`date`= ? ";
					}
				}
				array_push($params, $date);
			}
			// print_r($query);
			// print_r($params);
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get all attendance records by teacher id
		public function get_attendance_by_teacher_id($teacher_id){

			$query = "SELECT `date`,`attendance`,`note` FROM `teacher_attendance` WHERE `teacher_id`= ? ORDER BY `date` DESC LIMIT 10";
			$params = ["{$teacher_id}"];
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// filter specific teacher attendance by year,month,week
		public function teacher_attendance_filter($teacher_id,$year,$month,$week){
			$query = "SELECT `date`,`attendance`,`note` FROM `teacher_attendance` WHERE `teacher_id`= ? ";
			$params = ["$teacher_id"];

			if($year !== NULL){
				$query .= " AND YEAR(`date`)= ? ";
				array_push($params,$year);
			}
			if($month !== NULL){
				$query .= " AND MONTH(`date`)= ? ";
				array_push($params,$month);
			}
			if($week !== NULL){
				$query .= " AND WEEK(`date`,5)= ? ";
				array_push($params,$week-1);
			}
			$query .= "ORDER BY `date` DESC";

			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get attendance data for bar chart
		public function teacher_attendance_overview_bar($teacher_id,$year=NULL,$month=NULL,$state=1){
			$query = " FROM `teacher_attendance` WHERE `teacher_id`= ? AND `attendance`= ? ";
			$params = ["{$teacher_id}"];
			array_push($params,$state);
			$month_flag = 0;

			if($year !== NULL){
				$query .= " AND YEAR(`date`)= ? ";
				array_push($params,$year);
			}
			if($month !== NULL){
				$query .= " AND MONTH(`date`)= ? ";
				array_push($params,$month);
				$month_flag = 1;
				$query = "SELECT WEEK(`date`,5) AS `week`, COUNT(*)AS `count` ". $query;
				$query .= "GROUP BY WEEK(`date`,5) ORDER BY WEEK(`date`,5) DESC";
			}else{
				$query = "SELECT MONTH(`date`) AS `month`, COUNT(*)AS `count` ". $query;
				$query .= "GROUP BY MONTH(`date`) ORDER BY MONTH(`date`) ASC";
			}
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				return $stmt;
			}else{
				return FALSE;
			}
		}

		// get teacher attendance for dashboard
		public function dashboard_teacher_attendance_overview_bar($date,$attendance){
			$query = "SELECT COUNT(*) AS `count` FROM `teacher_attendance` WHERE `date` = ? AND `attendance`= ?";
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute([$date,$attendance]);
			if($result){
				return $stmt->fetch()['count'];
			}else{
				return FALSE;
			}
		}
	}
 ?>