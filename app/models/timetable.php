
<?php 

	class TimetableModel extends Model{

		private $id;
		private $type;
		private $user_id;

		// establish database connection
		public function __construct(){
			parent::__construct();
			$this->tables = ["normal_timetable","normal_day"];
		}

		// set timetable using timetable id
		public function set_by_id($id){
			$data = $this->con->select($this->tables[0], array("id"=>$id));
			if($data && $data->rowCount()==1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				return True;
			}else{
				return FALSE;
			}
		}

		// set timetabele using timetable type and user_id
		public function set_by_user_id($user_id,$type){
			$data = $this->con->select($this->tables[0], array("user_id"=>$user_id, "type"=>$type));
			if($data && $data->rowCount()==1){
				$data = $data->fetch();
				foreach ($data as $key => $value) {
					$this->$key = $value;
				}
				return True;
			}else{
				return FALSE;
			}
		}
		//getters
		public function get_id(){ return $this->id;}
		public function get_type(){ return $this->type;}
		public function get_user_id(){ return $this->user_id;}

		
		// get timetable owner data object
		public function get_user_data(){
			try{
				require_once(realpath( dirname( __FILE__)) .  "/".$this->type.".class.php");
				$user = new ucfirst($this->type)."Class"();
				$user->set_by_id($this->user_id);
				if($user->get_state() == 1){
					return $user;
				}else{
					return FALSE;
				}
			}catch(Exception $e){
				return FALSE;
			}
		}

		// get complete timetable as assosoative array
		public function get_timetable(){
			$result_set = $this->con->select($this->tables[1], array("timetable_id"=>$this->id));
			$timetable = array("mon"=>[], "tue"=>[],"wed"=>[],"thu"=>[],"fri"=>[]);
			if($result_set && $result_set->rowCount() == 40){
				$result_set = $result_set->fetchAll();
				foreach ($result_set as $result) {
					$timetable[$result['day']][$result['period']] = $result['task'];
				}
				return $timetable;
			}else{
				return FALSE;
			}
		}

		// create new timetable
		public function create($user_id,$type){
			$days = ['mon', "tue" , "wed", "thu", "fri"];	
			try{
				$this->con->db->beginTransaction();
				$result = $this->con->insert("normal_timetable",array("user_id"=>$user_id,"type"=>$type));
				if(!$result){
					throw new PDOException("Timetable Creation failed.", 1);
				}
				$this->con->get(['id']);
				$result = $this->con->select("normal_timetable",array("user_id"=>$user_id,"type"=>$type));
				if(!$result || $result->rowCount() !== 1 ){
					throw new PDOException("Timetable Creation failed.", 1);
				}
				$timetable_id = $result->fetch()['id'];


				$data = [];
				$data['timetable_id'] = $timetable_id;
				foreach ($days as $day) {
					for($i=1; $i <9; $i++){
						$data['day'] = $day;
						$data['period'] = $i;
						$data['task'] = 0;
						$result = $this->con->insert("normal_day",$data);
						if(!$result && $result->rowCount() !== 1){
							throw new PDOException("Timetable data store failed.",1);
						}
					}
				}
				$this->con->db->commit();
				$this->set_by_id($timetable_id);
				return TRUE;
			}catch (PDOException $e){
				$this->con->db->rollBack();
				return FALSE;
			}
		}

		// update timetable
		public function update_timetable(){
			$days = ['mon', "tue" , "wed", "thu", "fri"];
			try{
				$this->con->db->beginTransaction();

				foreach ($days as $day) {
					for($i=1; $i <9; $i++){
						$data = [];
						if($_POST[$day."-".$i] == 0){
							$data['task'] = 0;
						}else{
							$data['task'] = 1;
						}
						$result = $this->con->update("normal_day",$data,array("timetable_id"=>$this->id,"day"=>$day,"period"=>$i));
						if(!$result && $result->rowCount() != 1){
							throw new PDOException("Timetable Update failed.",1);
						}
					}
				}
				$this->con->db->commit();
				return TRUE;
			}catch (PDOException $e){
				$this->con->db->rollBack();
				return FALSE;
			}
		}

	}
 ?>