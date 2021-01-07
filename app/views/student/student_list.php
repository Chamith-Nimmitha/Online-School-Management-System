<script>
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
</script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="student-header mt-5">
	<center>
	    <form method="POST" enctype="multipart/form-data">
            <br/><br/><br/>
            <div align="center">
                <label>Select a File:</label>
                <input type="file" name="file"/>
                <br/>
                <input type="submit" name="submit" value="Import"  class="btn btn-info"/>
            </div>
        </form>

	</center>
		<h2 class="fs-30">Student List</h2>
	</div> <!-- .student-header -->
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('student/list'); ?>" method="POST" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="studebt-id">Student ID</label>
						<input type="text" name="student-id" id="student-id" placeholder="Student ID" value="<?php if(isset($student_id)){echo $student_id;} ?>" oninput="student_search()">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="grade" class="mr-3 d-normal">Grade : </label>
						<select name="grade" id="grade" style="width: 100px">
							<option value="all" <?php if(isset($grade)){if($grade == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
							<option value="1" <?php if(isset($grade) && ($grade == "1")){echo 'selected="selected"';} ?> >1</option>
							<option value="2" <?php if(isset($grade) && ($grade == "2")){echo 'selected="selected"';} ?> >2</option>
							<option value="3" <?php if(isset($grade) && ($grade == "3")){echo 'selected="selected"';} ?> >3</option>
							<option value="4" <?php if(isset($grade) && ($grade == "4")){echo 'selected="selected"';} ?> >4</option>
							<option value="5" <?php if(isset($grade) && ($grade == "5")){echo 'selected="selected"';} ?> >5</option>
							<option value="6" <?php if(isset($grade) && ($grade == "6")){echo 'selected="selected"';} ?> >6</option>
							<option value="7" <?php if(isset($grade) && ($grade == "7")){echo 'selected="selected"';} ?> >7</option>
							<option value="8" <?php if(isset($grade) && ($grade == "8")){echo 'selected="selected"';} ?> >8</option>
							<option value="9" <?php if(isset($grade) && ($grade == "9")){echo 'selected="selected"';} ?> >9</option>
							<option value="10" <?php if(isset($grade) && ($grade == "10")){echo 'selected="selected"';} ?> >10</option>
							<option value="11" <?php if(isset($grade) && ($grade == "11")){echo 'selected="selected"';} ?> >11</option>
							<option value="12" <?php if(isset($grade) && ($grade == "12")){echo 'selected="selected"';} ?> >12</option>
							<option value="13" <?php if(isset($grade) && ($grade == "13")){echo 'selected="selected"';} ?> >13</option>
						</select>
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">Class:</label>
						<select name="class" id="class">
							<option value="all" <?php if(isset($class) && ($class == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="A" <?php if(isset($class) && ($class == "A")){echo 'selected="selected"';} ?> >A</option>
							<option value="B" <?php if(isset($class) && ($class == "B")){echo 'selected="selected"';} ?> >B</option>
							<option value="C" <?php if(isset($class) && ($class == "C")){echo 'selected="selected"';} ?> >C</option>
							<option value="D" <?php if(isset($class) && ($class == "D")){echo 'selected="selected"';} ?> >D</option>
							<option value="E" <?php if(isset($class) && ($class == "E")){echo 'selected="selected"';} ?> >E</option>
							<option value="F" <?php if(isset($class) && ($class == "F")){echo 'selected="selected"';} ?> >F</option>
							<option value="G" <?php if(isset($class) && ($class == "G")){echo 'selected="selected"';} ?> >G</option>
							<option value="H" <?php if(isset($class) && ($class == "H")){echo 'selected="selected"';} ?> >H</option>
						</select>				
					</div>
					<button onclick="student_search()" class="btn btn-blue ml-3 mt-5">Filter</button>
				</div>
			</form>
		</div>
		<div class="mt-5 col-12 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
			<div class="loader hide-loader">
			 	<div class="col-12">
					<div id="one"><div></div></div>
					<div id="two"><div></div></div>
					<div id="three"><div></div></div>
					<div id="four"><div></div></div>
					<div id="five"></div>
			 	</div>
			</div>
			<?php 
				$table = "<table class='table-strip-dark'>";
				$table .= "<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Grade</th>
									<th>Class</th>
									<th>Phone</th>
									<th>Is_deleted</th>
									<th>Timetable</th>
									<th>Profile</th>
									<th>Exam Report</th>";
									if($_SESSION['role'] !== "teacher"){
										$table .="<th>Delete</th>";
									}
								$table .= "</tr>
							</thead>
							<tbody id='student-list-table'>";
				echo $table;
				if($result_set){
					foreach ($result_set as $result) {
						$row ="<tr>";
						$row .= "<td>".$result['id']."</td>";
						$row .= "<td>".$result['name_with_initials']."</td>";
						$row .= "<td class='text-center'>".$result['grade']."</td>";
						$row .= "<td class='text-center'>".$result['class']."</td>";
						$row .= "<td>".$result['contact_number']."</td>";
						$row .= "<td class='text-center'>".$result['is_deleted']."</td>";
						$row .= "<td class='text-center'><a href='timetable/view/".$result['id']."' class='btn btn-blue t-d-none p-1'>timetable</a></td>";
						$row .= "<td class='text-center'><a href='".set_url("profile/student/".$result['id'])."' class='btn btn-blue t-d-none p-1'>profile</a></td>";
						$row .= "<td class='text-center'><a href='".set_url("student/exam/".$result['id'])."' class='btn btn-blue t-d-none p-1'>Marks</a></td>";
						if($_SESSION['role'] !== "teacher"){
							$row .= "<td class='text-center'><a href='".set_url("student/delete/".$result['id'])."' class='btn t-d-none p-1' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a></td>";
						}
						$row .="</tr>";

						echo $row;
					}
					$_SESSION['back'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}else{
					echo "<tr><td colspan=10 class='text-center bg-red'>Students not found...</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			 ?>
		</div>
		<div id="pagination" class="col-12">
			<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "student/list","student_search"); ?>
			</div>
		</div>
        <br>
		<center>
		    <div>
                <a class="btn btn-blue" onClick="window.print()">Download as a PDF</a>
		    </div>
		</center>

	</div>
</div>
