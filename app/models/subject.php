
<?php 
	class SubjectModel extends Model{
		private $id;
		private $name;
		private $grade;
		private $medium;
		private $code;
		private $description;

		// create database connection
		public function __construct(){
			$this->con = new Database();
			$this->table = "subject";
			$this->state = 0;
		}

		// set data using assosiative array 
		public function set_data($data){
			if( is_array($data)){
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$this->state = 1;
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// set data using subject id
		public function set_by_id($id){
			$data = $this->con->select($this->table, array("id"=>$id));
			if($data && $data->rowCount() == 1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}

		//set data using subject code
		public function set_by_code($code){
			$data = $this->con->select($this->table, array("code"=>$code));
			if($data && $data->rowCount() == 1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}


		// getters
		public function get_id(){return $this->id;}
		public function get_name(){return $this->name;}
		public function get_grade(){return $this->grade;}
		public function get_medium(){return $this->medium;}
		public function get_code(){return $this->code;}
		public function get_description(){return $this->description;}


		// get timetable object which contains timetable
		public function get_timetabel_object(){
			require_once(MODELS."timetable.php");
			$timetable = new TimetableModel();
			$result = $timetable->set_by_id($this->timetable_id);
			if($result){
				return  $timetable;
			}else{
				return FALSE;
			}	
		}


		//get all classroom data as assosiative array
		public function get_data(){
			$data['id'] = $this->id;
			$data['name'] = $this->name;
			$data['grade'] = $this->grade;
			$data['medium'] = $this->medium;
			$data['code'] = $this->code;
			$data['description'] = $this->description;
			return $data;
		}

		public function __destruct(){
			unset($this->con);
		}
	}

 ?>