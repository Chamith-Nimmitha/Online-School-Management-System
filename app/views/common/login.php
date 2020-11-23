<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
?>
<?php 
if ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) && isset($_SESSION['username'])) {
    	header('Location:admin.php');
	}
?>

<?php 
	$errors = array();  
	$message="";
	if(isset($_POST['submit'])) {
		$conn = new mysqli("localhost","root","","sms-final");
		$email = mysqli_real_escape_string($conn,$_POST["email"]);
		$user_password = mysqli_real_escape_string($conn,$_POST["password"]);

		$query = "SELECT * FROM `user` WHERE `email`=? ";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$result = $stmt->get_result();
		if(mysqli_num_rows($result) ===1){
			$row=mysqli_fetch_array($result);
			$_SESSION['role'] = $row['role'];
			$salt =$row['salt'];
			$db_hashed_pass =$row['password'];
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
				$_SESSION["role"]=$row['role'];
				$_SESSION['loggedin'] = true;
				if($_SESSION["role"]==="student"){
					$query = "SELECT * FROM `student` WHERE `email`=? ";
					$stmt = $conn->prepare($query);
					$stmt->bind_param("s",$email);
					$stmt->execute();
					$result = $stmt->get_result();
					$row1=$result->fetch_assoc();
					$_SESSION["user_id"]=$row1['id'];
					$_SESSION["username"]=$row1['first_name'];
					$_SESSION["profile_photo"]=$row1['profile_photo'];
				}else if($_SESSION["role"]==="teacher"){
					$query = "SELECT * FROM `teacher` WHERE `email`=? ";
					$stmt = $conn->prepare($query);
					$stmt->bind_param("s",$email);
					$stmt->execute();
					$result = $stmt->get_result();
					$row1=$result->fetch_assoc();
					$_SESSION["user_id"]=$row1['id'];
					$_SESSION["username"]=$row1['name_with_initials'];
					$_SESSION["profile_photo"]=$row1['profile_photo'];
				}else if($_SESSION["role"]==="parent"){
					$query = "SELECT * FROM `parent` WHERE `email`=? ";
					$stmt = $conn->prepare($query);
					$stmt->bind_param("s",$email);
					$stmt->execute();
					$result = $stmt->get_result();
					$row1=$result->fetch_array();
					$_SESSION["user_id"]=$row1['id'];
					$_SESSION["username"]=$row1['name'];
					$_SESSION["profile_photo"]=$row1['profile_photo'];
				}else if($_SESSION["role"]==="admin"){
					$query = "SELECT * FROM `admin` WHERE `email`=? ";
					$stmt = $conn->prepare($query);
					$stmt->bind_param("s",$email);
					$stmt->execute();
					$result = $stmt->get_result();
					$row1=$result->fetch_array();
					print_r($row1);
					$_SESSION["user_id"]=$row1['id'];
					$_SESSION["username"]=$row1['username'];
					$_SESSION["profile_photo"]=$row1['profile_photo'];
				}
				header('Location:admin.php?msg="Login Successful."');
			}
		}else{
			$message ="Invalid email or password";
		}
	}
?>
<?php require_once("../templates/header.php") ?>
<?php require_once("../php/database.php") ?>

<div id="content" style="height: 470px;" class="col-12 justify-content-center align-items-start">
	<form action="" method="post" class="col-12 col-md-8 mt-5 col-lg-4">
		<div class="message col-12">
			<?php 
				if($message!="") {
					echo "<p class='bg-red p-2 w-100 text-center'>";
					echo $message;
					echo "</p>";
				} 
			?>
		</div>
		<fieldset class="col-12">
			<legend>LOGIN</legend>
			<div class="form-group">
      			<label for="email">Email</label>
        		<input type="email" name="email" id="email" placeholder="email" oninput="validate_email(this,0,100,1)" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"];} ?> ">
        		<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
     		</div>
     		 <div class="form-group">
      			<label for="password">Password (<a href="forget_password.php" class="d-inline-block t-d-none b-radius-10 pl-2 pr-2">Forget Password?</a>)</label>
        		<input type="password" name="password" id="password" placeholder="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"];} ?>" class="form-control">
      		</div>
      		<div class="d-flex justify-content-end col-11">
	      		<div class="check justify-content-center align-items-center">
	          		<label for="remember-me">Remember me</label>
	            	<input type="checkbox" name="remember-me" class="form-control" id="remember"><br> 
	            </div>

	            <div class="justify-content-center align-items-center text-center">
	     			<input type="submit" name="submit" class="btn btn-blue"  value="Log In">
	 			</div>
      		</div>
      		<div class="col-12 d-flex justify-content-center align-items-center fg-white bg-blue b-radius-5">
      			Don't have account yet?<a href="./student_registration.php" class="btn btn-blue-outline p-1 ml-5">Register Now!</a>
      		</div>
		</fieldset>
	</form>
</div>

<?php require_once("../templates/footer.php") ?>