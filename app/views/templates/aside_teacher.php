			<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start" >	
				<div class="d-md-flex flex-col d-none col-12 theme-sidebar" id="aside-nav-wrapper">
					<div id="aside-user-info" class=" d-flex flex-col m-3 p-2 text-center">
						<span>username : <?php if(isset($_SESSION['username'])){echo $_SESSION['username']; } ?></span>
						<span>role : <?php if(isset($_SESSION['role'])){echo $_SESSION['role']; } ?></span>
					</div> <!-- #aside-user-info -->
					<nav class="nav fs-18">
						<ul class="d-flex flex-col" id="aside_nav">
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('pages/admin.php'); ?>" class="nav-link active">Dashbord</a>
							</li>
							<li class="nav-item aside-li" id="admission-li"><a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=all'); ?>" class="nav-link">Admissions</a>
							</li>
							<li class="nav-item aside-li" id="attendance-li">
								<a href="<?php echo set_url('pages/teacher_attendance_view.php') ?>" class="nav-link">Attendance</a>
								<button class="toggle-button" target="attendance-nav">
									<img src="../img/close-menu.png" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="attendance-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('pages/teacher_attendance_view.php') ?>" parent-li="attendance-li" class="nav-link">My Attendance</a></li>
										<li class="nav-item"><a href="<?php echo set_url('pages/classroom_attendance_view.php') ?>" parent-li="attendance-li" class="nav-link">Mark classroom Attendance</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="student-li">
								<a href="<?php echo set_url('pages/student_list.php'); ?>" class="nav-link">Students</a>
								<button class="toggle-button" target="student-nav">
									<img src="../img/close-menu.png" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="student-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('pages/student_list.php'); ?>" class="nav-link"  parent-li="student-li">Students list</a></li>
										<li class="nav-item"  parent-li="student-li"><a href="#" class="nav-link">Students Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="teacher-li">
								<a href="<?php echo set_url('pages/teacher_list_view.php'); ?>" class="nav-link">Teachers</a>
								<button class="toggle-button" target="teacher-nav">
									<img src="../img/close-menu.png" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="teacher-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('pages/teacher_list_view.php'); ?>" class="nav-link" parent-li="teacher-li">Teachers List</a></li>
										<li class="nav-item"><a href="<?php echo set_url('pages/TComplaints.php') ?>" class="nav-link"  parent-li="teacher-li">Teachers Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="classroom-li"><a href="<?php echo set_url('pages/teacher_classroom_list_view.php') ?>" class="nav-link">Class Rooms</a>
								<button class="toggle-button" target="classroom-nav">
									<img src="../img/close-menu.png" width="20px" alt="">
								</button>

								<nav  id="classroom-nav" class="nav sub-nav no-collapsed">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('pages/teacher_classroom_list_view.php') ?>" class="nav-link" parent-li="classroom-li">Classroom list</a></li>
										<li class="nav-item"><a href="#" class="nav-link" parent-li="classroom-li">Class Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="subject-li">
								<a href="<?php echo set_url('pages/teacher_subject_list.php',array('teacher_id'=>$_SESSION['user_id'])); ?>" class="nav-link">My Subjects</a>
								<button class="toggle-button" target="subject-nav">
									<img src="../img/close-menu.png" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="subject-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item">
											<a href="<?php echo set_url('pages/teacher_subject_list.php',array('teacher_id'=>$_SESSION['user_id'])); ?>" class="nav-link" parent-li="subject-li">Subjects list</a></li>
										<li class="nav-item">
											<a href="#" class="nav-link" parent-li="subject-li">Subjects Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li id="interview-li" class="nav-item aside-li">
								<a href="<?php echo set_url('pages/teacher_interview_panel_view.php',array('interview-panel-id'=>$interview_panel_id));?>" class="nav-link">Interviews</a>
								<button class="toggle-button" target="interview-nav">
									<img src="<?php echo set_url('img/close-menu.png') ?>" width="20px">
								</button>
								<?php if(isset($interview_panel_id)){ ?>
									<div id="interview-nav" class="no-collapsed nav sub-nav">
										<ul class="d-flex flex-col">
											<li class="nav-item"><a href="<?php echo set_url('pages/teacher_interview_panel_view.php',array('interview-panel-id'=>$interview_panel_id));?>" class="nav-link"  parent-li="interview-li">My panels</a></li>
											<li class="nav-item">
												<a href="<?php echo set_url('pages/teacher_interview_list.php',array('interview_panel_id'=>$interview_panel_id)) ?>"  class="nav-link" parent-li="interview-li">Interview List</a>
											</li>
										</ul>
									</div>
								<?php } ?>
							</li>
						</ul>
					</nav>
				</div>
			</aside>