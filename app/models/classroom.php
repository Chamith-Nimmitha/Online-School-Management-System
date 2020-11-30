
<?php 
	class ClassroomModel extends Model{
		private $id;
		private $section_id;
		private $grade;
		private $class;
		private $class_teacher_id;
		private $timetable_id;
		private $state;
		// create database connection
		public function __construct(){
			$this->con = new Database();
			$this->table = "classroom";
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

		// set data using classroom id
		public function set_by_id($id){
			$data = $this->con->select($this->table, array("id"=>$id));
			if($data && $data->rowCount() == 1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$this->con->get(array("grade"));
				$result = $this->con->select("section",array("id"=>$this->section_id));
				if($result && $result->rowCount() == 1){
					$this->state = 1;
					$this->grade = $result->fetch()['grade'];
				}
				$this->con->get(['id']);
				$result =$this->con->select('normal_timetable',['user_id'=>$this->id, "type"=>"classroom"]);
				if($result && $result->rowCount() === 1){
					$this->timetable_id = $result->fetch()['id'];
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// set data using teacher_id
		public function set_by_teacher_id($class_teacher_id){
			$data = $this->con->select($this->table, array("class_teacher_id"=>$class_teacher_id));
			if( $data && $data->rowCount() == 1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$this->con->get(array("grade"));
				$result = $this->con->select("section",array("id"=>$this->section_id));
				if($result && $result->rowCount() == 1){
					$this->state = 1;
					$this->grade = $result->fetch()['grade'];
				}
				$this->con->get(['id']);
				$this->con->select('normal_timetable',['user_id'=>$this->id, "type"=>"classroom"]);
				if($result && $result->rowCount() === 1){
					$this->timetable_id = $result->fetch()['id'];
				}
				return TRUE;
			}else{
				return FLASE;
			}
		}

		// getters
		public function get_id(){return $this->id;}
		public function get_section_id(){return $this->section_id;}
		public function get_grade(){return $this->grade;}
		public function get_class(){return $this->class;}
		public function get_class_teacher_id(){return $this->class_teacher_id;}
		public function get_timetable_id(){return $this->timetable_id;}
		public function get_state(){return $this->state;}

		// get section object which contain section details
		public function get_section_object(){
			$result = $this->con->select("section",array("id"=>$this->section_id));
			if($result && $result->rowCount() == 1){
				return $result->fetch();
			}else{
				return FALSE;
			}
		}

		// get teacher object which contains all class teacher details.
		public function get_class_teacher_object(){
			$result = $this->con->select("teacher",array("id"=>$this->class_teacher_id));
			if($result && $result->rowCount() == 1){
				return  $result->fetch();
			}else{
				return FALSE;
			}	
		}

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

		// get classroom student list array
		public function get_studets_data(){
			$result = $this->con->select("student", array("classroom_id"=>$this->id));
			if($result){
				return $result->fetchAll();
			}else{
				return FALSE;
			}
		}

		//get all classroom data as assosiative array
		public function get_data(){
			$data['id'] = $this->id;
			$data['section_id'] = $this->section_id;
			$data['grade'] = $this->grade;
			$data['class'] = $this->class;
			$data['class_teacher_id'] = $this->class_teacher_id;
			$data['timetable_id'] = $this->timetable_id;
			$data['state'] = $this->state;
			return $data;
		}

		public function __destruct(){
			unset($this->con);
		}
	}

 ?>