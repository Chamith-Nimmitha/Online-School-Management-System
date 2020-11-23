<?php 

	class UserModel extends Model{

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
	}