
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
		<div class="w-75 d-flex flex-col align-items-center">
			<h2 class="mr-5">Classroom Students</h2>
			<hr class="topic-hr w-100">
		</div>
	</div>	

	<form action="classroom_student.php" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Classroom Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Classroom ID</label>
				<input class="" type="text" name="id" placeholder="Classroom ID" value="<?php if(isset($classroom_info)){echo $classroom_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<input type="text" name="grade" id="grade" placeholder="Classroom ID" value="<?php if(!empty($classroom_info)){echo $classroom_info['grade'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Class</label>
				<input type="text" name="class" id="class" placeholder="Class" value="<?php if(!empty($classroom_info)){echo $classroom_info['class'];} ?>" disabled="disable">
			</div>
		</fieldset>


		<fieldset class="col-11 p-3">
			<legend>Student Info</legend>
			<a class="t-d-none ml-5 btn btn-blue-outline mb-5" href="<?php echo set_url('classroom/student/add/'.$classroom_info['id']); ?>">+add new students</a>
			<table class="table-strip-dark w-100">
				<thead class="w-100">
					<tr class="">
						<th class="">No</th>
						<th class="">ID</th>
						<th class="">Name</th>
						<th class="">Email</th>
						<th class="">Contact Number</th>
						<th class="">Assign</th>
						<th class="">Profile</th>
					</tr>
				</thead>
				<tbody class="w-100">
					<?php 
						if(isset($student_list) && !empty($student_list)){
							$no = 1;
							foreach ($student_list as $student) {
								$row = '<tr class=" word-break">';
								$row .= "<td>".str_pad($no,2,'0',STR_PAD_LEFT)."</td>";
								$row .= '<td class=" word-break">'.$student['id'].'</td>';
								$row .= '<td class=" word-break">'.$student['name_with_initials'].'</td>';
								$row .= '<td class=" word-break">'.$student['email'].'</td>';
								$row .= '<td class="  word-break">'.$student['contact_number'].'</td>';
								$row .= '<td class="  word-break d-flex justify-content-center align-items-center"><input type="checkbox" name="" id="" value="'.$student['id'].'" ';
								if($student['classroom_id'] != null){
									$row .= "checked";
								}
								$row .= ' onchange="update_student_removed_set(this)"></td>';
								$row .= '<td class="text-center align-items-center"><a href="'.set_url("profile/student/".$student['id']).'" class="btn "><i title="profile" class="fas fa-user-circle profile-button"></i></a></td>';
								$row .= '</tr>';
								echo $row;
								$no++;
							}
						}else{
							echo "<tr class='w-100'>";
							echo "<td colspan=7 class=' bg-red'><p class='text-center w-100'>Students Not found...</p></td>";
							echo "</tr>";
						}

					 ?>
				</tbody>
			</table>

		</fieldset>
	</form>
	<hr class="w-100 mt-5 mb-3">
	<div class="d-flex flex-col col-12 align-items-center border">
		<div class=" w-75 d-flex flex-col align-items-center">
			<h2>Selected Students for Remove</h2>
			<hr class="topic-hr w-100">
		</div>
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