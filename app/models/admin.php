<?php 

	class AdminModel extends Model{
		private $id;
		private $name_with_initials;
		private $username;
		private $gender;
		private $email;
		private $contact_number;
		private $address;
		private $profile_photo;
		private $is_deleted;
		private $table_name;

		public function __construct() {
			parent::__construct();
			$this->table = "admin";
		}

		// set data using admin id
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

		// set data using admin email
		public function set_by_email($email){
			$data = $this->con->select($this->table, array("email"=>$email));
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

		public function get_id(){return $this->id;}
		public function get_name(){return $this->name_with_initials;}
		public function get_username(){return $this->username;}
		public function get_gender(){return $this->gender;}
		public function get_email(){return $this->email;}
		public function get_contact_number(){return $this->contact_number;}
		public function get_address(){return $this->address;}
		public function get_profile_photo(){return $this->profile_photo;}

		public function get_data(){
			$data['id'] = $this->id;
			$data['name_with_initials'] = $this->name_with_initials;
			$data['username'] = $this->username;
			$data['email'] = $this->email;
			$data['gender'] = $this->gender;
			$data['address'] = $this->address;
			$data['contact_number'] = $this->contact_number;
			$data['profile_photo'] = $this->profile_photo;
			return $data;
		}
	}