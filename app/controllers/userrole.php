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
				$permissions = $this->load->userrole->get_permissions($user_roles[0]['id']);
			}else{
				$permissions = $this->load->userrole->get_permissions($_POST['user-role-id']);
			}

			if(!$permissions){
				echo "Permissions not found.";
				exit();
			}

			$data['user_roles'] = $user_roles;
			$data['models'] = $models;
			$data['permissions'] = $permissions;

			$this->view_header_and_aside();
			$this->load->view("admin/user_role_all",$data);
			$this->load->view("templates/footer");
		}

		// user permissions update
		public function update(){

		}
	}
 ?>