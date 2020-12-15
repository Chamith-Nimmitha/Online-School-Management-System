
<?php 
	class SubjectInfoModel extends Model{
		private $id;
		private $name;
		private $grade;
		private $medium;
		private $code;
		private $class_teacher_id;
		private $description;
		private $state;
						 private $idd=array();
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

		// set data using teacher_id
		public function set_by_teacher_id($teacher_id){
				$subjects = array();
				$result_set = $this->con->select("teacher_subject",array("teacher_id"=>$teacher_id));
				if($result_set && $result_set->rowCount() >=1){
					$teacher_subject = $result_set->fetchAll();
						foreach ($teacher_subject as $result) {
							$result =$this->con->select("subject",array("id"=>$result['subject_id']));
							if($result && $result->rowCount() == 1){
								array_push($subjects, $result->fetch());
							}
						}
						foreach ($subjects as $subject) {
							foreach ($subject as $key => $value) {
								$this->$key = $value;
							}
						}
										

				return $subjects;
			}else{
				return FALSE;
			}
		}

		// getters
		public function get_id(){return $this->id;}
		public function get_name(){return $this->section_id;}
		public function get_grade(){return $this->grade;}
		public function get_medium(){return $this->medium;}
		public function get_code(){return $this->code;}
		public function get_class_teacher_id(){return $this->class_teacher_id;}
		public function get_description(){return $this->description;}
		public function get_state(){return $this->state;}

		// get section data
		public function get_section_data(){
			$result = $this->con->select("section",array("id"=>$this->section_id));
			if($result && $result->rowCount() == 1){
				return $result->fetch();
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


		//get all classroom data as assosiative array
		public function get_data(){
			$data['id'] = $this->id;
			$data['name'] = $this->name;
			$data['grade'] = $this->grade;
			$data['medium'] = $this->medium;
			$data['code'] = $this->code;
			$data['class_teacher_id'] = $this->class_teacher_id;
			$data['description'] = $this->description;
			$data['state'] = $this->state;
			return $data;
		}

		public function __destruct(){
			unset($this->con);
		}
	}

 ?>