<?php 

	class UserRoleModel extends Model{
		public function __construct(){
			parent::__construct();
		}

		// get all user roles
		public function get_user_roles(){
			$result_set = $this->con->select("user_role");
			if(!$result_set){
				return FALSE;
			}
			return $result_set->fetchAll();
		}

		// get all models
		public function get_models(){
			$result_set = $this->con->select("model");
			if(!$result_set){
				return FALSE;
			}
			return $result_set->fetchAll();
		}

		// get user permissions
		public function get_permissions( $user_role_id ){
			$query = "SELECT `p`.*,`ur`.`name` AS `user_role_name`,`m`.`name` AS `model_name`  FROM `permission` AS `p` JOIN `user_role` AS `ur` ON `p`.`user_role_id`=`ur`.`id` JOIN `model` AS `m` ON `p`.`model_id`=`m`.`id` WHERE `p`.`user_role_id`=$user_role_id";
			$result_set = $this->con->pure_query($query);
			if(!$result_set){
				return FALSE;
			}
			return $result_set->fetchAll();

		}
	}

 ?>