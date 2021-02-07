
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg) && !empty($msg)){
			echo "<p class='w-75 text-center p-2 bg-green'>";
			echo $msg;
			echo "</p>";
		}
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 text-center p-2 bg-lightred'>";
			echo $error;
			echo "</p>";
		}
	 ?>
	<div class="p-5  w-100 d-flex align-items-center flex-col">
		<h1>Add students</h1>
		<div class="w-75 d-flex justify-content-end">
			<a class="t-d-none btn btn-blue-outline" href="<?php echo set_url('teacher/subject/student/list/').$teacher_subject_id; ?>">+show students</a>
		</div>
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


	<form method="POST" class="col-11 d-flex flex-col align-items-center" id="subject_student_list">
		<fieldset class="col-12 p-3">
			<legend>Student Info</legend>
			<input class="" type="hidden" name="teacher_subject_id_hidden" id="teacher_subject_id_hidden" value="<?php echo $teacher_subject_id; ?>" disabled="disabled">
			<div class="d-flex  mb-5 col-12" id="search_student">
				<div class="pl-5 ml-2">
					<label  class="pb-2" for="id_search">Student ID/Name</label>
					<input type="text" name="id_search" id="id_search" placeholder="Student ID/Name">
				</div>
				<div class="pl-5 ml-2">
					<label  class="pb-2" for="id_search">Class</label>
					<select name="class_search" id="class_search">
						<option value="None">Select A Class</option>
						<?php 
							if(isset($class_list) && !empty($class_list)){
								foreach ($class_list as $class) {
									echo "<option value='{$class['id']}'>{$class['class']}</option>";
								}
							}
						 ?>
					</select>
				</div>
				<div class="flex-1 d-flex justify-content-end align-items-end">
					<button type="button" class="btn btn-green" id="select_all">Select All</button>
				</div>
			</div>
			<table class="table-strip-dark col-12">
				<thead class="col-12">
					<tr class="col-12">
						<th class="col-2 text-center">ID</th>
						<th class="col-2 text-center">Name</th>
						<th class="col-2 text-center">Email</th>
						<th class="col-2 text-center">Contact Number</th>
						<th class="col-2 text-center">Assign</th>
						<th class="col-2 text-center">Profile</th>
					</tr>
				</thead>
				<tbody class="col-12" id="tbody">
					<?php 
						if(isset($student_list) && !empty($student_list)){
							foreach ($student_list as $student) {
								$row = '<tr class="col-12 word-break">';
								$row .= '<td class="col-2 d-flex justify-content-center">'.$student['id'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['name_with_initials'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['email'].'</td>';
								$row .= '<td class="col-2  word-break">'.$student['contact_number'].'</td>';
								$row .= '<td class="col-2  word-break d-flex justify-content-center align-items-center"><input type="checkbox" name="assign-'.$student['id'].'" value="'.$student['id'].'" onchange="update_student_selected_set(this)"></td>';
								$row .= '<td class="d-flex justify-content-center align-items-center col-2 text-center word-break"><a class="t-d-none p-1 btn btn-blue" href="'.set_url("profile/student/".$student['id']).'">profile</a></td>';
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
		<form action="<?php echo set_url("teacher/subject/student/add/").$teacher_subject_id; ?>" method="post" class="col-12 d-flex flex-col align-items-center">
			<input type="hidden" name="classroom_id" value="<?php echo $teacher_subject_info['id']; ?>" >
			<div class="col-10 mb-5 d-flex flex-wrap" id="selected-set">
				<!-- add student here -->
			</div>

			<div class="w-100 d-flex justify-content-end">
				<input type="submit" value="ADD" name="submit" class="btn btn-blue">
			</div>
		</form>
	</div>
</div>