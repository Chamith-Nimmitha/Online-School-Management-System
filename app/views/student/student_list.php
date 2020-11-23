<?php include_once("session.php"); ?>
<?php require_once("../php/database.php"); ?>
<?php require_once("../php/pagination.php"); ?>

<?php

	if(isset($_GET['delete'])){
		$con->update("student",array("is_deleted"=>1),array("id"=>$_GET['delete']));
	}

	$start = 0;
	$per_page = 1;
	if(isset($_GET['per_page'])){
		$per_page=$_GET['per_page'];
	}
	if(isset($_GET['page'])){
		$start = (($_GET['page'] -1) * $per_page );
	}else{
		$_GET['page'] =1;
	}

	$required_fields = "`s`.*, `c`.`class`";

	require_once ("../php/classes/students_info.class.php");

	$obj = new StudentsInfo($start, $per_page);

	if(!isset($_GET['student-id']) || empty($_GET['student-id'])){
		if(isset($_GET['grade']) && $_GET['grade'] != 'all'){
			if(isset($_GET['class']) && $_GET['class'] != 'all'){
				$result_set = $obj->get_student_list(null,null,$_GET['grade'],$_GET['class']);
			}else{
				$result_set = $obj->get_student_list(null,null,$_GET['grade']);
			}
		}else{
			if(isset($_GET['class']) && $_GET['class'] != 'all'){
				$result_set = $obj->get_student_list(null,null,null,$_GET['class']);
			}else{
				$result_set = $obj->get_student_list();
			}
		}
	}else{
		if(isset($_GET['grade']) && $_GET['grade'] != 'all'){
			if(isset($_GET['class']) && $_GET['class'] != 'all'){
				$result_set = $obj->get_student_list($_GET['student-id'],null ,$_GET['grade'],$_GET['class']);
			}else{
				$result_set = $obj->get_student_list($_GET['student-id'],null,$_GET['grade']);
			}
		}else{
			if(isset($_GET['class']) && $_GET['class'] != 'all'){
				$result_set = $obj->get_student_list($_GET['student-id'],null,null,$_GET['class']);
			}else{
				$result_set = $obj->get_student_list($_GET['student-id']);
			}
		}
	}
	$count = $obj->get_pre_query_count();

 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="student-header mt-5">
		<h2 class="fs-30">Student List</h2>
	</div> <!-- .student-header -->
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('pages/student_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="studebt-id">Student ID</label>
						<input type="text" name="student-id" id="student-id" placeholder="Student ID" value="<?php if(isset($_GET['student-id'])){echo $_GET['student-id'];} ?>" oninput="get_student_data('student-list-table','student-id','','grade','class', <?php echo $per_page; ?>)">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="grade" class="mr-3 d-normal">Grade : </label>
						<select name="grade" id="grade" style="width: 100px">
							<option value="all" <?php if(isset($_GET['grade'])){if($_GET['grade'] == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
							<option value="1" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "1")){echo 'selected="selected"';} ?> >1</option>
							<option value="2" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "2")){echo 'selected="selected"';} ?> >2</option>
							<option value="3" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "3")){echo 'selected="selected"';} ?> >3</option>
							<option value="4" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "4")){echo 'selected="selected"';} ?> >4</option>
							<option value="5" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "5")){echo 'selected="selected"';} ?> >5</option>
							<option value="6" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "6")){echo 'selected="selected"';} ?> >6</option>
							<option value="7" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "7")){echo 'selected="selected"';} ?> >7</option>
							<option value="8" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "8")){echo 'selected="selected"';} ?> >8</option>
							<option value="9" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "9")){echo 'selected="selected"';} ?> >9</option>
							<option value="10" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "10")){echo 'selected="selected"';} ?> >10</option>
							<option value="11" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "11")){echo 'selected="selected"';} ?> >11</option>
							<option value="12" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "12")){echo 'selected="selected"';} ?> >12</option>
							<option value="13" <?php if(isset($_GET['grade']) && ($_GET['grade'] == "13")){echo 'selected="selected"';} ?> >13</option>
						</select>
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">Class:</label>
						<select name="class" id="class">
							<option value="all" <?php if(isset($_GET['class']) && ($_GET['class'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="A" <?php if(isset($_GET['class']) && ($_GET['class'] == "A")){echo 'selected="selected"';} ?> >A</option>
							<option value="B" <?php if(isset($_GET['class']) && ($_GET['class'] == "B")){echo 'selected="selected"';} ?> >B</option>
							<option value="C" <?php if(isset($_GET['class']) && ($_GET['class'] == "C")){echo 'selected="selected"';} ?> >C</option>
							<option value="D" <?php if(isset($_GET['class']) && ($_GET['class'] == "D")){echo 'selected="selected"';} ?> >D</option>
							<option value="E" <?php if(isset($_GET['class']) && ($_GET['class'] == "E")){echo 'selected="selected"';} ?> >E</option>
							<option value="F" <?php if(isset($_GET['class']) && ($_GET['class'] == "F")){echo 'selected="selected"';} ?> >F</option>
							<option value="G" <?php if(isset($_GET['class']) && ($_GET['class'] == "G")){echo 'selected="selected"';} ?> >G</option>
							<option value="H" <?php if(isset($_GET['class']) && ($_GET['class'] == "H")){echo 'selected="selected"';} ?> >H</option>
						</select>				
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>
		<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
			<?php 
				$table = "<table class='table-strip-dark'>
							<caption class=\"p-5\">";
				 if(isset($_GET['grade'])){ 
				 	$table .= " Grade ".$_GET['grade'];
				 }
				$table .= " Students</caption>";
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
						$row .= "<td class='text-center'><a href='admin_student_timetable_view.php?student_id=".$result['id']."' class='btn btn-blue t-d-none p-1'>timetable</a></td>";
						$row .= "<td class='text-center'><a href='admin_student_profile.php?student-id=".$result['id']."' class='btn btn-blue t-d-none p-1'>profile</a></td>";
						$row .= "<td class='text-center'><a href='student_marks_report.php?student-id=".$result['id']."' class='btn btn-blue t-d-none p-1'>Marks</a></td>";
						if($_SESSION['role'] !== "teacher"){
							$row .= "<td class='text-center'><a href='student_list.php?delete=".$result['id']."' class='btn btn-lightred t-d-none p-1'>delete</a></td>";
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
			<p class="mt-3 pl-5"><code id="record_count"><?php 	echo $count; ?> results found.</code> </p>	
			<div id="pagination-div">
				<?php display_pagination($count,$_GET['page'],$per_page); ?>
			</div>
	</div>
</div>

<?php require_once("../templates/footer.php"); ?>
