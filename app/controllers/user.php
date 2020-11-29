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

				$this->load->model("user");
				$result = $this->load->user->get_user_data("user",$email);

				if($result){
					$_SESSION['role'] = $result['role'];
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
			if( strlen($info) >0){
				$this->load->view("common/login",["info"=>$info]);
			}else{
				$this->load->view("common/login");
			}
			$this->load->view("templates/footer");
		}

		//view dashboard for all users
		public function dashboard($msg=""){
			$this->view_header_and_aside();
			$this->load->model("user");
			$counts = $this->load->user->get_staticstic_count();
			if( strlen($msg) > 0){
				$this->load->view("common/dashboard", ["count"=>$counts,"msg"=>$msg]);
			}else{
				$this->load->view("common/dashboard", ["count"=>$counts]);
			}
			$this->load->view("templates/footer");
		}

		public function profile($role="",$id=""){
			if(empty($role)){
				$role = $_SESSION['role'];
			}
			if( empty($id)){
				$id = $_SESSION['user_id'];
			}
			$this->load->model($role);
			$result = $this->load->{$role}->set_by_id($id);
			$field_errors = [];

			switch ($role) {
				case 'student':
					if(isset($_POST['submit'])){
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
						if(empty($field_errors)){
							$result = $this->update_profile("student",$data);
							$field_errors = array_merge($field_errors,$result[0]);
							$info = $result[1];
						}
					}
					break;		
				case 'teacher':
					if(isset($_POST['submit'])){
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
						if(empty($field_errors)){
							$result = $this->update_profile("teacher",$data);
							$field_errors = array_merge($field_errors,$result[0]);
							$info = $result[1];
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
						if(empty($field_errors)){
							$result = $this->update_profile("admin",$data);
							$field_errors = array_merge($field_errors,$result[0]);
							$info = $result[1];
						}
					}
					break;	

				case 'parent':
					if(isset($_POST['submit'])){
						$data['occupation'] = addslashes($_POST['occupation']);
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
						if(empty($field_errors)){
							$result = $this->update_profile("parent",$data);
							$field_errors = array_merge($field_errors,$result[0]);
							$info = $result[1];
						}
					}
					break;

				default:
					
				
					break;
			}
			// load header and navbar
			$this->view_header_and_aside();

			// load profile page
			$result = $this->load->{$role}->set_by_id($id);
			$data = $this->load->{$role}->get_data();
			if(!empty($field_errors)){
				$this->load->view("{$role}/{$role}_profile",["result"=>$data,"field_errors"=>$field_errors]);
			}else if(isset($info) && !empty($info)){
				$this->load->view("{$role}/{$role}_profile",["result"=>$data,"info"=>$info]);
			}else{
				$this->load->view("{$role}/{$role}_profile",["result"=>$data]);
			}
			$this->load->view("templates/footer");
		}

		private function update_profile($user_type,$data){
			$field_errors = [];
			$info = "";
			if(isset($_FILES['profile-photo']['tmp_name']) && !empty($_FILES['profile-photo']['tmp_name'])){
				$target = BASEPATH."public/uploads/{$user_type}_profile_photo/";
				$rename = $_SESSION['user_id'];
				$data['profile_photo'] = $rename . "." .strtolower(pathinfo($_FILES['profile-photo']['name'], PATHINFO_EXTENSION));
				$res = upload_file($_FILES['profile-photo'],$target, 2000000, $rename);
				if($res !== 1){
					$field_errors['profile-photo'] = $res;
				}
			}

			if(empty($field_errors)){
				$this->load->model("user");
				$result = $this->load->user->update_user_data("{$user_type}",$data,$_SESSION['user_id']);
				if($result === 1){
					if(isset($_FILES['profile-photo']['tmp_name'])&& !empty($_FILES['profile-photo']['tmp_name'])){
						$_SESSION["profile_photo"] = $data["profile_photo"];
					}
					$info = "Update Successfully";
				}
			}
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