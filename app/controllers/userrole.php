<?php 

	class UserRole extends Controller {
		public function __construct() {
			parent::__construct();
		}

		// get all user role permissions
		// and delete userrole
		public function permission($info=NULL, $error=NULL){
			if(!$this->checkPermission->check_permission("permission","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("userrole","user_role");

			// delete user role
			if(isset($_POST['delete'])){
				if(!$this->checkPermission->check_permission("permission","delete")){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}
				$user_role_id = $_POST['user-role-id'];
				unset($_POST['user-role-id']);
				$result = $this->load->userrole->delete_userrole($user_role_id);
				if($result){
					$info = "User Role $result is deleted.";
				}else{
					$error = "User Role deletetion failed.";
				}
			}

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
			$permissions = $this->load->userrole->get_permissions_by_id($user_role_id);

			if(!$permissions){
				echo "Permissions not found.";
				exit();
			}

			$data['user_roles'] = $user_roles;
			$data['models'] = $models;
			$data['permissions'] = $permissions;
			$data['user_role_id'] = $user_role_id;
			$data['info'] = $info;
			$data['error'] = $error;
			$this->view_header_and_aside();
			$this->load->view("admin/user_role_all",$data);
			$this->load->view("templates/footer");
		}

		// user permissions update
		public function update_permission(){
			if(!$this->checkPermission->check_permission("permission","update")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("userrole","user_role");
			$models = $this->load->userrole->get_models();

			$where['user_role_id'] = $_POST['user-role-id'];
			$data = [];
			foreach ($models AS $model) {
				if( array_key_exists("create-".$model['id'], $_POST) ){
					$data[$model['id']]['create'] = $_POST["create-".$model['id']];
				}else{
					$data[$model['id']]['create'] = 0;
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

			$result = $this->load->userrole->update_permissions($data, $where);
			if(!$result){
				echo "permissions update failed.";
				exit();
			}
			$_SESSION["permissions"] = $this->load->userrole->get_permissions_by_name($_SESSION['role']);
			$info = "Update successful.";
			$this->permission($info);
		}

		// create new user role
		public function create(){
			if(!$this->checkPermission->check_permission("permission","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$info = "";
			$error = "";
			$user_role_name = $_POST["user-role-name"];
			$this->load->model("userrole","user_role");
			$result = $this->load->userrole->create_user_role($user_role_name);
			if($result === FALSE){
				$error = "User role creation failed.";
			}else{
				$info = "User Role creation successful.";
			}
			$_POST['user-role-id'] = $result;
			$this->permission($info,$error);
		}

		// create new model
		public function model_create(){
			if(!$this->checkPermission->check_permission("permission","create")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$info = NULL;
			$error = NULL;
			if(isset($_POST['create'])){
				$this->load->model("userrole","user_role");
				$model_name = $_POST['model-name'];
				$result = $this->load->userrole->create_model($model_name);

				if($result){
					$info = "Model creation successful";
				}else{
					$error = "Model creation failed.";
				}

				$this->permission($info,$error);

			}
		}
	}
 ?>