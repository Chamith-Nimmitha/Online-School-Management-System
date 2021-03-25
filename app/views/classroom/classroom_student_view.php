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
		<div class="col-10 flex-col">
			
			<legend class="p-5">Student List</legend>
			<table class="table-strip-dark mb-5 w-100" style="">
				<thead class="w-100">
					<tr class="">
						<th class="">No</th>
						<th class="">ID</th>
						<th class="">Name</th>
						<?php if($_SESSION['role'] != "student" && $_SESSION['role'] != "parent" ){ ?>
							<th class="">Email</th>
							<th class="">Contact Number</th>
						<?php } ?>
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

								if($_SESSION['role'] != "student" && $_SESSION['role'] != "parent" ){
									$row .= '<td class=" word-break">'.$student['email'].'</td>';
									$row .= '<td class="  word-break">'.$student['contact_number'].'</td>';
								}
								$row .= '</tr>';
								echo $row;
								$no++;
							}
						}else{
							echo "<tr class='w-100'>";
							echo "<td colspan=6 class='w-100 bg-red'><p class='text-center w-100'>Students Not found...</p></td>";
							echo "</tr>";
						}

					 ?>
				</tbody>
			</table>
		</div>
	</form>
</div>