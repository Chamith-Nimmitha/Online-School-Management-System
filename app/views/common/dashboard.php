<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg)){
			echo "<p class='d-flex justify-content-center bg-lightgreen fb-green col-8 p-3'>";
			echo $msg;
			echo "</p>";
		}  
	?>

	<div class="col-12 d-flex">
		<div id="school-statistics" class="col-8  justify-content-center ">
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
		<div class="col-4">
			<!-- ADD A NEW NOTICE -->
			<div id="add_new_classroom_notice" class="col-12 d-none">
				<div id="noticeboard_title" class="w-100">
					<button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('add_new_classroom_notice','classroom_notice_board')">Back</button>
					<h3>ADD NEW NOTICE</h3>
				</div>
				<div class="form-wrapper">
					<form action="" method="POST">
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
							<textarea name="description" id="description" class="w-100 p-2"  rows="7"></textarea>
						</div>
						<div class="w-100 d-flex justify-content-end">
							<input type="submit" value="Save" class="btn btn-blue">
						</div>
					</form>
				</div>
			</div>
			<!-- ADD A NEW NOTICE -->

			<!-- UPDATE NOTICE -->
			<div id="update_classroom_notice" class="col-12 d-none">
				<div id="noticeboard_title" class="w-100">
					<button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('update_classroom_notice','classroom_notice_board')">Back</button>
					<h3>UPDATE NOTICE</h3>
					<a href="" class="btn btn-blue p-0 pr-2 pl-2 mr-2 mr-2" onclick="delete_notice(this,'Delete Message','Are you sure?')">Del</a>
				</div>
				<div class="form-wrapper">
					<form action="" method="POST">
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
							<textarea name="description" id="description" class="w-100 p-2"  rows="7"></textarea>
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
				<div data-index="0" class="notice d-block col-12 d-block">						
					<div id="noticeboard_title" class="w-100">
						<h3>NOTICE ONE</h3>
						<button type="button" class="btn btn-blue p-1 mr-2" onclick="add_new_notice('classroom_notice_board','add_new_classroom_notice')">Add</button>
						<button type="button" class="btn btn-blue p-1 mr-2" onclick="update_notice('classroom_notice_board','update_classroom_notice')">View</button>
					</div>
					<div class="noticeboard_content_wrapper">
						<div id="noticeboard_content" class="col-12">
							<!-- <img src="<?php echo set_url("public/assets/img/notice_images/note1.jpg"); ?>"  alt=""> -->
							<div class="content">
								It gives me immense pleasure to welcome you to our new website. which is a testament to our achievements since 1995. We are proud of our past and passionate about our future and look forward to continuing our success as the leading mix school in the region.Siridhamma College offers her students a range of over 30 different sports in which they can participate.
							</div>
						</div>
					</div>
				</div>
				<!-- NOTICE 2 -->
				<div data-index="1" class="d-none notice col-12">						
					<div id="noticeboard_title" class="w-100">
						<h3>NOTICE TWO</h3>
						<button type="button" class="btn btn-blue p-1 mr-2" onclick="add_new_notice('classroom_notice_board','add_new_classroom_notice')">Add</button>
						<button type="button" class="btn btn-blue p-1 mr-2" onclick="update_notice('classroom_notice_board','update_classroom_notice')">View</button>
					</div>
					<div class="noticeboard_content_wrapper">
						<div id="noticeboard_content" class="col-12">
							<img src="<?php echo set_url("public/assets/img/notice_images/note1.jpg"); ?>"  alt="">
							<div class="content">
								The school was named as Siridhamma College for respecting to the monk, who was first graduated monk in Oxford university Honorable Thero Labuduwe Siridhamma.The School started with 90 students and one building. Then it took students also to the grade 6 from the Grade 5 Scholarship Test and grow up school students. With the growth of school and it became more and more popular in country.
							</div>
						</div>
					</div>
				</div>
				<div id="noticeboard_controls" class="col-12 d-flex justify-content-center align-items-center">
					<div id="pre_btn">
						<button>Pre</button>
					</div>
					<div id="indicators" class="controls d-flex">
						<button data-index="0" class="notice_active"></button>
						<button data-index="1"></button>
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