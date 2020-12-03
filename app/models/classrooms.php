
<?php 

	class ClassroomsModel extends Model{
		private $table;
		public function __construct(){
			parent::__construct();
			$this->table = "classroom";
		}

		// get all classrooms data
		public function get_classroom_list(){
			$this->con->get(array("id"));
			$result_set = $this->con->select($this->table);
			if($result_set){
				$result_set = $result_set->fetchAll();
				return $this->get_all_data($result_set);
			}
		}

		// this function can't use directly. Use get_classroom_list() method.
		public function get_all_data($result_set){
			require_once(MODELS."classroom.php");
			if($result_set && !empty($result_set)){
				$data = array();
				for($i=0; $i < count($result_set); $i++){
					$c = new ClassroomModel();
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