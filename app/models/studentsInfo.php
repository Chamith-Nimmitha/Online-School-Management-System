
<?php 
	class StudentsInfo{
		public $start;
		public $count;
		public $limit;
		public $con;
		public function __construct($start=NULL,$count=NULL){
			$this->con = new Database();
			$this->table = "student";
			$this->set_limit($start,$count);
		}

		public function set_limit($start,$count){
			if($start !== NULL && $count !== NULL ){
				$this->limit = " {$start}, {$count}";
			}else{
				$this->limit = 50;
				$this->start = 0;
				$this->count = 50;
			}
		}


		public function get_student_list($student_id=NULL,$student_name=NULL,$grade=NULL,$class=NULL){
			$query = "SELECT `s`.`id` FROM `student` AS `s` ";
			$flag = 0; // use for check wether query is already complete or not
			$id_flag = 0; // use for check wether student id is set
			$name_flag = 0; // use for check wether student name is set
			if($class !== NULL){
				$query .= " JOIN `classroom` AS `c` ON `c`.`id`=`s`.`classroom_id` WHERE (`c`.`class`='{$class}') ";
				$flag = 1;	
			}
			if($student_id !== NULL){
				if($flag === 1){
					$query .= "&& ";
				}else{
					$query .= " WHERE ";
				}
				$query .= "(`s`.`id` LIKE '%{$student_id}%' ";
				$flag = 1;
				$id_flag = 1;
			}
			if($student_name !== NULL){
				if($flag === 1){
					if($id_flag === 1){
						$query .= "|| ";
					}else{
						$query .= ") && ";
					}
				}else{
					$query .= " WHERE ";
				}
				$query .= "`s`.`name_with_initials` LIKE '%{$student_name}%') ";
				$flag = 1;
				$name_flag = 1;
			}
			if($id_flag === 1 && $name_flag === 0 ){
				$query .= ") ";
			}
			if($grade !== NULL){
				if($flag === 1){
					$query .= "&& ";
				}else{
					$query .= " WHERE ";
				}
				$query .= "(`s`.`grade`='{$grade}') ";
				$flag = 1;
			}
			$query .=  "LIMIT {$this->limit}";
			$result_set = $this->con->pure_query($query);
			if($result_set){
				$result_set = $result_set->fetchAll();
				$result = $this->get_full_data($result_set);
				return $result;
			}else{
				return FALSE;
			}
		}

		public function get_full_data($result_set){
			require_once(MODELS."student.php");
			if($result_set && !empty($result_set)){
				$data = array();
				for( $i=0; $i < count($result_set); $i++ ){
					$student = new StudentModel();
					$student->set_by_id($result_set[$i]['id']);
					$data[$i] = $student->get_data();
					unset($student);
				}
				return $data;
			}else{
				return FALSE;
			}
		}

		//get all student count
		public function get_count(){
			$query = "SELECT COUNT(*) AS count FROM `$this->table`";
			$result = $this->con->pure_query($query);
			if($result){
				return $result->fetch()['count'];
			}else{
				return FALSE;
			}
		}

		// get previous executed query affected student count
		public function get_pre_query_count(){
			if($this->con->pre_query != null ){
				$query = $this->con->pre_query;
				if(strpos($query, "SELECT") !== FALSE){
					$query = explode("FROM", $query)[1];
					$query = "SELECT COUNT(*) AS count FROM ".$query;
					if( strpos($query, "LIMIT")){
						$query = explode("LIMIT", $query)[0];
					}
					$result = $this->con->pure_query($query);
					if($result){
						// echo $query;
						// exit();
						return $result->fetch()['count'];
					}else{
						return FALSE;
					}
				}else{
					return FALSE;
				}
			}else{
				return FALSE;
			}
		}
	}
 ?>
