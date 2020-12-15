<?php 

	class UserModel extends Model{

		public function __construct() {
			parent::__construct();
		}

		//get data for login.php page
		public function get_user_data($table,$email){
			$email = addslashes($email);
			$result = $this->con->select($table,['email'=>$email]);
			if($result && $result->rowCount() === 1){
				return $result->fetch();
			}else{
				return False;
			}
		}

		//get statics for dashboard
		public function get_staticstic_count(){
			$con = new Database();
			$tables = array("student","teacher","subject","classroom","parent");
			foreach ($tables as $table) {
				$query = "SELECT COUNT(`id`) as count FROM `". $table."`";
				$result_set = $this->con->pure_query($query);
				if($result_set)
					$count[$table] = $result_set->fetch()['count'];
			}
			return $count;
		}

		// get profile data
		public function get_profile_data($id){
			$result = $this->con->select("student",array("id"=>$id));
			if($result->rowCount() == 1){
				return $result->fetch();
			}else{
				return FALSE;
			}
		}

		// update user information
		public function update_user_data($table,$data, $user_id){
			try{
				$this->con->db->beginTransaction();
				$this->con->get(array("email"));
				$result = $this->con->select($table, array("id"=>$user_id));
				if($result && $result->rowCount() == 1){
					$old_email = stripslashes($result->fetch()['email']);
					$result = $this->con->update($table,$data,array("id"=>$user_id));
					if(!$result){
						throw new PDOException("Update failed.",1);
					}
					if($old_email != $data['email']){
						$result =$this->con->update("user", array("email"=>$data['email']), array("email"=>$old_email));
						if(!$result){
							throw new PDOException("Login update failed.",1);
						}
					}
					$this->con->db->commit();
					return 1;
				}else{
					throw new Exception("Cant't find user.", 1);
				}
			}catch( Exception $e){
				$this->con->db->rollback();
				return $e->getMessage();
			}
		}
	}