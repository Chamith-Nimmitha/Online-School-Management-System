<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?> 

<?php 
	$teacher_subject_info['id'] = $_GET['id'];
	$teacher_subject_info['grade'] = 12;
	$teacher_subject_info['code'] = "12MAT";
	$teacher_subject_info['name'] = "Maths";

	$student_list = array();
	$student['id'] = "1";
	$student['name_with_initials'] = "Kamal Perera";
	$student['email'] = "kamal@gmail.com";
	$student['contact_number'] = "0771234567";
	$student['classroom_id'] = "20";
	array_push($student_list, $student);
	$student['id'] = "2";
	$student['name_with_initials'] = "Sunil Gamage";
	$student['email'] = "sunil@gmail.com";
	$student['contact_number'] = "0775747474";
	$student['classroom_id'] = "21";
	array_push($student_list, $student);
 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<div class="p-5  w-100 d-flex align-items-center flex-col">
		<h1>Teacher-Subject Students</h1>
	</div>
	<hr class="w-100 mb-5">

	<form action="#" method="POST" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend> Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Teacher ID</label>
				<input class="" type="text" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_subject_info)){echo $teacher_subject_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<input type="text" placeholder="Grade" value="<?php if(isset($teacher_subject_info)){echo $teacher_subject_info['grade'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Subject Code</label>
				<input type="text" placeholder="Subject Code" value="<?php if(isset($teacher_subject_info)){echo $teacher_subject_info['code'];} ?>" disabled="disabled">
				
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Subject Name</label>
				<input type="text" placeholder="Subject Name" value="<?php if(isset($teacher_subject_info)){echo $teacher_subject_info['name'];} ?>" disabled="disabled">
				
			</div>
		</fieldset>
	</form>


	<form action="<?php echo set_url('pages/teacher_subject_student_list.php',array('id'=>$_GET['id'])) ?>" method="POST" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 p-3">
			<legend>Student Info</legend>
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
				<tbody class="col-12">
					<?php 
						if(isset($student_list) && !empty($student_list)){
							foreach ($student_list as $student) {
								$row = '<tr class="col-12 word-break">';
								$row .= '<td class="col-2 d-flex justify-content-center">'.$student['id'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['name_with_initials'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['email'].'</td>';
								$row .= '<td class="col-2  word-break">'.$student['contact_number'].'</td>';
								$row .= '<td class="col-2  word-break d-flex justify-content-center align-items-center"><input type="checkbox" name="" id="" value="'.$student['id'].'" ';
								if($student['classroom_id'] != null){
									$row .= "checked";
								}
								$row .= ' disabled="disabled"></td>';
								$row .= '<td class="d-flex justify-content-center col-2 text-center word-break"><a class="t-d-none p-1 btn btn-blue" href="'.set_url("pages/student_profile_view?student_id=".$student['id']).'">profile</a></td>';
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
</div>

<?php require_once("../templates/footer.php"); ?>