<?php

	class User extends Controller {

		// login user
		public function login(){
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
						header('Location:dashboard/Login Successful');
					}
				}else{
					$message ="Invalid email or password";
				}
			}
			$this->load->view("common/login");
			$this->load->view("templates/footer");
		}

		//view dashboard
		public function dashboard($msg=""){
			// echo $msg;
			$this->load->model("user");
			$counts = $this->load->user->get_staticstic_count();
			if( strlen($msg) > 0){
				$this->load->view("common/dashboard", ["count"=>$counts,"msg"=>$msg]);
			}else{
				$this->load->view("common/dashboard", ["count"=>$counts]);
			}
			$this->load->view("templates/footer");
		}
	}