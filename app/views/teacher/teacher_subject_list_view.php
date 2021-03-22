
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='bg-red fg-white w-75 text-center p-2'>";
			echo $error."<br/>";
			echo "</p>";
		}
		if(isset($info) && !empty($info)){
			echo "<p class='bg-green fg-white w-75 text-center p-2'>";
			echo $info."<br/>";
			echo "</p>";
		}
	 ?>

	 <div class="mt-5  w-75 d-flex flex-col align-items-center">
	    <h2 class="pt-3 pb-3">Teacher Subject List View</h2>
	    <hr class="topic-hr w-100">
	</div>
	
	<div class="col-8">
		<form method="post" class="col-12">
			<div class="col-12">
				<fieldset class="col-12">
					<legend>Teacher Info</legend>
					<div class="form-group">
						<label for="id">ID</label>
						<input type="text" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_info['id'])){echo $teacher_info['id'];} ?>" disabled="disabled">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" placeholder="Teacher Name" value="<?php if(isset($teacher_info['name_with_initials'])){echo $teacher_info['name_with_initials'];} ?>"  disabled="disabled">
					</div>
				</fieldset>
			</div>
		</form>
	</div>

	<hr class="w-100 mt-5">
	<div class="col-10">
		<?php if(isset($_GET['teacher_id'])){?>
			<div class="pt-5">
				<h2 style="color: darkblue;">Teacher Subject List</h2>
			</div>
		<?php }else{ ?>
			<div class="pt-5">
				<h2 style="color: darkblue;">My Subject List</h2>
			</div>
		<?php } ?>

		<hr class="w-100">
		<div class="p-5 col-12 col-md-12 text-center">
			<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
				<?php 
					$table = "<table class='table-strip-dark'>";
					$table .= "<thead>
									<tr>
										<th>Subject ID</th>
										<th>Name</th>
										<th>Code</th>
										<th>Grade</th>
										<th>Student List</th>
										<th>Timetable</th>
									</tr>
								</thead>
								<tbody>";
					echo $table;
					if($subjects){
						for($i=0; $i < count($subjects);$i++) {
							$row ="<tr>";
							$row .= "<td>".$subjects[$i]['id']."</td>";
							$row .= "<td>".$subjects[$i]['name']."</td>";
							$row .= "<td>".$subjects[$i]['code']."</td>";
							$row .= "<td class='text-center'>".$subjects[$i]['grade']."</td>";
							$row .= "<td class='text-center'><a href='/mymvc/teacher/subject/student/list/".$subjects[$i]['teacher_subject_id']."' class='btn btn-blue t-d-none p-1'>List</a></td>";
							$row .= "<td class='text-center'><a href='".set_url('teacher/subject/timetable/'.$subjects[$i]['teacher_subject_id'])."' class='btn btn-blue t-d-none p-1'>timetable</a></td>";
							$row .="</tr>";
							echo $row;
						}
						$_SESSION['back'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					}else{
						echo "<tr><td colspan=9 class='text-center bg-red'>Students Not Found...</td></tr>";
					}
					echo "</tbody>";
					echo "</table>";
				 ?>
			</div>
		</div>
	</div>

	<hr class="w-100 mt-5">

</div>
<?php //require_once("../templates/footer.php"); ?>