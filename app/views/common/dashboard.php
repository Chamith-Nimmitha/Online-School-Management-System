<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg) && !empty($msg)){
			echo "<p class='d-flex justify-content-center bg-lightgreen fb-green col-8 p-3'>";
			echo $msg;
			echo "</p>";
		} 
		if(isset($del_msg) && !empty($del_msg)){
			echo "<script>show_snackbar('{$del_msg}')</script>";
		}
	?>

	<div class="col-12 d-flex">
		<div id="school-statistics" class="flex-1 justify-content-center ">
			<h2 class="text-center p-5">School Statistics</h2>
			<div class="statistics-flex justify-content-center">	
				<div class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3" style="cursor: pointer;" onclick="window.open('<?php echo set_url('student/list')?>')">
					<i style="font-size: 40px" class="fas fa-user-graduate"></i><h3  class="bb pb-1 text-center">Total Students</h3>
					<span class="pt-1"><?php if(isset($count['student'])){echo $count['student']; } ?></span>
				</div> 
				<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3" style="cursor: pointer;" onclick="window.open('<?php echo set_url('teacher/list')?>')">
					<i style="font-size: 40px" class="fas fa-user-tie"></i><h3 class="bb pb-1 text-center">Total Teachers</h3>
					<span class="pt-1"><?php if(isset($count['teacher'])){echo $count['teacher']; } ?></span>
				</div> 
				<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3" style="cursor: pointer;" onclick="window.open('<?php echo set_url('subject/list')?>')">
					<i style="font-size: 40px" class="fas fa-book"></i><h3 class="bb pb-1  text-center">Total Subjects</h3>
					<span class="pt-1"><?php if(isset($count['subject'])){echo $count['subject']; } ?></span>
				</div> 
				<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3" style="cursor: pointer;" onclick="window.open('<?php echo set_url('classroom/list')?>')">
					<i style="font-size: 40px" class="fas fa-store-alt"></i><h3 class="bb pb-1  text-center">Total Classrooms</h3>
					<span class="pt-1"><?php if(isset($count['classroom'])){echo $count['classroom']; } ?></span>
				</div>
				<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3" style="cursor: pointer;" onclick="window.open('<?php echo set_url('parent/list')?>')">
					<i style="font-size: 40px" class="fas fa-user-shield"></i><h3 class="bb pb-1  text-center">Total Parents</h3>
					<span class="pt-1"><?php if(isset($count['parent'])){echo $count['parent']; } ?></span>
				</div>
				
			</div>
		</div> <!-- #school-statistics -->
		<div class="<?php if(!isset($notice_classroom_id) || empty($notice_classroom_id)){echo 'd-none';} ?>">
			<!-- ADD A NEW NOTICE -->
			<div id="add_new_classroom_notice" class="d-none">
				<div id="noticeboard_title" class="w-100">
					<button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('add_new_classroom_notice','classroom_notice_board')">Back</button>
					<h3>ADD NEW NOTICE</h3>
				</div>
				<div class="form-wrapper">
					<form method="POST" onSubmit="add_new_notice(this)" data-classroom="">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" placeholder="title">
						</div>
						<div class="form-group">
							<label for="img">Image</label>
							<input type="file" name="img" id="img" placeholder="Image">
						</div>
						<div class="form-group">
							<label for="description">Discription</label>
							<textarea name="description" id="description" class="w-100 p-2"  rows="2"></textarea>
						</div>
						<div class="form-group">
							<label for="expire_date">Expire Date</label>
							<input type="date" name="expire_date" id="expire_date" value="<?php echo date("Y-m-d"); ?>">
						</div>
						<div class="w-100 d-flex justify-content-end">
							<input type="submit" value="Save" class="btn btn-blue">
						</div>
					</form>
				</div>
			</div>
			<!-- ADD A NEW NOTICE -->

			<!-- UPDATE NOTICE -->
			<div id="update_classroom_notice" class="d-none">
				<div id="noticeboard_title" class="w-100">
					<button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('update_classroom_notice','classroom_notice_board')">Back</button>
					<h3>UPDATE NOTICE</h3>
					<a href="" class="btn btn-blue p-0 pr-2 pl-2 mr-2 mr-2" onclick="delete_notice(this,'Delete Message','Are you sure?')">Del</a>
				</div>
				<div class="form-wrapper">
					<form action="" method="POST" data-classroom="" data-notice="" onSubmit="update_notice(this)">
						<p class="text-center" id="form_state"></p>
						<div class="form-group p-0 pr-2 pl-2">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" placeholder="title">
						</div>
						<div class="form-group  p-0 pr-2 pl-2">
							<label for="img">Image</label>
							<input type="file" name="img" id="img" placeholder="Image">
						</div>
						<div class="form-group  p-0 pr-2 pl-2">
							<label for="description">Discription</label>
							<textarea name="description" id="description" class="w-100 p-2"  rows="2"></textarea>
						</div>
						<div class="form-group  p-0 pr-2 pl-2">
							<label for="expire_date">Image</label>
							<input type="date" name="expire_date" id="expire_date" value="">
						</div>
						<div class="w-100 d-flex justify-content-end">
							<input type="submit" value="Save" class="btn btn-blue">
						</div>
					</form>
				</div>
			</div>
			<!--END OF UPDATE NOTICE -->

			<!-- NOTICE BOARD -->
			<div class="col-12" id="classroom_notice_board">
				<!-- NOTICE 1 -->
				<input type="hidden" name="notice_classroom_id" id="notice_classroom_id" value="<?php if(isset($notice_classroom_id)){echo $notice_classroom_id;} ?>">
				<?php 
					if(isset($classroom_notices) && !empty($classroom_notices)){
						for($i=0; $i<count($classroom_notices);$i++) {
							if($i == 0){
								echo '<div data-index="'.$i.'" data-notice="'.$classroom_notices[$i]["id"].'" class="notice d-block col-12">';
							}else{
								echo '<div data-index="'.$i.'" data-notice="'.$classroom_notices[$i]["id"].'" class="notice col-12 d-none">';
							}
							?>
								<div id="noticeboard_title" class="w-100">
									<h3><?php echo $classroom_notices[$i]['title']; ?></h3>
									<?php if($is_classroom_teacher===1){ ?>
										<button type="button" class="btn btn-blue p-1 mr-2" onclick="add_new_form('classroom_notice_board','add_new_classroom_notice')">Add</button>
										<button type="button" class="btn btn-blue p-1 mr-2" onclick="update_form('classroom_notice_board','update_classroom_notice')">View</button>
									<?php } ?>
								</div>
								<div class="noticeboard_content_wrapper">
									<div id="noticeboard_content" class="col-12">
										<?php if(!empty($classroom_notices[$i]['image'])){ ?>
										<img src="<?php echo set_url("public/assets/img/classroom_notice/".$classroom_notices[$i]['image']); ?>"  alt="">
										<?php } ?>
										<div class="content">
											<?php echo $classroom_notices[$i]['description']; ?>
										</div>
									</div>
								</div>
							</div>
					<?php 
						}
					}else{?>
						<div data-index="0" class="notice d-block col-12 d-block">
							<div id="noticeboard_title" class="w-100">
								<h3>NOTICE NOT FOUND</h3>
								<button type="button" class="btn btn-blue p-1 mr-2" onclick="add_new_form('classroom_notice_board','add_new_classroom_notice')">Add</button>
							</div>
							<div class="noticeboard_content_wrapper">
								<div id="noticeboard_content" class="col-12">
									<div class="content">
										<p>No any updates...</p>
									</div>
								</div>
							</div>
						</div>
				<?php } ?>	
				<div id="noticeboard_controls" class="col-12 d-flex justify-content-center align-items-center">
					<div id="pre_btn">
						<button>Pre</button>
					</div>
					<div id="indicators" class="controls d-flex">
						<?php 
						if(isset($classroom_notices) && !empty($classroom_notices)){
							for($i=0; $i< count($classroom_notices); $i++) {
								if($i==0){
									echo '<button data-index="'.$i.'" class="notice_active"></button>';
								}else{
									echo '<button data-index="'.$i.'"></button>';
								}
							}
						}
						?>
					</div>
					<div id="next_btn">
						<button>Next</button>
					</div>
				</div>
			</div>
			<!-- END OF NOTICE BOARD -->
		</div>
	</div>

	<div id="school-attendance" class="col-12 d-flex flex-col align-items-center section-wrapper p-5 mt-5">
		<h2 class="text-center p-5">School Attendance</h2>
		<div class="col-12 d-flex justify-content-center">
			<form id="dashboard_attendance_filter">
				<div class="d-flex align-items-center">
					<label for="date">Date</label>
					<input type="date" name="date" value="<?php if(isset($date)){ echo $date;}else{echo date('Y-m-d');} ?>" onchange="load_dashboard_attendacne()" id="date" class="ml-3 p-2">
				</div>
			</form>
		</div>
		<div class="col-12 d-flex align-items-center mt-5 justify-content-around">
			<div class="bg-white p-5 section-item" style="position: relative;width: 45%;">
				<div class="loader" id="dashboard_student_attendance_doughnut_loader">
				 	<div class="col-12">
						<div id="one"><div></div></div>
						<div id="two"><div></div></div>
						<div id="three"><div></div></div>
						<div id="four"><div></div></div>
						<div id="five"></div>
				 	</div>
				</div>
				<canvas id="dashboard_student_attendance_doughnut" width="100" height="100"></canvas>
			</div>
			<div class="bg-white p-5 section-item" style="position: relative; width: 45%;">
				<div class="loader" id="dashboard_teacher_attendance_doughnut_loader">
				 	<div class="col-12">
						<div id="one"><div></div></div>
						<div id="two"><div></div></div>
						<div id="three"><div></div></div>
						<div id="four"><div></div></div>
						<div id="five"></div>
				 	</div>
				</div>
				<canvas id="dashboard_teacher_attendance_doughnut" width="100" height="100"></canvas>
			</div>
		</div>
	</div> <!-- #school-attendance -->

	<div class="d-flex flex-row col-12 justify-content-around  mt-5 pb-5 section-wrapper" style="flex-direction: row !important">
		<!-- classroom student attendance -->
		<div class="mt-5 section-item" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="dashboard_classroom_student_attendance_bar" width="100" height="100"></canvas>
			</div>
		</div>

		<!-- school teacher attendance -->
		<div class="mt-5  section-item" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="dashboard_teacher_attendance_bar" width="100" height="100"></canvas>
			</div>
		</div>
	</div>
	<div class="col-12 justify-content-around section-wrapper pb-5 mt-5" style="flex-direction: row !important;">
		<!-- subject grades pie -->
		<div class="mt-5 section-item" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="subject_grades_pie" width="100" height="100"></canvas>
			</div>
		</div>

		<!-- classroom student attendance -->
		<div class="mt-5  section-item" style="width: 45%;">
			<div class="bg-white p-5 w-100">
				<canvas id="student_result_overview_bar" width="100" height="100"></canvas>
			</div>
		</div>
	</div>

</div> <!-- #content -->