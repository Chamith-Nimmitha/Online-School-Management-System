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

	<div class="mt-5  w-75 d-flex flex-col align-items-center">
	    <h2 class="pt-3 pb-3">Classroom Students</h2>
	    <hr class="topic-hr w-100">
	</div>

	<form action="classroom_student.php" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Classroom Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Classroom ID</label>
				<input type="text" placeholder="Classroom ID" value="<?php if(!empty($classroom_info)){echo $classroom_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<input type="text" name="grade" placeholder="Grade" value="<?php if(!empty($classroom_info)){echo $classroom_info['grade'];} ?>" disabled="disable">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Class</label>
				<input type="text" name="class" placeholder="Class" value="<?php if(!empty($classroom_info)){echo $classroom_info['class'];} ?>" disabled="disable">
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