
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if((isset($error)  && !empty($errors)) || (isset($update_errors) && !empty($update_errors))){
			echo "<p class='w-75 p-2 bg-red fg-white'>";
			if((isset($error)  && !empty($errors))){
				echo $error. "<br/>";
			}

			if((isset($update_errors) && !empty($update_errors))){
				foreach ($update_errors as $e) {
					echo $e. "<br/>";
				}
			}
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='bg-green fg-white p-2 w-75 text-center'>";
			echo $info."<br/>";
			echo "</p>";
		}

	 ?>

	<div class="p-5 w-100 d-flex d-row align-items-center flex-col">
		<div class="w-75 d-flex justify-content-center">
			<h2 class="mr-5">Assign New Students</h2>
		</div>
		<hr class="topic-hr w-75">
	</div>

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


		<fieldset class="col-11 p-3">
			<legend>Student Info</legend>

			<div class="d-flex  mb-5 w-100" id="search_student">
				<div class="align-items-center d-flex justify-content-between w-100 pl-5 ml-5">
					<div class="d-flex align-items-center">
						<label style="width: 150px;" class="pr-3" for="id_search">Student ID/Name</label>
						<input type="text" style="width: 300px;" name="id_search" id="id_search" placeholder="Student ID/Name"  oninput="get_student_data2('target','id_search','id_search','grade')">
					</div>
					<a class="t-d-none btn btn-blue-outline p-1 ml-5" style="width: 200px;" href="<?php echo set_url('classroom/student/list/'.$classroom_info['id']); ?>"> Show classroom students</a>
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
								$row .= '<td class="col-2 d-flex justify-content-center word-break"><a class="btn" href="'.set_url("pages/student_profile_view?student_id=".$student['id']).'"><i title="profile" class="fas fa-user-circle profile-button"></i></a></td>';
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
	<hr class="col-11 mt-5 mb-3">
	<div class="d-flex flex-col col-12 align-items-center border">
		<div class=" w-75 d-flex flex-col align-items-center">
			<h2>Selected Students for Add</h2>
			<hr class="topic-hr w-100">
		</div>
		<form action="<?php echo set_url('classroom/student/add/'.$classroom_info['id']); ?>" method="post" class="col-11 d-flex flex-col align-items-center">
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
