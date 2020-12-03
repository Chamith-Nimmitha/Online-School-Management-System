<?php 

	class TeachersModel extends Model{
		public function __construct(){
			parent::__construct();
		}

		public function get_teacher_list(){
			$result_set = $this->con->select("teacher");
			if(!$result_set){
				return FALSE;
			}
			return $result_set->fetchAll();
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
	}
 ?>