<?php 
	class StudentModel extends Model{
		// for keep track number of students logged at this time
		public static $num_of_students =0;
		private $id;
		private $name_with_initials;
		private $email;
		private $first_name;
		private $middle_name;
		private $last_name;
		private $grade;
		private $class;
		private $gender;
		private $dob;
		private $address;
		private $contact_number;
		private $profile_photo;
		private $birth_certificate;
		private $nic_photo;
		private $optional_timetable_id;
		private $parent_id;
		private $classroom_id;
		private $state;
		private $is_deleted;
		private $table_name;
		// create database connection
		public function __construct(){
			parent::__construct();
			$this->table = "student";
			$this->state = 0;
		}

		public function set_data($data){
			if( is_array($data)){
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$this->state = 1;
				$c = $this->get_classroom_object();
				if( $c->get_grade() !== NULL){
					$this->grade = $c->get_grade();
				}
				$this->class = $c->get_class();
				unset($c);
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// set data using student id
		public function set_by_id($id){
			$data = $this->con->select($this->table, array("id"=>$id));
			if($data && $data->rowCount() == 1){
				$this->state = 1;
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$c = $this->get_classroom_object();
				if($c){
					if( $c->get_grade() !== NULL){
						$this->grade = $c->get_grade();
					}
					$this->class = $c->get_class();
					unset($c);
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// set data using student email
		public function set_by_email($email){
			$data = $this->con->select($this->table, array("email"=>$email));
			if( $data && $data->rowCount() == 1){
				self::$num_of_students +=1;
				$this->state = 1;
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$c = $this->get_classroom_object();
				if( $c->get_grade() !== NULL){
					$this->grade = $c->get_grade();
				}
				$this->class = $c->get_class();
				unset($c);
				return TRUE;
			}else{
				return FLASE;
			}
		}

		public function get_id(){return $this->id;}
		public function get_name(){return $this->name_with_initials;}
		public function get_first_name(){return $this->first_name;}
		public function get_middle_name(){return $this->middle_name;}
		public function get_last_name(){return $this->last_name;}
		public function get_email(){return $this->email;}
		public function get_contact_number(){return $this->contact_number;}
		public function get_username(){return $this->username;}
		public function get_grade(){return $this->grade;}
		public function get_class(){return $this->class;}
		public function get_gender(){return $this->gender;}
		public function get_address(){return $this->address;}
		public function get_dob(){return $this->dob;}
		public function get_profile_photo(){return $this->profile_photo;}
		public function get_birth_certificate(){return $this->birth_certificate;}
		public function get_nic_photo(){return $this->nic_photo;}
		public function get_optional_timetable_id(){return $this->optional_timetable_id;}
		public function get_parent_id(){return $this->parent_id;}
		public function get_classroom_id(){return $this->classroom_id;}
		public function get_state(){return $this->state;}

		// get parent object which contains parent account details
		public function get_parent_object(){
			$parent = new ParentClass();
			$parent->set_by_id($this->parent_id);
			return $parent;
		}

		//get classroom object which contains classroom details
		public function get_classroom_object(){
			require_once(MODELS."classroom.php");
			$classroom = new ClassroomModel();
			$result = $classroom->set_by_id($this->classroom_id);
			if($result){
				return $classroom;
			}else{
				return FALSE;
			}
		}

		//get timetable object which contains classroom timetable details
		public function get_timetable_object(){
			$timetable = new TimetableClass();
			$timetable->set_by_id($this->timetable_id);
			return $timetable;	
		}
		public function get_data(){
			$data['id'] = $this->id;
			$data['name_with_initials'] = $this->name_with_initials;
			$data['email'] = $this->email;
			$data['first_name'] = $this->first_name;
			$data['middle_name'] = $this->middle_name;
			$data['last_name'] = $this->last_name;
			$data['grade'] = $this->grade;
			$data['class'] = $this->class;
			$data['gender'] = $this->gender;
			$data['dob'] = $this->dob;
			$data['address'] = $this->address;
			$data['contact_number'] = $this->contact_number;
			$data['profile_photo'] = $this->profile_photo;
			$data['birth_certificate'] = $this->birth_certificate;
			$data['nic_photo'] = $this->nic_photo;
			$data['optional_timetable_id'] = $this->optional_timetable_id;
			$data['parent_id'] = $this->parent_id;
			$data['classroom_id'] = $this->classroom_id;
			$data['state'] = $this->state;
			$data['is_deleted'] = $this->is_deleted;
			return $data;
		}
		public function update_data($data){
			$this->con->db->beginTransaction();
			$result = $this->con->update($this->table, $data, array("id"=> $this->id));
			if($result){
				if($result->rowCount() == 1){
					$this->con->db->commit();
					foreach ($data as $key => $value) {
						if($key === "classroom_id"){
							update_classroom_id($value);
						}else{
							$this->$key = $value;
						}
					}
					return 1;
				}else{
					$this->con->db->rollback();
					return 0;
				}
			}else{
				return -1;
			}
		}

		public function update_classroom_id($classroom_id){
			$classroom = new ClassroomClass();
			if($classroom->set_by_id($classroom_id)){
				$grade = $classroom->get_grade();
				$this->con->db->beginTransaction();
				$result = $con->update($this->table, array("grade"=>$grade, "classroom_id"=>$classroom_id), array("id"=>$this->id));
				if($result){
					if($result->rowCount() == 1){
						$this->con->db->commit();
						$this->grade = $grade;
						$this->classroom_id = $classroom_id;
						return 1;
					}else{
						$this->con->db->rollback();
						return 0;
					}
				}else{
					return -1;
				}
			}else{
				return -1;
			}

		}

		public function get_subjects(){
			$query = "SELECT `su`.`name`,`su`.`code`,`t`.`name_with_initials` AS `teacher_name` FROM `tea_sub_student` AS `tss` INNER JOIN `student` AS `s` ON `s`.`id`=`tss`.`student_id` INNER JOIN `teacher_subject` AS `ts` ON `ts`.`id`=`tss`.`teacher_subject_id` INNER JOIN `teacher` AS `t` ON `t`.`id`=`ts`.`teacher_id` INNER JOIN `subject` AS `su` ON `su`.`id`=`ts`.`id` WHERE `s`.`id`=? ";
			return $this->con->pure_query($query, [ $this->id]);

		}

		// delete self. It perform updating is_deleted field. 
		public function delete_self($val=1){
			try {
				$this->con->db->beginTransaction();
				$result = $this->con->update($this->table, array("is_deleted"=>$val), array("id"=>$this->id));
				if(!$result || $result->rowCount()!== 1){
					throw new PDOException();
				}
				$result = $this->con->update("user", array("is_deleted"=>$val), array("email"=>$this->email));
				if(!$result || $result->rowCount()!== 1){
				exit();
					throw new PDOException();
				}
				$this->con->db->commit();
				$this->is_deleted = $val;
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollback();
				return FALSE;
			}
		}

		public function __destruct(){
			unset($this->con);
		}

		public function insert_data($data){
			return $result = $this->con->insert("student",$data);
		}
	}
 ?>