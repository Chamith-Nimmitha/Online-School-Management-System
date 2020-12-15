
<?php 

	class ClassroomsModel extends Model{
		private $table;
		public function __construct(){
			parent::__construct();
			$this->table = "classroom";
		}

		// get all classrooms data
		public function get_classroom_list($classroom_id=NULL,$grade=NULL,$class=NULL){

			$query = "SELECT `c`.`id` FROM `classroom` AS `c` JOIN `section` AS `s` WHERE `s`.`id`=`c`.`section_id` ";
			$params = [];
			$where_flag = 0;

			if($classroom_id !== NULL){
				$query .= " && (`c`.`id` LIKE ? ";
				array_push($params, "%{$classroom_id}%");
				$where_flag = 1;
			}

			if($grade !== NULL){
				if($where_flag ===1 ){
					$query .= " && `s`.`grade`= ? ";
				}else{
					$query .= " && (`s`.`grade`= ? ";
				}
				array_push($params, $grade);
				$where_flag = 1;
			}

			if($class !== NULL){
				if($where_flag === 1 ){
					$query .= " && `c`.`class`= ? ";
				}else{
					$query .= " && (`c`.`class`= ? ";
				}
				array_push($params, $class);
				$where_flag = 1;
			}
			if($where_flag === 1){
				$query .= ")";
			}
			$stmt = $this->con->db->prepare($query);
			$result = $stmt->execute($params);
			if($result){
				$result_set = $stmt->fetchAll();
				return $this->get_all_data($result_set);
			}
		}

		// get distict section category
		public function get_categories(){
			$query = "SELECT distinct `category` FROM `section`";
			$result = $this->con->pure_query($query);
			if($result){
				return $result->fetchAll();
			}else{
				return FALSE;
			}
		}

		// get all section/ grades
		public function get_section_list_by_category($category){
			$result_set = $this->con->select("section",["category"=>$category]);
			if($result_set){
				return $result_set->fetchAll();
			}else{
				return FALSE;
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