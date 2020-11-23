<?php 
	if(!isset($_SESSION)){
		session_start();
	}
 ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>
<?php 
	if(isset($_GET['classroom_id']) || (isset($_SESSION['role']) && $_SESSION['role'] =="student" )){
		try {
			$con->db->beginTransaction();
			if(!isset($_GET['classroom_id']) ){
				$result = $con->select("student",array("id"=>$_SESSION['user_id']));
				if($result && $result->rowCount() === 1){
					$result = $result->fetch();
					$_GET['classroom_id'] = $result['classroom_id'];
				}
			}
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

			$con->get(array("id","name_with_initials","email","contact_number","classroom_id"));
			$result = $con->select("student", array("classroom_id"=>$_GET{'classroom_id'}));
			if(!$result){
				throw new Exception("Student list error.", 1);
			}
			$student_list = $result->fetchAll();
			$con->db->commit();
		} catch (Exception $e) {
			$error = $e->getMessage();
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

	<div class="p-5  w-100 d-flex align-items-center flex-col">
		<h1>Classroom Students</h1>
	</div>
	<hr class="w-100 mb-5">

	<form action="classroom_student.php" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Classroom Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Classroom ID</label>
				<input type="text" placeholder="Classroom ID" value="<?php if(isset($classroom_info)){echo $classroom_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<input type="text" name="grade" placeholder="Grade" value="<?php if(isset($classroom_info)){echo $classroom_info['grade'];} ?>" disabled="disable">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Class</label>
				<input type="text" name="class" placeholder="Class" value="<?php if(isset($classroom_info)){echo $classroom_info['class'];} ?>" disabled="disable">
			</div>
		</fieldset>
		<hr class="w-100 mt-5">
		<div class="col-10">
			<legend class="p-5">Student List</legend>
			<table class="table-strip-dark col-12">
				<thead class="col-12">
					<tr class="col-12">
						<th class="col-2">ID</th>
						<th class="col-3">Name</th>
						<th class="col-4">Email</th>
						<th class="col-3">Contact Number</th>
					</tr>
				</thead>
				<tbody class="col-12">
					<?php 
						if(isset($student_list) && !empty($student_list)){
							foreach ($student_list as $student) {
								$row = '<tr class="col-12 word-break">';
								$row .= '<td class="col-2 word-break">'.$student['id'].'</td>';
								$row .= '<td class="col-3 word-break">'.$student['name_with_initials'].'</td>';
								$row .= '<td class="col-4 word-break">'.$student['email'].'</td>';
								$row .= '<td class="col-3  word-break">'.$student['contact_number'].'</td>';
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
		</div>
	</form>
</div>

<?php require_once("../templates/footer.php"); ?>