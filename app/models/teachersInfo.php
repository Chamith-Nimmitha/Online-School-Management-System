<?php 
	class TeachersInfo{
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


		public function get_teacher_list($teacher_id=NULL,$teacher_name=NULL){
			$query = "SELECT `t`.`id` FROM `teacher` AS `t` ";
			$flag = 0;
			$id_flag = 0; 
			$name_flag = 0;

			if($teacher_id !== NULL){
				if($flag === 1){
					$query .= "&& ";
				}else{
					$query .= " WHERE ";
				}
				$query .= "(`t`.`id` LIKE '%{$teacher_id}%' ";
				$flag = 1;
				$id_flag = 1;
			}

			if($teacher_name !== NULL){
				if($flag === 1){
					if($id_flag === 1){
						$query .= "|| ";
					}else{
						$query .= ") && ";
					}
				}else{
					$query .= " WHERE ";
				}
				$query .= "`t`.`name_with_initials` LIKE '%{$teacher_name}%' ";
				$flag = 1;
				$name_flag = 1;
			}

			if($id_flag === 1 && $name_flag === 0 ){
				$query .= ") ";
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
			require_once(MODELS."teacher.php");
			if($result_set && !empty($result_set)){
				$data = array();
				for( $i=0; $i < count($result_set); $i++ ){
					$teacher = new TeacherModel();
					$teacher->set_by_id($result_set[$i]['id']);
					$data[$i] = $teacher->get_data();
					unset($teacher);
				}
				return $data;
			}else{
				return FALSE;
			}
		}


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