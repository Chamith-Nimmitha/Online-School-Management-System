
<?php 
	class ParentModel extends Model{
		//for keep track of how many parents are logged in.
		public static $num_of_parents = 0;
		private $id;
		private $name;
		private $occupation;
		private $address;
		private $contact_number;
		private $email;
		private $profile_id;
		private $state;
		// set basic database info
		public function __construct(){
			parent::__construct();
			$this->table = "parent";
			$this->state = 0;
		}

		//set data using assosiative array
		public function set_data($data){
			if(is_array($data)){
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				$this->state = 1;
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// set data using parent id
		public function set_by_id($id){
			$data = $this->con->select($this->table,array("id"=>$id));
			if($data && $data->rowCount() === 1){
				self::$num_of_parents +=1;
				$this->state = 1;
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}

		//set data using parent email
		public function set_by_email($email){
			$data = $this->con->select($this->table,array("email"=>$email));
			if($data && $data->rowCount() === 1){
				self::$num_of_parents +=1;
				$this->state = 1;
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}

		// get parent data
		public function get_id(){return $this->id;}
		public function get_name(){return $this->name;}
		public function get_email(){return $this->email;}
		public function get_occupation(){return $this->occupation;}
		public function get_contact_number(){return $this->contact_number;}
		public function get_profile_photo(){return $this->profile_photo;}
		public function get_state(){return $this->state;}


		public function get_data(){
			$data["id"] = $this->id;
			$data["name"] = $this->name;
			$data["occupation"] = $this->occupation;
			$data["address"] = $this->address;
			$data["contact_number"] = $this->contact_number;
			$data["email"] = $this->email;
			$data["profile_id"] = $this->profile_id;
			$data["state"] = $this->state;
			return $data;
		}


		// unset database connection and reduce parent count
		public function __destruct(){
			unset($this->con);
			if(isset($this->id)){
				self::$num_of_parents -=1;
			}
		}
	}
	function create_self(){
		return new ParentModel();
	}
 ?>