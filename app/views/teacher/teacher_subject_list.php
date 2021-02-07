
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
	
	<div class="col-8">
		<form method="post" class="col-12">
			<div class="col-12">
				<fieldset class="col-12">
					<legend>Teacher Info</legend>
					<div class="form-group">
						<label for="id">ID</label>
						<input type="text"  placeholder="Teacher ID" value="<?php if(isset($teacher_info['id'])){echo $teacher_info['id'];} ?>" disabled="disabled">
					</div>
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text"  placeholder="Teacher Name" value="<?php if(isset($teacher_info['name_with_initials'])){echo $teacher_info['name_with_initials'];} ?>"  disabled="disabled">
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
							$row .= "<td class='text-center'><a href='".set_url("teacher/subject/timetable/".$subjects[$i]['teacher_subject_id'])."' class='btn btn-blue t-d-none p-1'>timetable</a></td>";
							$row .="</tr>";
							echo $row;
						}
						$_SESSION['back'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					}else{
						echo "<tr><td colspan=9 class='text-center bg-red'>Subjects not found...</td></tr>";
					}
					echo "</tbody>";
					echo "</table>";
				 ?>
			</div>
		</div>
	</div>

	<hr class="w-100 mt-5">
	<div class="col-10">
		<div class="mt-5">
			<h2 style="color: darkblue;">Add/Remove Subjects</h2>
		</div>
		<hr class="w-100">
		<form action="<?php echo set_url('teacher/subject/list/'.$teacher_info['id'].''); ?>" method="post" class="col-12">
			<div class="col-12">
				<fieldset class="col-12">
					<legend>Subjects Info</legend>
					<!-- add some subjects dynamically -->
					<div  class="d-flex flex-col col-12 ">
						<div id="assign-subject">
							<input type="hidden" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_info['id'])){echo $teacher_info['id'];} ?>">
							<?php 
								if(isset($subjects) && !empty($subjects)){
									for ($i=1; $i <= count($subjects); $i++) {
										$sub = '<div  class="form-group d-flex flex-col border mb-5">
											<label>Subject-0'.$i.'</label>
											<div class=" d-flex flex-wrap justify-content-between"> 
												<input type="text" name="subject-0'.$i.'-id" id="subject-0'.$i.'-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data(\'id\',this)" value='.$subjects[$i-1]['id'].'>
												<input type="text" name="subject-0'.$i.'-code" id="subject-0'.$i.'-code" class="col-3  d-inline-block" placeholder="Subject Code"  oninput="get_subject_data(\'code\',this)" value='.$subjects[$i-1]['code'].'>
												<input type="text" name="subject-0'.$i.'-name" id="subject-0'.$i.'-name" class="col-3  d-inline-block" placeholder="Subject Name" disabled="disabled" value='.$subjects[$i-1]['name'].'>
												<input type="hidden" name="old-subject-0'.$i.'-id" id="old-subject-0'.$i.'-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data(\'id\',this)" value='.$subjects[$i-1]['id'].'>
											</div>
											<div class="w-100 justify-content-end d-flex pr-5">
												<button class="btn btn-blue" type="button" id="'.$subjects[$i-1]['id'].' '.$teacher_info['id'].'" onclick="teacher_subject_remove(this)" >- remove subject</button>
											</div>
										</div>';
										echo $sub;
													
									}
								}else{
									$sub = '<div  class="form-group d-flex flex-col border mb-5">
										<label>Subject-01</label>
										<div class=" d-flex flex-wrap justify-content-between"> 
											<input type="text" name="subject-01-id" id="subject-01-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data(\'id\',this)">
											<input type="text" name="subject-01-code" id="subject-01-code" class="col-3  d-inline-block" placeholder="Subject Code"  oninput="get_subject_data(\'code\',this)">
											<input type="text" name="subject-01-name" id="subject-01-name" class="col-3  d-inline-block" placeholder="Subject Name" disabled="disabled">
											<input type="hidden" name="old-subject-01-id" id="old-subject-01-id" class="col-3  d-inline-block" placeholder="Subject Name">
										</div>
										<div class="w-100 justify-content-end d-flex pr-5">
											<button class="btn btn-blue" type="button" onclick="teacher_subject_remove(this)" >- remove subject</button>
										</div>
									</div>';
									echo $sub;
								}
							 ?>
						</div>
						<div class="w-100 justify-content-end d-flex pr-5">
							<button class="btn btn-blue" type="button" onclick="teacher_subject_add('assign-subject',this)">+ Add subject</button>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="d-flex w-90 justify-content-end mt-5">
				<input type="submit" name="submit" value="submit" class="btn btn-blue">
			</div>
		</form>
	</div>

</div>
