<?php include_once("session.php"); ?>
<?php require_once("../php/database.php") ?>
<?php require_once("../php/common.php") ?>
<?php 
	
	if(isset($_POST['submit'])){
		$is_ok = 1;
		$errors = array();
		$info = array();
		$valid = array();
		$rename = $_GET['student-id'];
		//upload profile photo
		if(isset($_FILES['profile-photo']) && !empty($_FILES['profile-photo']["tmp_name"])){
			$target = "../img/profile_photo/";
			$result = upload_file($_FILES['profile-photo'],$target,2000000,$rename);
			if(count($result[2])==1){
				$info["profile_photo"] = $result[2];
				$valid["profile_photo"]= $rename. "." .strtolower(pathinfo($_FILES['profile-photo']['name'],PATHINFO_EXTENSION));
			}else{
				$errors["profile_photo"] = $result[1];
			}
		}

		//upload birth certificate
		if(isset($_FILES['birth-certificate']) && !empty($_FILES['birth-certificate']["tmp_name"])){
			$target = "../img/birth_certificate/";
			$result = upload_file($_FILES['birth-certificate'],$target,2000000,$rename);
			if(count($result[2])==1){
				$info["birth_certificate"] = $result[2];
				$valid["birth_certificate"]= $rename. "." .strtolower(pathinfo($_FILES['birth-certificate']['name'],PATHINFO_EXTENSION));
			}else{
				$errors["birth_certificate"] = $result[1];
			}
		}
		//upload nic photo
		if(isset($_FILES['nic-photo']) && !empty($_FILES['nic-photo']["tmp_name"])){
			$target = "../img/nic_photo/";
			$result = upload_file($_FILES['nic-photo'],$target,2000000,$rename);
			if(count($result[2])==1){
				$info["nic_photo"] = $result[2];
				$valid["nic_photo"]= $rename. "." .strtolower(pathinfo($_FILES['nic-photo']['name'],PATHINFO_EXTENSION));
			}else{
				$errors["nic_photo"] = $result[1];
			}
		}
		if(!empty($valid)){
			$result = $con->update("student",$valid,array("id"=>$_GET['student-id']));
			if($result){
				header("Location:". set_url('pages/admissions_all.php'));
			}else{
				$error_other = "Data successfullt saved.";
			}
		}else{
			header("Location:". set_url('pages/admissions_all.php'));
		}
	}

 ?>

<?php require_once("../templates/header.php") ?>
<?php require_once("../templates/aside.php") ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($errors) && !empty($errors) && !empty($errors[array_keys($errors)[0]])){
			echo "<p class='float-left w-75 bg-red p-2'>";
			foreach ($errors as $key=>$error) {
				foreach ($error as $value) {
					$key = explode("_", $key);
					echo ucfirst($key[0])." " .ucfirst($key[1])." ". $value . "<br>";
				}
			}
			echo "</p>";
		}else{
			if(isset($error_other)){
				echo "<p class='text-center mb-2 float-left w-75 bg-red p-2'>";
				echo $error_other;
				echo "</p>";
			}
		}

		if(isset($info) && !empty($info) && !empty($info[array_keys($info)[0]])){
			echo "<p class='float-left w-75 bg-green p-2'>";
			foreach ($info as $key=>$in) {
				foreach ($in as $value) {
					$key = explode("_", $key);
					echo ucfirst($key[0])." ".ucfirst($key[1])." ". $value . "<br>";
				}
			}
			echo "</p>";
		}
	 ?>
	<form action="<?php echo set_url("pages/admission_student_register.php?student-id=".$_GET['student-id']); ?>" method="post" class="col-11" enctype="multipart/form-data">
		<fieldset class="p-5">
			<div class="form-group">
				<div class="form-group d-flex flex-col">
					<label for="profile-photo">Photo</label>
					<input type="file" name="profile-photo" id="profile-photo"  accept="image/jpg,image/jpeg,image/png"  onchange="check_input_image(this)">
					<p class="mt-2 bg-red fg-white p-2 d-none"></p>
				</div>
			</div>
			<div class="form-group">
				<div class="form-group d-flex flex-col">
					<label for="birth-certificate">Birth certificate</label>
					<input type="file" name="birth-certificate" id="birth-certificate"  accept="image/jpg,image/jpeg,image/png"  onchange="check_input_image(this)">
					<p class="mt-2 bg-red fg-white p-2 d-none"></p>
				</div>
			</div>
			<div class="form-group">
				<div class="form-group d-flex flex-col">
					<label for="nic-photo">Nic photo</label>
					<input type="file" name="nic-photo" id="nic-photo"  accept="image/jpg,image/jpeg,image/png"  onchange="check_input_image(this)">
					<p class="mt-2 bg-red fg-white p-2 d-none"></p>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" value="submit" name="submit" class="btn btn-blue">
			</div>
		</fieldset>
	</form>
</div>



<?php require_once("../templates/footer.php") ?>