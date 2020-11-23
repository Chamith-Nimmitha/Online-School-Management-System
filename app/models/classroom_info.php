
<?php 

	class ClassroomInfo{
		private $con;
		private $table;
		public function __construct(){
			unset($con);
			$this->con = new Database();
			$this->table = "classroom";
		}

		public function get_classroom_list(){
			$this->con->get(array("id"));
			$result_set = $this->con->select($this->table);
			if($result_set){
				$result_set = $result_set->fetchAll();
				return $this->get_all_data($result_set);
			}
		}

		public function get_all_data($result_set){
			if($result_set && !empty($result_set)){
				$data = array();
				for($i=0; $i < count($result_set); $i++){
					$c = new ClassroomClass();
					$c->set_by_id($result_set[$i]['id']);
					$data[$i] = $c->get_data();
				}
				return $data;
			}else{
				return FALSE;
			}
		}
	}
 ?>