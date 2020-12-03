<?php 

	class UserRole extends Controller {
		public function __construct() {
			parent::__construct();
		}

		// get all user role permissions
		public function permission(){
			$con = new Database();
			$this->load->model("userrole","user_role");
			// get all user roles
			$user_roles = $this->load->userrole->get_user_roles();
			if(!$user_roles){
				echo "user Roles not found.";
				exit();
			}
			// get all models
			$models = $this->load->userrole->get_models();
			if(!$models){
				echo "Models not found.";
				exit();
			}

			// get user role permission
			if(!isset($_POST['user-role-id'])){
				$user_role_id = $user_roles[0]['id'];
			}else{
				$user_role_id = $_POST['user-role-id'];
			}
			$permissions = $this->load->userrole->get_permissions($user_role_id);

			if(!$permissions){
				echo "Permissions not found.";
				exit();
			}

			$data['user_roles'] = $user_roles;
			$data['models'] = $models;
			$data['permissions'] = $permissions;
			$data['user_role_id'] = $user_role_id;
			$this->view_header_and_aside();
			$this->load->view("admin/user_role_all",$data);
			$this->load->view("templates/footer");
		}

		// user permissions update
		public function update_permission(){
			$this->load->model("userrole","user_role");
			$models = $this->load->userrole->get_models();


			$where['user_role_id'] = $_POST['user-role-id'];
			$data = [];
			foreach ($models AS $model) {
				if( array_key_exists("edit-".$model['id'], $_POST) ){
					$data[$model['id']]['edit'] = $_POST["edit-".$model['id']];
				}else{
					$data[$model['id']]['edit'] = 0;
				}

				if( array_key_exists("view-".$model['id'], $_POST) ){
					$data[$model['id']]['view'] = $_POST["view-".$model['id']];
				}else{
					$data[$model['id']]['view'] = 0;
				}

				if( array_key_exists("update-".$model['id'], $_POST) ){
					$data[$model['id']]['update'] = $_POST["update-".$model['id']];
				}else{
					$data[$model['id']]['update'] = 0;
				}

				if( array_key_exists("delete-".$model['id'], $_POST) ){
					$data[$model['id']]['delete'] = $_POST["delete-".$model['id']];
				}else{
					$data[$model['id']]['delete'] = 0;
				}
			}
			// print_r($data);
			// exit();
			$result = $this->load->userrole->update_permissions($data, $where);
			if(!$result){
				echo "permissions update failed.";
				exit();
			}
			$this->permission();
		}

		public function create(){
			$user_role_name = $_POST["user-role-name"];
			$this->load->model("userrole","user_role");
			$result = $this->load->userrole->create_user_role($user_role_name);
			if($result === FALSE){
				echo "User role creation failed.";
				exit();
			}
			$_POST['user-role-id'] = $result;
			$this->permission();
		}
	}
 ?>