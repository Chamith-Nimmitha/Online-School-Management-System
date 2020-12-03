
			<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start" >
				<div class="d-md-flex flex-col d-none col-12 theme-sidebar" id="aside-nav-wrapper">
					<div id="aside-user-info" class=" d-flex flex-col m-3 p-2 text-center">
						<span>username : <?php if(isset($_SESSION['username'])){echo $_SESSION['username']; } ?></span>
						<span>role : <?php if(isset($_SESSION['role'])){echo $_SESSION['role']; } ?></span>
					</div> <!-- #aside-user-info -->
					<nav class="nav fs-18">
						<ul class="d-flex flex-col" id="aside_nav">
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('dashboard'); ?>" class="nav-link active">Dashbord</a>
							</li>
							<li class="nav-item aside-li" id="attendance-li">
								<a href="<?php echo set_url('student/attendance'); ?>" class="nav-link">Student Attendance</a>
								<button class="toggle-button" target="attendance-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="attendance-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('student/attendance/'.$_SESSION['user_id']); ?>" parent-li="attendance-li" class="nav-link">Students Attendance</a></li>
										<li class="nav-item"><a href="#" class="nav-link">Attendance Complaint</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="timetable-li">
								<a href="<?php echo set_url('student/timetable/view');?>" class="nav-link">Student Timetable</a>
								<button class="toggle-button" target="timetable-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>
								<nav class="nav sub-nav no-collapsed" id="timetable-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('student/timetable/view');?>" parent-li="timetable-li" class="nav-link">Students Timetable</a></li>
										<li class="nav-item"><a href="#" class="nav-link">Timetable Complaint</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="classroom-li"><a href="<?php echo set_url('classroom/student/list') ?>" class="nav-link">My Classroom</a>
								<button class="toggle-button" target="classroom-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>

								<nav  id="classroom-nav" class="nav sub-nav no-collapsed">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('classroom/student/list') ?>" class="nav-link" parent-li="classroom-li">Student list</a></li>
										<li class="nav-item"><a href="#" class="nav-link" parent-li="classroom-li">Class Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="subject-li">
								<a href="<?php echo set_url('student/subject/list') ?>" class="nav-link">My Subjects</a>
								<button class="toggle-button" target="subject-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="subject-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item">
											<a href="<?php echo set_url('student/subject/list') ?>" class="nav-link" parent-li="subject-li">Subjects list</a></li>
										<li class="nav-item">
											<a href="#" class="nav-link" parent-li="subject-li">Subjects Complaints</a></li>
									</ul>
								</nav>
							</li>
							
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('student/view/parent/'.$parent_id); ?>" class="nav-link">Parent Info</a>
							</li>
							<li class="nav-item aside-li" id="exam-result-li">
								<a href="<?php echo set_url('student/exam'); ?>" class="nav-link">Exam Result</a>
								<button class="toggle-button" target="exam-result-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="exam-result-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('student/exam'); ?>" class="nav-link" parent-li="exam-result-li">Results</a></li>
										<li class="nav-item"><a href="<?php echo set_url('pages/TComplaints.php') ?>" class="nav-link"  parent-li="exam-result-li">Result Complaints</a></li>
									</ul>
								</nav>
							</li>
						</ul>
					</nav>
				</div>
			</aside>