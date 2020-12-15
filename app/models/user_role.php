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

		// create userrole{
		public function create_user_role($user_role_name){
			$models = $this->get_models();

			try {
				$this->con->db->beginTransaction();
				$result = $this->con->select("user_role",['name'=>$user_role_name]);
				if(!$result || $result->rowCount() !== 0 ){
					throw new PDOException();
				}
				$result = $this->con->insert("user_role",['name'=>$user_role_name]);
				if(!$result || $result->rowCount() !== 1){
					throw new PDOException();
				}
				$result = $this->con->select("user_role",['name'=>$user_role_name]);
				if(!$result || $result->rowCount() !== 1 ){
					throw new PDOException();
				}
				$user_role_id = $result->fetch()['id'];

				foreach ($models as $model) {
					$result = $this->con->insert("permission",["user_role_id"=>$user_role_id,"model_id"=>$model['id']]);
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException();
					}
				}
				$this->con->db->commit();
				return $user_role_id;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}

			
		}

		// get user permissions using user role id
		public function get_permissions_by_id( $user_role_id ){
			$query = "SELECT `p`.*,`ur`.`name` AS `user_role_name`,`m`.`name` AS `model_name`  FROM `permission` AS `p` JOIN `user_role` AS `ur` ON `p`.`user_role_id`=`ur`.`id` JOIN `model` AS `m` ON `p`.`model_id`=`m`.`id` WHERE `p`.`user_role_id`=$user_role_id";
			$result_set = $this->con->pure_query($query);
			if(!$result_set){
				return FALSE;
			}
			return $result_set->fetchAll();

		}

		// get user permissions using user role name
		public function get_permissions_by_name( $user_role_name ){
			$query = "SELECT `p`.*,`ur`.`name` AS `user_role_name`,`m`.`name` AS `model_name`  FROM `permission` AS `p` JOIN `user_role` AS `ur` ON `p`.`user_role_id`=`ur`.`id` JOIN `model` AS `m` ON `p`.`model_id`=`m`.`id` WHERE `ur`.`name`='$user_role_name'";
			$result_set = $this->con->pure_query($query);
			if(!$result_set){
				return FALSE;
			}
			$result_set = $result_set->fetchAll();
			$data = [];
			foreach ($result_set as $result) {
				$data[$result['model_name']] = $result;
			}
			return $data;
		}

		// update user permissions
		public function update_permissions($data, $where){
			try {
				$this->con->db->beginTransaction();
				foreach ($data as $model_id => $permissions) {
					$where['model_id'] = $model_id;
					$result = $this->con->update("permission",$permissions,$where);
					if(!$result){
						throw new PDOException("Update failed", 1);
					}
				}
				$this->con->db->commit();
				return TRUE;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}
		}

		// delete userrole
		public function delete_userrole($user_role_id){
			$this->con->get(["name"]);
			$userrole_name = $this->con->select("user_role",["id"=>$user_role_id]);
			$result = $this->con->delete("user_role",["id"=>$user_role_id]);
			if($result && ($userrole_name && $userrole_name->rowCount() === 1 )){
				return $userrole_name->fetch()['name'];
			}else{
				return FALSE;
			}
		}

		// Create new model
		public function create_model($model_name){
			$user_roles = $this->get_user_roles();

			try {
				$this->con->db->beginTransaction();
				$result = $this->con->select("model",['name'=>$model_name]);
				if(!$result || $result->rowCount() !== 0 ){
					throw new PDOException();
				}
				$result = $this->con->insert("model",['name'=>$model_name]);
				if(!$result || $result->rowCount() !== 1){
					throw new PDOException();
				}
				$result = $this->con->select("model",['name'=>$model_name]);
				if(!$result || $result->rowCount() !== 1 ){
					throw new PDOException();
				}
				$model_id = $result->fetch()['id'];

				foreach ($user_roles as $user_role) {
					$result = $this->con->insert("permission",["user_role_id"=>$user_role['id'],"model_id"=>$model_id]);
					if(!$result || $result->rowCount() !== 1){
						throw new PDOException();
					}
				}
				$this->con->db->commit();
				return TRUE;;
			} catch (Exception $e) {
				$this->con->db->rollBack();
				return FALSE;
			}
		}
	}
 ?>