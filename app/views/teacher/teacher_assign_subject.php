<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 
	$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
	if(isset($_POST['submit'])){
		$teacher_id = $_POST['id'];
		$name_with_initials = $_POST['name'];
		$result = $con->select("teacher",array("id"=>$teacher_id));
		if($result && $result->rowCount() == 1){
			if(!empty($teacher_id) && !empty($name_with_initials)){
				try{
					$con->db->beginTransaction();
					foreach ($_POST as $key => $value) {
						if( strpos($key, "subject") === 0 && strpos($key, "id") !== False){
							if(!empty($value)){
								$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$_POST["old-".$key]));
								if($result && $result->rowCount() >0){
									$result = $con->update("teacher_subject",array("subject_id"=>$value),array("teacher_id"=>$teacher_id, "subject_id"=>$_POST["old-".$key]));
									if(!$result){
										throw new PDOException("Subject update error.".$value	,1);
									}
								}else if($result){
									$result = $con->insert("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$value));
									if(!$result || $result->rowCount() ==0){
										throw new PDOException("Subject insertion error.",1);
									}
									$result = $con->select("teacher_subject",array("teacher_id"=>$teacher_id, "subject_id"=>$value));
									if(!$result || $result->rowCount() !==1){
										throw new PDOException("Subject insertion error.",1);
									}
									$result = $result->fetch();
									$user_id = $result['id'];
									$result = $con->insert("normal_timetable",array("type"=>"subject", "user_id"=>$user_id));
									if(!$result || $result->rowcount() !== 1){
										throw new PDOException("Timetable creation error.fff",1);
									}
									$result = $con->select("normal_timetable",array("type"=>"subject", "user_id"=>$user_id));
									if(!$result || $result->rowcount() !== 1 ){
										throw new PDOException("Timetable creation error.qqqqq",1);
									}
									$timetable_id = $result->fetch()['id'];
									for ($i=1; $i <= 5; $i++) { 
										for ($j=1; $j <= 8; $j++) { 
											$result = $con->insert("normal_day",array("timetable_id"=>$timetable_id, "day"=>$day_map[$i], "period"=>$j));
											if(!$result || $result->rowCount() !== 1){
												throw new PDOException("Timetable creation error.",1);
											}
										}
									}

								}
							}else{
								throw new PDOException("Subject Id is empty.",1);
							}
						}
					}
					$con->db->commit();
				}catch (Exception $e){
					$con->db->rollback();
					$error = $e->getMessage();
				}
			}else{
				$error = "Please fill teacher ID or Name.";
			}
		}else{
			$error = "Invalid teacher ID";
		}

	}
	if(isset($_GET['teacher-id'])){
		$con->get(array('id','name_with_initials'));
		$teacher_info = $con->select("teacher",array("id"=>$_GET['teacher-id']));
		if($teacher_info && $teacher_info->rowCount() == 1){
			$teacher_info = $teacher_info->fetch();
		}
		$result = $con->select("teacher_subject",array("teacher_id"=>$_GET['teacher-id']));
		$subject_info = array();
		if($result && $result->rowCount() > 0){
			$result = $result->fetchAll();			
			try{
				foreach ($result as $sub) {
					$result = $con->select("subject",array("id"=>$sub['subject_id']));
					if($result && $result->rowCount() == 1){
						array_push($subject_info, $result->fetch());
					}else{
						throw new PDOException("Data getting failed.",1);
					}
				}
			}catch (Exception $e){
				$con->db->rollback();
				$error = $e->getMessage();
			}
		}
	}

 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error)){
			echo "<p class='bg-red fg-white w-75 text-center p-2'>";
			echo $error."<br/>";
			echo "</p>";
		}

	 ?>

	<div class="mt-5  w-75 d-flex flex-col align-items-center">
		<h2 class="fs-30">Assign Subject to Teacher</h2>
		<hr class="topic-hr w-100">
	</div>
	<div class="col-10">
		<form action="teacher_assign_subject.php?teacher-id=<?php if(isset($_GET['teacher-id'])){echo $_GET['teacher-id'];} ?>" method="post" class="col-12">
			<div class="col-12">
				<fieldset class="col-12">
					<legend>Teacher Info</legend>
					<div class="form-group">
						<label for="id">ID</label>
						<input type="text" id="id" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_info['id'])){echo $teacher_info['id'];} ?>" oninput="get_teacher_data('id',this)">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" id="name" name="name" placeholder="Teacher Name" value="<?php if(isset($teacher_info['name_with_initials'])){echo $teacher_info['name_with_initials'];} ?>" oninput="get_teacher_data('name_with_initials',this)">
					</div>
				</fieldset>
			</div>
			<div class="col-12">
				<fieldset class="col-12">
					<legend>Subjects Info</legend>
					<!-- add some subjects dynamically -->
					<div  class="d-flex flex-col col-12 ">
						<div id="assign-subject">
							<?php 
								if(isset($subject_info) && !empty($subject_info)){
									for ($i=1; $i <= count($subject_info); $i++) {
										$sub = '<div  class="form-group d-flex flex-col border mb-5">
											<label>Subject-0'.$i.'</label>
											<div class=" d-flex flex-wrap justify-content-between"> 
												<input type="text" name="subject-0'.$i.'-id" id="subject-0'.$i.'-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data(\'id\',this)" value='.$subject_info[$i-1]['id'].'>
												<input type="text" name="subject-0'.$i.'-code" id="subject-0'.$i.'-code" class="col-3  d-inline-block" placeholder="Subject Code"  oninput="get_subject_data(\'code\',this)" value='.$subject_info[$i-1]['code'].'>
												<input type="text" name="subject-0'.$i.'-name" id="subject-0'.$i.'-name" class="col-3  d-inline-block" placeholder="Subject Name" disabled="disabled" value='.$subject_info[$i-1]['name'].'>
												<input type="hidden" name="old-subject-0'.$i.'-id" id="old-subject-0'.$i.'-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data(\'id\',this)" value='.$subject_info[$i-1]['id'].'>
											</div>
											<div class="w-100 justify-content-end d-flex pr-5">
												<button class="btn btn-blue" type="button" onclick="teacher_subject_remove(this)" >- remove subject</button>
											</div>
										</div>';
										echo $sub;
													
									}
								}else{
									$sub = '<div  class="form-group d-flex flex-col border mb-5">
										<label>Subject-01</label>
										<div class=" d-flex flex-wrap justify-content-between"> 
											<input type="text" name="subject-01-id" id="subject-01-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data(\'id\',this)">
											<input type="text" name="subject-01-code" id="subject-01-code" class="col-3  d-inline-block" placeholder="Subject Code"  oninput="get_subject_data(\'code\',this)">
											<input type="text" name="subject-01-name" id="subject-01-name" class="col-3  d-inline-block" placeholder="Subject Name" disabled="disabled">
											<input type="hidden" name="old-subject-01-id" id="old-subject-01-id" class="col-3  d-inline-block" placeholder="Subject Name">
										</div>
										<div class="w-100 justify-content-end d-flex pr-5">
											<button class="btn btn-blue" type="button" onclick="teacher_subject_remove(this)" >- remove subject</button>
										</div>
									</div>';
									echo $sub;
								}
							 ?>
						</div>
						<div class="w-100 justify-content-end d-flex pr-5">
							<button class="btn btn-blue" type="button" onclick="teacher_subject_add('assign-subject',this)">+ Add subject</button>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="d-flex w-90 justify-content-end mt-5">
				<input type="submit" name="submit" value="submit" class="btn btn-blue">
			</div>
		</form>
	</div>

</div>


<?php require_once("../templates/footer.php"); ?>