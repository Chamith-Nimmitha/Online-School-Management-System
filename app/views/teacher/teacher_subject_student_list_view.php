
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<div class="p-5 mt-5  w-75 d-flex flex-col align-items-center">
		<h1>Teacher-Subject Students</h1>
		<hr class="topic-hr w-100">
	</div>

	<form action="#" method="POST" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend> Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Teacher ID</label>
				<input class="" type="text" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_subject_info)){echo $teacher_subject_info['teacher_id'];} ?>" disabled="disabled">
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


	<form action="<?php echo set_url('pages/teacher_subject_student_list.php',array('id'=>$_GET['id'])) ?>" method="POST" class="col-11 d-flex flex-col align-items-center">
		<fieldset class="p-3 col-12">
			<legend>Student Info</legend>
			<div class="col-12 mt-5 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
				<table class="table-strip-dark">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Classroom</th>
							<th>Email</th>
							<th>Contact Number</th>
							<th>Assign</th>
							<th>Profile</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if(isset($student_list) && !empty($student_list)){
								foreach ($student_list as $student) {
									$row = '<tr word-break">';
									$row .= '<td class=" d-flex justify-content-center">'.$student['id'].'</td>';
									$row .= '<td class=" word-break">'.$student['name_with_initials'].'</td>';
									$row .= '<td class=" word-break">'.$student['grade']."-".$student['class'].'</td>';
									$row .= '<td class=" word-break">'.$student['email'].'</td>';
									$row .= '<td class="  word-break">'.$student['contact_number'].'</td>';
									$row .= '<td class="text-center"><input type="checkbox" name="" id="" value="'.$student['id'].'" ';
									if($student['classroom_id'] != null){
										$row .= " checked";
									}
									$row .= ' disabled="disabled"></td>';
									$row .= '<td class="d-flex align-items-center justify-content-center  text-center word-break"><a class="t-d-none p-1 btn btn-blue" href="'.set_url("profile/student/".$student['id']).'">profile</a></td>';
									$row .= '</tr>';
									echo $row;
								}
							}else{
								echo "<tr class='w-100'>";
								echo "<td colspan=7 class=' bg-red'><p class='text-center w-100'>Students Not Found...</p></td>";
								echo "</tr>";
							}

						 ?>
					</tbody>
				</table>
			</div>
		</fieldset>
	</form>
</div>

