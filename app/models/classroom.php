
<?php 
	class ClassroomModel extends Model{
		private $id;
		private $section_id;
		private $grade;
		private $class;
		private $category;
		private $class_teacher_id;
		private $timetable_id;
		private $description;
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

		// set dat using grade and class
		public function set_by_grade_class($grade,$class){
			$query = "SELECT `c`.`id` AS `id` FROM `classroom` AS `c` INNER JOIN `section` AS `s` ON `s`.`id`=`c`.`section_id` WHERE `s`.`grade`= ? && `c`.`class`=? ";
			$result = $this->con->pure_query($query, [$grade, "{$class}"]);
			if($result){
				return $this->set_by_id($result->fetch()['id']);
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
				$result = $this->con->select("section",array("id"=>$this->section_id));
				if($result && $result->rowCount() == 1){
					$this->state = 1;
					$result = $result->fetch();
					$this->grade = $result['grade'];
					$this->category = $result['category'];
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
				$result = $this->con->select("section",array("id"=>$this->section_id));
				if($result && $result->rowCount() == 1){
					$this->state = 1;
					$this->grade = $result->fetch()['grade'];
					$this->category = $result['category'];
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
		public function get_category(){return $this->category;}
		public function get_class_teacher_id(){return $this->class_teacher_id;}
		public function get_timetable_id(){return $this->timetable_id;}
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

		// get teacher data
		public function get_class_teacher_data(){
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
		//get converted timetable
		public function get_converted_timetable(){
			require_once(MODELS."timetable.php");
			$tt = new TimetableModel();
			$result = $tt->set_by_id($this->timetable_id);
			if($result){
				$timetable = $tt->get_timetable();
				try {
					$this->con->db->beginTransaction();
					foreach ($timetable as $day => $periods) {
						foreach ($periods as $period => $task) {
							if($task != "FREE"){
								$exp = explode("--", $task);
								if($exp[0] == "OP"){
									$timetable["{$day}"]["{$period}"] = $exp[1];
								}else{
									$this->con->get(["name"]);
									$result = $this->con->select("subject",["id"=>$exp[1]]);
									if(!$result || $result->rowCount() !== 1){
										throw new PDOException();
									}
									$timetable["{$day}"]["{$period}"] = $result->fetch()['name'];
								}
							}
						}
					}
					$this->con->db->commit();
					return $timetable;
				} catch (Exception $e) {
					$this->con->db->rollBack();
					return FALSE;
				}
			}else{
				return FALSE;
			}		
		}

		// get student count
		public function get_student_count(){
			$query = "SELECT COUNT(*) AS `count` FROM `student` WHERE `classroom_id`= ? ";
			return $this->con->pure_query($query,[$this->id]);
		}

		// get classroom student list array
		public function get_students_data($filters=""){
			if(!empty($filters)){
				$this->con->get($filters);
			}
			$this->con->orderBy("id");
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
			$data['category'] = $this->category;
			$data['class_teacher_id'] = $this->class_teacher_id;
			$data['timetable_id'] = $this->timetable_id;
			$data['description'] = $this->description;
			$data['state'] = $this->state;
			return $data;
		}

		// get classroom general subject list
		public function get_general_subjects(){
			$query = "SELECT `s`.`id`,`s`.`name`,`s`.`medium`,`s`.`code`,`cs`.`periods`,`cs`.`teacher_id` FROM `class_subject` AS `cs` INNER JOIN `subject` AS `s` ON `s`.`id`=`cs`.`subject_id` LEFT JOIN `teacher` AS `t` ON `cs`.`teacher_id`=`t`.`id` WHERE `cs`.`classroom_id`=? AND `s`.`type`='General' ;";
			$result = $this->con->pure_query($query,[$this->id]);
			if($result){
				return $result->fetchAll();
			}else{
				return FALSE;
			}
		}

		// get classroom optional subject list
		public function get_optional_subjects(){
			$query = "SELECT  CAST(SUM(`cs`.`periods`)/COUNT(*) AS int) AS `periods`, `s`.`category` FROM `class_subject` AS `cs` INNER JOIN `subject` AS `s` ON `s`.`id`=`cs`.`subject_id` WHERE `cs`.`classroom_id`=? AND `s`.`type`='Optional' GROUP BY(`s`.`category`) ORDER BY(`s`.`category`);";
			$result = $this->con->pure_query($query,[$this->id]);
			if($result){
				return $result->fetchAll();
			}else{
				return FALSE;
			}
		}

		// get classroom other subject list
		public function get_other_subjects(){
			$query = "SELECT `s`.`id`,`s`.`name`,`s`.`medium`,`s`.`code`,`cs`.`periods` FROM `class_subject` AS `cs` INNER JOIN `subject` AS `s` ON `s`.`id`=`cs`.`subject_id` WHERE `cs`.`classroom_id`=? AND `s`.`type`='Other' ;";
			$result = $this->con->pure_query($query,[$this->id]);
			if($result){
				return $result->fetchAll();
			}else{
				return FALSE;
			}
		}

		// update classroom subjects
		public function update_subjects($subjects){
			try {
				$this->con->db->beginTransaction();
				// get old all classroom general subjects
				$gen_sub = $this->get_general_subjects();
				if($gen_sub === FALSE){
					throw new PDOException();
				}
				// update general subjects
				if(!empty($subjects['General'])){
					foreach ($subjects['General'] as $subject) {
						$result = $this->con->insert("class_subject",["classroom_id"=>$this->id,"subject_id"=>$subject['id'], "periods"=>$subject['periods']]);
						if(!$result){
							throw new PDOException();
						}
						if($result->rowCount() === 0){
							$result = $this->con->update("class_subject",["periods"=>$subject['periods']], ["classroom_id"=>$this->id,"subject_id"=>$subject['id']]);
							if(!$result){
								throw new PDOException();
							}
							$tmp = [];
							for ($i=0; $i < count($gen_sub) ; $i++) { 
								if($subject['id']!=$gen_sub[$i]['id']){
									array_push($tmp, $gen_sub[$i]);
								}
							}
							$gen_sub = $tmp;
						}
					}
					if(count($gen_sub) !== 0){
						foreach ($gen_sub as $id) {
							$result = $this->con->delete("class_subject", ["classroom_id"=>$this->id, "subject_id"=>$id['id']]);
							if(!$result){
								throw new PDOException();
							}
						}
					}
				}
				

				// get old all classroom optional categories
				$op_sub = $this->get_optional_subjects();
				if($op_sub === FALSE){
					throw new PDOException();
				}
				// update Optional subjects
				if(!empty($subjects['Optional'])){
					foreach ($subjects['Optional'] as $subject) {
						$this->con->get(['id']);
						$result = $this->con->select("subject",["category"=>$subject['category'],"grade"=>$this->grade]);
						if(!$result){
							throw new PDOException();
						}
						foreach ($result->fetchAll() as $sub) {
							$result = $this->con->insert("class_subject",["classroom_id"=>$this->id,"subject_id"=>$sub['id'], "periods"=>$subject['periods']]);
							if(!$result){
								throw new PDOException();
							}
							if($result->rowCount() === 0){
								$result = $this->con->update("class_subject",["periods"=>$subject['periods']], ["classroom_id"=>$this->id,"subject_id"=>$sub['id']]);
								if(!$result){
									throw new PDOException();
								}
								$tmp = [];
								for ($i=0; $i < count($op_sub) ; $i++) { 
									if($subject['category']!=$op_sub[$i]['category']){
										array_push($tmp, $op_sub[$i]);
									}
								}
								$op_sub = $tmp;
							}
						}
					}
					if(count($op_sub) !== 0){
						foreach ($op_sub as $id) {
							$this->con->get(['id']);
							$result = $this->con->select("subject",["category"=>$id['category'],"grade"=>$this->grade]);
							if(!$result){
								throw new PDOException();
							}
							foreach ($result->fetchAll() as $sub) {
								$result = $this->con->delete("class_subject", ["classroom_id"=>$this->id, "subject_id"=>$sub['id']]);
								if(!$result){
									throw new PDOException();
								}
							}
						}
					}
				}

				// get old all classroom other subjects
				$ot_sub = $this->get_other_subjects();
				if($ot_sub === FALSE){
					throw new PDOException();
				}
				// update general subjects
				if(!empty($subjects['Other'])){
					foreach ($subjects['Other'] as $subject) {
						$result = $this->con->insert("class_subject",["classroom_id"=>$this->id,"subject_id"=>$subject['id'], "periods"=>$subject['periods']]);
						if(!$result){
							throw new PDOException();
						}
						if($result->rowCount() === 0){
							$result = $this->con->update("class_subject",["periods"=>$subject['periods']], ["classroom_id"=>$this->id,"subject_id"=>$subject['id']]);
							if(!$result){
								throw new PDOException();
							}
							$tmp = [];
							for ($i=0; $i < count($ot_sub) ; $i++) { 
								if($subject['id']!=$ot_sub[$i]['id']){
									array_push($tmp, $ot_sub[$i]);
								}
							}
							$ot_sub = $tmp;
						}
					}
					if(count($ot_sub) !== 0){
						foreach ($ot_sub as $id) {
							$result = $this->con->delete("class_subject", ["classroom_id"=>$this->id, "subject_id"=>$id['id']]);
							if(!$result){
								throw new PDOException();
							}
						}
					}
				}

				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}
		}

		// register new classroom
		public function register($data){
			$result = $this->con->select("classroom",["section_id"=>$data['section_id'],"class"=>$data['class']]);
			if(!$result || $result->rowCount() !== 0){
				return FALSE;
			}
			$result = $this->con->insert("classroom",$data);
			if($result && $result->rowCount() === 1){
				$this->con->get(['id']);
				$result = $this->con->select("classroom",$data);
				if($result && $result->rowCount() === 1){
					return $this->set_by_id($result->fetch()['id']);
				}else{
					return FALSE;
				}
			}else{
				return FALSE;
			}
		}

		// update existing classroom
		public function update_classroom($data){
			$result = $this->con->update("classroom",$data,['id'=>$this->id]);
			if($result){
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// get classroom notices
		public function get_notices(){
			$query = "SELECT * FROM `classroom_notice` WHERE `classroom_id`={$this->id} && (`expire` = NULL OR `expire` > '".date("Y-m-d")."')";
			return $this->con->pure_query($query);
		}

		// add new notice
		public function add_notice($data,$file=NULL){

			try {
				$this->con->db->beginTransaction();

				$result = $this->con->insert("classroom_notice",$data);

				if(!$result || $result->rowCount() != 1){
					throw new Exception();
				}
				$this->con->get(['id']);
				$result = $this->con->select("classroom_notice",$data);
				$notice_id = $result->fetch()['id'];

				if(!$result || $result->rowCount() != 1){
					throw new Exception();
				}

				if($file !== NULL){
					$target = BASEPATH."public/assets/img/classroom_notice/";
					$rename = $notice_id;
					$data['image'] = $rename . "." .strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					$res = upload_file($file,$target, 2000000, $rename);
					if($res !== 1){
						throw new Exception();
					}
					$result = $this->con->update("classroom_notice",["image"=>$data['image']],["id"=>$notice_id]);
					if(!$result || $result->rowCount() != 1){
						throw new Exception();
					}
				}
				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}

		}

		// get a ntice
		public function get_notice($notice_id){
			return $this->con->select("classroom_notice",["id"=>$notice_id]);
		}

		// update new notice
		public function update_notice($notice_id,$data,$file=NULL){

			try {
				$this->con->db->beginTransaction();
				$query = "UPDATE `classroom_notice` SET `title`=?, `description`=?, `expire`=? ";
				$params= [$data['title'],$data['description'],$data['expire']];
				if($data['image']!=NULL){
					$query .= ",`image`=? ";
					array_push($params,$data['image']);
				}else{
					$query .= ",`image`= NULL ";
				}
				$query .= "WHERE `id`=?";
				array_push($params,$notice_id);
				$result = $this->con->pure_query($query,$params);

				if(!$result){
					throw new Exception();
				}

				if($file !== NULL){
					$target = BASEPATH."public/assets/img/classroom_notice/";
					$rename = $notice_id;
					$data['image'] = $rename . "." .strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
					$res = upload_file($file,$target, 2000000, $rename);
					if($res !== 1){
						throw new Exception();
					}
					$result = $this->con->update("classroom_notice",["image"=>$data['image']],["id"=>$notice_id]);
					if(!$result || $result->rowCount() != 1){
						throw new Exception();
					}
				}
				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}

		}

		// delete a existing notice
		public function delete_notice($notice_id){
			$result = $this->con->delete("classroom_notice",["id"=>$notice_id]);
			if($result && $result->rowCount()==1){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		// delete a classroom
		public function delete_classroom($id){
			return $this->con->delete("classroom",["id"=>$id]);
		}
		
		public function __destruct(){
			unset($this->con);
		}
	}

 ?>