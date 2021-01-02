<?php 

	class TeachersModel extends Model{
		public function __construct(){
			parent::__construct();
		}

		public function get_not_class_teacher_list(){
			$query = "SELECT `t`.* FROM `teacher` AS  `t` WHERE `t`.`id` NOT IN (SELECT DISTINCT `c`.`class_teacher_id` FROM `classroom` AS `c` WHERE `c`.`class_teacher_id` is NOT NULL);";
			$result_set = $this->con->pure_query($query);
			if(!$result_set){
				return FALSE;
			}else{
				return $result_set->fetchAll();
			}
		}

		public function get_teacher_list($start=NULL, $count=NULL, $id=NULL,$name=NULL){
			$query = "SELECT SQL_CALC_FOUND_ROWS * FROM `teacher` ";
			$params = [];
			$flag = 0;

				if($id !== NULL){
					$query .= " WHERE (`id` LIKE '%{$id}%' ";
					array_push($params, "%{$id}%");
					$flag = 1;
				}

				if($name !== NULL){
					if($flag === 0){
						$query .= " WHERE (`name_with_initials` LIKE '%{$name}%'";
					}else{
						$query .= " || `name_with_initials` LIKE '%{$name}%' ";
					}
					array_push($params, "%{$name}%");
					$flag = 1;
				}
				if($flag === 1){
					$query .= ")";
				}
				$query .= " ORDER BY `id` ";
				if($start!= NULL){
					$query .= " LIMIT $start,$count";
				}
				$result_set = $this->con->pure_query($query);
			if($result_set){
				$result_set = $result_set->fetchAll();
				$result = $this->get_full_data($result_set);
				return $result;
			}else{
				return FALSE;
			}

		}

		public function get_count(){
			return $this->con->get_count();
		}

		public function get_full_data($result_set){
			require_once(MODELS."teacher.php");
			if($result_set && !empty($result_set)){
				$data = array();
				for( $i=0; $i < count($result_set); $i++ ){
					$teacher = new teacherModel();
					$teacher->set_by_id($result_set[$i]['id']);
					$data[$i] = $teacher->get_data();
					unset($teacher);
				}
				return $data;
			}else{
				return FALSE;
			}
		}


	}
 ?>