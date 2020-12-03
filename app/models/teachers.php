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
	}
 ?>