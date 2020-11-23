<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>
<?php 


	if(isset($_POST['submit'])){
		$update_errors = array();
		foreach ($_POST as $key => $value) {
			if( stripos($key, "student-") === 0 ){
				$result = $con->update("student", array("classroom_id"=>$_GET['classroom_id']), array("id"=> $value) );
				if(!$result || $result->rowCount()!= 1){
					array_push($update_errors, "Student ".$value." assign failed.");
				}
			}
		}
		if(empty($update_errors)){
			$info = "Assign successful.";
		}
	}

	if(isset($_GET['classroom_id'])){
		try {
			$con->db->beginTransaction();
			$result = $con->select("classroom", array("id"=> $_GET['classroom_id']));
			if(!$result || $result->rowCount() != 1){
				throw new Exception("Classroom Not Found.", 1);
			}
			$query = "SELECT `c`.`id`,`s`.`grade`,`c`.`class`,`c`.`section_id` FROM `classroom` AS `c` JOIN `section` AS `s` ON `c`.`section_id` = `s`.`id` WHERE `c`.`id`=".$_GET['classroom_id'];
			$result = $con->pure_query($query);
			if(!$result || $result->rowCount() != 1){
				throw new Exception("Query Error.", 1);
			}
			$classroom_info = $result->fetch();
			$con->get(array("grade"));
			$con->orderby("grade");
			$result = $con->select("section");
			if(!$result || $result->rowCount() == 0){
				throw new Exception("Sections not found..", 1);
			}
			$section_list = $result->fetchAll();
			$con->get(array("class"));
			$result = $con->select("classroom", array("section_id"=>$classroom_info['section_id']));
			if(!$result || $result->rowCount() == 0){
				throw new Exception("Classrooms are not defined.", 1);
			}
			$class_list = $result->fetchAll();
			$con->db->commit();
		} catch (Exception $e) {
			$error = $e->getMessage();
			$con->db->rollback();
		}

		try {
			$con->db->beginTransaction();
			$query = "SELECT `id`,`name_with_initials`,`email`,`contact_number`,`classroom_id` FROM `student` WHERE `classroom_id` IS NULL && `grade`=".$classroom_info['grade']." LIMIT 10" ;
			$result = $con->pure_query($query);
			if(!$result){
				throw new Exception("Students Not found.", 1);
			}
			$student_list = $result->fetchAll();

			$con->db->commit();
		} catch (Exception $e) {
			$con->db->rollback();
		}

	}

 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error) || (isset($update_errors) && !empty($update_errors))){
			echo "<p class='w-75 p-2 bg-red fg-white'>";
			if(isset($error)){
				echo $error. "<br/>";
			}

			if(isset($update_errors)){
				foreach ($update_errors as $e) {
					echo $e. "<br/>";
				}
			}
			echo "</p>";
		}

		if(isset($info)){
			echo "<p class='bg-green fg-white p-2 w-75 text-center'>";
			echo $info."<br/>";
			echo "</p>";
		}

	 ?>

	<div class="p-5 w-100 d-flex align-items-center flex-col">
		<h1>Assign New Students</h1>
		<div class="w-75 d-flex justify-content-end">
			<a class="t-d-none btn btn-blue-outline p-1" href="<?php echo set_url('pages/classroom_student.php?classroom_id='.$_GET['classroom_id']); ?>"> Show classroom students</a>
		</div>
	</div>
	<hr class="w-100 mb-5">

	<form action="classroom_assign_student.php" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Classroom Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Classroom ID</label>
				<input class="" type="text" name="id" placeholder="Classroom ID" value="<?php if(isset($classroom_info)){echo $classroom_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<input type="text" id="grade" name="grade" placeholder="Grade" value="<?php if(isset($classroom_info)){echo $classroom_info['grade'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Class</label>
				<input type="text" name="class" value="<?php if(isset($classroom_info['class'])){echo $classroom_info['class'];} ?>" disabled="disabled">
			</div>
		</fieldset>


		<fieldset class="col-12 p-3">
			<legend>Student Info</legend>

			<div class="d-flex  mb-5" id="search_student">
				<div class="align-items-center d-flex pl-5 ml-5">
					<label style="width: 150px;" class="pr-3" for="id_search">Student ID?Name</label>
					<input type="text" name="id_search" id="id_search" placeholder="Student ID/Name"  oninput="get_student_data2('target','id_search','id_search','grade')">
				</div>
			</div>
			<table class="table-strip-dark col-12">
				<thead class="col-12">
					<tr class="col-12">
						<th class="col-2">ID</th>
						<th class="col-2">Name</th>
						<th class="col-2">Email</th>
						<th class="col-2">Contact Number</th>
						<th class="col-2">Assign</th>
						<th class="col-2">Profile</th>
					</tr>
				</thead>
				<tbody id="target" class="col-12" id="student_list_table">
					<?php 
						if(isset($student_list) && !empty($student_list)){
							foreach ($student_list as $student) {
								$row = '<tr class="col-12 word-break">';
								$row .= '<td class="col-2 word-break">'.$student['id'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['name_with_initials'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['email'].'</td>';
								$row .= '<td class="col-2  word-break">'.$student['contact_number'].'</td>';
								$row .= '<td class="col-2  word-break d-flex justify-content-center align-items-center"><input type="checkbox" name="assign-'.$student['id'].'" value="'.$student['id'].'" onchange="update_student_selected_set(this)"></td>';
								$row .= '<td class="col-2  word-break"><a href="'.set_url("pages/student_profile_view?student_id=".$student['id']).'">profile</a></td>';
								$row .= '</tr>';
								echo $row;
							}
						}else{
							echo "<tr class='col-12'>";
							echo "<td colspan=6 class='col-12 bg-red'><p class='text-center w-100'>Students Not found...</p></td>";
							echo "</tr>";
						}

					 ?>
				</tbody>
			</table>
		</fieldset>
	</form>
	<hr class="w-100 mt-5 mb-3">
	<div class="d-flex flex-col col-12 align-items-center border">
		<div>
			<h2>Selected Students for Add</h2>
		</div>
		<hr class="w-100 mb-5">
		<form action="classroom_assign_student.php?classroom_id=<?php echo $_GET['classroom_id'] ;?>" method="post" class="col-12 d-flex flex-col align-items-center">
			<input type="hidden" name="classroom_id" value="<?php echo $classroom_info['id']; ?>" >
			<div class="col-10 mb-5 d-flex flex-wrap" id="selected-set">
				<!-- add student here -->
			</div>

			<div class="w-100 d-flex justify-content-end">
				<input type="submit" value="Assign" name="submit" class="btn btn-blue">
			</div>
		</form>
	</div>
</div>

<?php require_once("../templates/footer.php"); ?>