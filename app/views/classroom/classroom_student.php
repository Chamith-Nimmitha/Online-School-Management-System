
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
		<div class="w-75 d-flex justify-content-end">
			<a class="t-d-none btn btn-blue-outline" href="<?php echo set_url('classroom/student/add/'.$classroom_info['id']); ?>">+add new students</a>
		</div>
	</div>
	<hr class="w-100 mb-5">

	<form action="classroom_student.php" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Classroom Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Classroom ID</label>
				<input class="" type="text" name="id" placeholder="Classroom ID" value="<?php if(isset($classroom_info)){echo $classroom_info['id'];} ?>">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<select name="grade_search" id="grade_search">
					<option value="notfound">Not Found</option>
					<?php 
						if(isset($section_list)){
							foreach ($section_list as $section) {
								echo '<option value="'.$section['grade'].'" ';
								if($section['grade'] == $classroom_info['grade']){
									echo "selected='selected'";
								}
								echo '>'.$section['grade'].'</option>';
							}
						}
					 ?>
				</select>
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Class</label>
				<select name="class" id="class">
					<option value="">SELECT</option>
					<?php 
						foreach ($class_list as $class) {
							echo "<option value='".$class['class']."'";
							if($class['class'] == $classroom_info['class']){
								echo "selected='selected'";
							}
							echo ">".$class['class']."</option>";
						}

					 ?>
				</select>
			</div>
		</fieldset>


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
								$row .= '<td class="col-2 word-break">'.$student['id'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['name_with_initials'].'</td>';
								$row .= '<td class="col-2 word-break">'.$student['email'].'</td>';
								$row .= '<td class="col-2  word-break">'.$student['contact_number'].'</td>';
								$row .= '<td class="col-2  word-break d-flex justify-content-center align-items-center"><input type="checkbox" name="" id="" value="'.$student['id'].'" ';
								if($student['classroom_id'] != null){
									$row .= "checked";
								}
								$row .= ' onchange="update_student_removed_set(this)"></td>';
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
			<h2>Selected Students for Remove</h2>
		</div>
		<hr class="w-100 mb-5">
		<form action="<?php echo set_url('classroom/student/list/'.$classroom_info['id']); ?>" method="post" class="col-12 d-flex flex-col align-items-center">
			<input type="hidden" name="classroom_id" value="<?php echo $classroom_info['id']; ?>" >
			<div class="col-10 mb-5 d-flex flex-wrap" id="removed-set">
				<!-- add student here -->
			</div>

			<div class="w-100 d-flex justify-content-end">
				<input type="submit" value="Remove" name="submit" class="btn btn-blue">
			</div>
		</form>
	</div>
</div>