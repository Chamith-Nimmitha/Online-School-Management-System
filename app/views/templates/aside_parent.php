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
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('parent/student/list'); ?>" class="nav-link">Students List</a>
							</li>
							<li class="nav-item aside-li" id="attendance-li">
								<a href="<?php echo set_url('parent/student/attendance'); ?>" class="nav-link">Student Attendance</a>
								<button class="toggle-button" target="attendance-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="attendance-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('parent/student/attendance'); ?>" parent-li="attendance-li" class="nav-link">Students Attendance</a></li>
										<li class="nav-item"><a href="#" class="nav-link">Attendance Complaint</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="timetable-li">
								<a href="<?php echo set_url('parent/student/timetable');?>" class="nav-link">Students Timetable</a>
							</li>
							
							<li class="nav-item aside-li" id="exam-result-li">
								<a href="<?php echo set_url('parent/student/exam'); ?>" class="nav-link">Exam Result</a>
								<button class="toggle-button" target="exam-result-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="exam-result-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('parent/student/exam'); ?>" class="nav-link" parent-li="exam-result-li">Results</a></li>
										<li class="nav-item"><a href="<?php echo set_url('pages/TComplaints.php') ?>" class="nav-link"  parent-li="exam-result-li">Result Complaints</a></li>
									</ul>
								</nav>
							</li>
						</ul>
					</nav>
				</div>
			</aside>