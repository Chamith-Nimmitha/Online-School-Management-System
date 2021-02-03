<?php

	class User extends Controller {

		public function __construct() {
			parent::__construct();
		}

		// login user
		public function login($info=""){
			$errors = array();  
			$message="";
			if(isset($_POST['submit'])) {
				$email = $_POST["email"];
				$user_password = $_POST["password"];
				$info = "";

				$this->load->model("user");
				$result = $this->load->user->get_user_data("user",$email);

				if($result){
					$salt =$result['salt'];
					$db_hashed_pass =$result['password'];
					$user_hashed_pass = sha1($user_password.$salt);

					if($db_hashed_pass !== $user_hashed_pass){
						$message ="Invalid email or password";
					}
					else{
						if(!empty($_POST["remember-me"])) {
							setcookie ("email",$_POST["email"],time()+ 3600);
							setcookie ("password",$_POST["password"],time()+ 3600);
						} 
						else {
							setcookie("email","");
							setcookie("password","");
						}
						$_SESSION["role"]=$result['role'];
						$_SESSION['loggedin'] = true;
						$this->load->model("userrole","user_role");
						$_SESSION["permissions"] = $this->load->userrole->	get_permissions_by_name($_SESSION['role']);
						if($_SESSION["role"]==="student"){
							$user = $this->load->user->get_user_data("student",$email);
							$_SESSION["user_id"]=$user['id'];
							$_SESSION["username"]=$user['first_name'];
							$_SESSION["profile_photo"]=$user['profile_photo'];
						}else if($_SESSION["role"]==="teacher"){
							$user = $this->load->user->get_user_data("teacher",$email);
							$_SESSION["user_id"]=$user['id'];
							$_SESSION["username"]=$user['name_with_initials'];
							$_SESSION["profile_photo"]=$user['profile_photo'];
						}else if($_SESSION["role"]==="parent"){
							$user = $this->load->user->get_user_data("parent",$email);
							$_SESSION["user_id"]=$user['id'];
							$_SESSION["username"]=$user['name'];
							$_SESSION["profile_photo"]=$user['profile_photo'];
						}else if($_SESSION["role"]==="admin"){
							$user = $this->load->user->get_user_data("admin",$email);
							$_SESSION["user_id"]=$user['id'];
							$_SESSION["username"]=$user['username'];
							$_SESSION["profile_photo"]=$user['profile_photo'];
						}
						header('Location:'.set_url("dashboard/Login Successful"));
					}
				}else{
					$message ="Invalid email or password";
				}
			}
			$this->view_header_and_aside();
			$data['message'] = $message;
			$data['info'] = $info;

			$this->load->view("common/login",$data);
			$this->load->view("templates/footer");
		}

		//view dashboard for all users
		public function dashboard($msg=""){
			if(!$this->checkPermission->check_permission("dashboard","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			$this->load->model("user");
			$counts = $this->load->user->get_staticstic_count();
			$data['count'] = $counts;
			$data['msg'] = $msg;

			if($_SESSION['role'] == "teacher"){
				$this->load->model("teacher");
				$this->load->teacher->set_by_id($_SESSION['user_id']);
				$cls = $this->load->teacher->get_classroom_object();
				if($cls){
					$data['notice_classroom_id'] = $cls->get_id();
					$result = $cls->get_notices();
					if($result){
						$data['classroom_notices'] = $result->fetchAll();
					}
				}
				
			}
			$this->view_header_and_aside();
			$data['header'] = $this->header;
			$this->load->view("common/dashboard", $data);
			$this->load->view("templates/footer");
		}

		// user can  edit,view own profile
		// admin can edit,view all profiles
		public function profile($role="",$teacher_id=""){
			if(!$this->checkPermission->check_permission("profile","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			if( empty($teacher_id)){
				$teacher_id = $_SESSION['user_id'];
				$role = $_SESSION['role'];
			}
			if($_SESSION['role'] === "admin"){
				$is_admin = TRUE;
			}else{
				$is_admin = FALSE;
			}
			if(empty($role) || $is_admin || $role == $_SESSION['role']){
				$editable = TRUE;
			}else{
				$editable = FALSE;
			}
			$this->load->model($role);
			$result = $this->load->{$role}->set_by_id($teacher_id);
			if(!$result){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;	
			}
			$field_errors = [];

			// if user update profile
			if(isset($_POST['submit'])){
				if(!$this->checkPermission->check_permission("profile","update") || ( !$is_admin &&  ($_SESSION['user_id'] != $teacher_id))){
					$this->view_header_and_aside();
					$this->load->view("common/error");
					$this->load->view("templates/footer");
					return;
				}
				switch ($role) {
					case 'student':
						if(isset($_POST['submit'])){
							if($_SESSION['role'] === "admin"){
								$data['name_with_initials'] = addslashes($_POST['name-with-initials']);
								$data['first_name'] = addslashes($_POST['first-name']);
								$data['middle_name'] = addslashes($_POST['middle-name']);
								$data['last_name'] = addslashes($_POST['last-name']);
								$data['grade'] = addslashes($_POST['grade']);
								$data['gender'] = addslashes($_POST['gender']);
								$required_fields["name-with-initials"]=[0,50,1,"Name with intials"];
								$required_fields["first-name"]=[0,20,1,"First Name"];
								$required_fields["middle-name"]=[0,50,0,"Middle Name"];
								$required_fields["last-name"]=[0,50,1,"Last Name"];
							}
							$data['address'] = addslashes($_POST['address']);
							$data['email'] = addslashes($_POST['email']);
							$data['contact_number'] = $_POST['contact-number'];

							$required_fields = array(
								"address"=>[0,100,1,"Address"],
								"email"=>[0,100,1,"Email"]
							);
							$field_errors =check_input_fields($required_fields);
							$c_result = validate_contact_number($_POST['contact-number']);
							if($c_result !== 1){
								$field_errors['contact-number'] = $c_result;
							}
						}
						break;		
					case 'teacher':
						if(isset($_POST['submit'])){
							if($_SESSION['role'] === "admin"){
								$data['name_with_initials'] = addslashes($_POST['name-with-initials']);
								$data['first_name'] = addslashes($_POST['first-name']);
								$data['middle_name'] = addslashes($_POST['middle-name']);
								$data['last_name'] = addslashes($_POST['last-name']);
								$data['gender'] = addslashes($_POST['gender']);
								$required_fields["name-with-initials"]=[0,50,1,"Name with intials"];
								$required_fields["first-name"]=[0,20,1,"First Name"];
								$required_fields["middle-name"]=[0,50,0,"Middle Name"];
								$required_fields["last-name"]=[0,50,1,"Last Name"];
							}
							$data['address'] = addslashes($_POST['address']);
							$data['email'] = addslashes($_POST['email']);
							$data['contact_number'] = $_POST['contact-number'];

							$required_fields = array(
								"address"=>[0,100,1,"Address"],
								"email"=>[0,100,1,"Email"],
							);
							$field_errors =check_input_fields($required_fields);
							$c_result = validate_contact_number($_POST['contact-number']);
							if($c_result !== 1){
								$field_errors['contact-number'] = $c_result;
							}
						}
						break;
					case 'admin':
						if(isset($_POST['submit'])){
							$data['username'] = addslashes($_POST['username']);
							$data['address'] = addslashes($_POST['address']);
							$data['email'] = addslashes($_POST['email']);
							$data['contact_number'] = $_POST['contact-number'];

							$required_fields = array(
								"address"=>[0,20,1,"username"],
								"address"=>[0,100,1,"Address"],
								"email"=>[0,100,1,"Email"],
							);
							$field_errors =check_input_fields($required_fields);
							$c_result = validate_contact_number($_POST['contact-number']);
							if($c_result !== 1){
								$field_errors['contact-number'] = $c_result;
							}
						}
						break;	

					case 'parent':
						if(isset($_POST['submit'])){
							if($_SESSION['role'] === "admin"){
								$data['name'] = addslashes($_POST['name-with-initials']);
							}
							$data['occupation'] = addslashes($_POST['occupation']);
							$data['address'] = addslashes($_POST['address']);
							$data['email'] = addslashes($_POST['email']);
							$data['contact_number'] = $_POST['contact-number'];
							$required_fields["name-with-initials"]=[0,50,1,"Name with intials"];

							$required_fields = array(
								"address"=>[0,100,1,"Address"],
								"email"=>[0,100,1,"Email"]
							);
							$field_errors =check_input_fields($required_fields);
							$c_result = validate_contact_number($_POST['contact-number']);
							if($c_result !== 1){
								$field_errors['contact-number'] = $c_result;
							}
						}
						break;

					default:
						
					
						break;
				}
				if(empty($field_errors)){
					if(isset($_FILES['profile-photo']['tmp_name']) && !empty($_FILES['profile-photo']['tmp_name'])){
						$target = BASEPATH."public/uploads/{$role}_profile_photo/";
						$rename = $teacher_id;
						$data['profile_photo'] = $rename . "." .strtolower(pathinfo($_FILES['profile-photo']['name'], PATHINFO_EXTENSION));
						$res = upload_file($_FILES['profile-photo'],$target, 2000000, $rename);
						if($res !== 1){
							$field_errors['profile-photo'] = $res;
						}
					}

					if(empty($field_errors)){
						$this->load->model("user");
						$result = $this->load->user->update_user_data("{$role}",$data,$teacher_id);
						if($result === 1){
							if(isset($_FILES['profile-photo']['tmp_name'])&& !empty($_FILES['profile-photo']['tmp_name'])){
								if($_SESSION['role'] === $role){
									$_SESSION["profile_photo"] = $data["profile_photo"];
								}
							}
							$info = "Update Successfully";
						}
					}
				}
			}

			$this->load->{$role}->set_by_id($teacher_id);
			$result = $this->load->{$role}->get_data();
			// load header and navbar
			$this->view_header_and_aside();
			// load profile page
			if(!empty($field_errors)){
				$this->load->view("{$role}/{$role}_profile",["result"=>$result,"field_errors"=>$field_errors,"id"=>$teacher_id,"is_admin"=>$is_admin,"editable"=>$editable]);
			}else if(isset($info) && !empty($info)){
				$this->load->view("{$role}/{$role}_profile",["result"=>$result,"info"=>$info,"id"=>$teacher_id,"is_admin"=>$is_admin,"editable"=>$editable]);
			}else{
				$this->load->view("{$role}/{$role}_profile",["result"=>$result,"id"=>$teacher_id,"is_admin"=>$is_admin,"editable"=>$editable]);
			}
			$this->load->view("templates/footer");
		}

		// only view user profile
		public function profile_view($role="",$id=""){
			if(!$this->checkPermission->check_permission("profile","view")){
				$this->view_header_and_aside();
				$this->load->view("common/error");
				$this->load->view("templates/footer");
				return;
			}
			if( empty($id)){
				$id = $_SESSION['user_id'];
				$role = $_SESSION['role'];
			}
			$this->load->model($role);
			$result = $this->load->{$role}->set_by_id($id);
			$field_errors = [];

			// load header and navbar
			$this->view_header_and_aside();

			// load profile page
			$this->load->{$role}->set_by_id($id);
			$result = $this->load->{$role}->get_data();
			$this->load->view("{$role}/{$role}_profile_view",["result"=>$result]);
			$this->load->view("templates/footer");
		}

		private function update_profile($user_type,$data,$id){
			$field_errors = [];
			$info = "";
			
			return [$field_errors,$info];
		}

		//logout user
		public function logout(){
			session_start();
			unset($_SESSION['loggedin']);
			unset($_SESSION['role']);
			unset($_SESSION['user_id']);
			unset($_SESSION['username']);
			session_destroy();
			header("Location: login/Logout Successful.");
		}

		//forget password page
		public function forget_password(){
			$this->view_header_and_aside();
				if(isset($_POST['submit'])){
					if(!empty($_POST['email']) && valid_email($_POST['email']) ){
						//session_destroy();
						session_start();
						$_SESSION['change_email_id']=$_POST['email'];
						header('Location:'.set_url("verification_code"));
					}
					else{
						set_url("verfication_code");
					}
				}
			$this->load->view("common/forget_password",['header'=>$this->header_data]);
			$this->load->view("templates/footer");
		}
		//for verification_code page
		public function verification_code(){
			$this->view_header_and_aside();
				if(isset($_POST['submit'])){
					if(isset($_POST['ver-code']) && $_POST['ver-code']=='abc@1234'){
						header('Location:'.set_url("change_password"));
					}
					else{
						$error="Incorrect Verification Code";
					}

				}
			$this->load->view("common/verification_code",['header'=>$this->header_data]);
			$this->load->view("templates/footer");
		}

		//for change_password page
		public function change_password(){
			$this->view_header_and_aside();
			if(isset($_POST['submit'])){
				if((isset($_POST['password']) && isset($_POST['cpassword']))  && ($_POST['password']==$_POST['cpassword']) ){
					$this->load->model("user");
					$row = $this->load->user->get_user_data("user",$_SESSION["change_email_id"]);
					$salt =$row['salt'];
					$pwd=$_POST['password'];
					$hashed_password= sha1($pwd.$salt);

					$con = new Database();
					$con->update("user",array("password"=>$hashed_password),array("email"=>$_SESSION["change_email_id"]));
					session_destroy();
					$msg="Your Password Changed successfully";
				}

				else{
					$error ='Please Check Your Password';
					}

			}
			$this->load->view("common/change_password",['header'=>$this->header_data]);
			$this->load->view("templates/footer");

		}
	}