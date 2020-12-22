			<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start" >
				<!-- for small devices -->
				<!-- <div class="d-md-none flex-col align-items-center bg-blue">
					<ul class="" id="aside-nav-xm-ul">
						<li class="nav-item aside-xm-li" id="admission-xm-li"><a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=all') ?>" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da" ></a>
							<nav class="nav sub-nav no-collapsed theme-darkblue" id="admission-xm-nav">
								<ul class="d-flex flex-col">
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=all') ?>" class="nav-link" parent-li="admission-xm-li">All Admissions</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=unread') ?>" class="nav-link" parent-li="admission-xm-li">Unread Admissions</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=read') ?>"  class="nav-link" parent-li="admission-xm-li">Read Admissions</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=accepted') ?>"  class="nav-link" parent-li="admission-xm-li">Accepted Admissions</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=rejected') ?>"  class="nav-link" parent-li="admission-xm-li">Rejected Admissions</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=registered') ?>"  class="nav-link" parent-li="admission-xm-li">registered Admissions</a>
									</li>
									<li class="nav-item">
										<a href="<?php echo set_url('pages/admissions_all.php?aside-link-selector=deleted') ?>"  class="nav-link" parent-li="admission-xm-li">Deleted Admissions</a>
									</li>
								</ul>
							</nav>
						</li>
						<li class="nav-item aside-xm-li" id="teacher-xm-li"><a href="<?php echo set_url('pages/admissions_all.php?admission-search=all') ?>" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a>
							<nav class="nav sub-nav no-collapsed theme-darkblue" id="teacher-xm-nav">
								<ul class="d-flex flex-col">
									<li class="nav-item"><a href="#" class="nav-link" parent-li="teacher-xm-li">Teachers Attendance</a></li>
									<li class="nav-item"><a href="<?php echo set_url('pages/teachers_timetables.php') ?>" class="nav-link" parent-li="teacher-xm-li">Teachers Timetables</a></li>
									<li class="nav-item"><a href="<?php echo set_url('pages/admission_teachers.php') ?>" class="nav-link">Teachers list</a></li>
									<li class="nav-item"><a href="#" class="nav-link">Teachers Complaints</a></li>
								</ul>
							</nav>
						</li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
						<li class="nav-item"><a href="" class="nav-link"><img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" alt="da"></a></li>
					</ul>
				</div>
					 -->
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
							<li class="nav-item aside-li" id="admission-li"><a href="<?php echo set_url('admission/list'); ?>" class="nav-link">Admissions</a>
							</li>
							<li class="nav-item aside-li" id="attendance-li">
								<a href="<?php echo set_url('attendance/classroom/list'); ?>" class="nav-link">Attendance</a>
								<button class="toggle-button" target="attendance-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="attendance-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('attendance/classroom/list'); ?>" class="nav-link" parent-li="attendance-li">Students Attendance</a></li>
										<li class="nav-item"><a href="<?php echo set_url('attendance/teacher/list'); ?>" class="nav-link" parent-li="attendance-li">Teachers Attendance</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="student-li">
								<a href="<?php echo set_url('student/list'); ?>" class="nav-link">Students</a>
								<button class="toggle-button" target="student-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="student-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('student/list'); ?>" class="nav-link"  parent-li="student-li">Students list</a></li>
										<li class="nav-item"  parent-li="student-li"><a href="#" class="nav-link">Students Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="teacher-li">
								<a href="<?php echo set_url('teacher/list'); ?>" class="nav-link">Teachers</a>
								<button class="toggle-button" target="teacher-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="teacher-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('teacher/list'); ?>" class="nav-link" parent-li="teacher-li">Teachers List</a></li>
										<li class="nav-item"><a href="<?php echo set_url('teacher/registration') ?>" class="nav-link"  parent-li="teacher-li">Add teacher</a></li>
										<li class="nav-item"><a href="<?php echo set_url('pages/TComplaints.php') ?>" class="nav-link"  parent-li="teacher-li">Teachers Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="classroom-li"><a href="<?php echo set_url('classroom/list') ?>" class="nav-link">Class Rooms</a>
								<button class="toggle-button" target="classroom-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" width="20px" alt="">
								</button>

								<nav  id="classroom-nav" class="nav sub-nav no-collapsed">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('classroom/list') ?>" class="nav-link" parent-li="classroom-li">Classroom list</a></li>
										<li class="nav-item"><a href="<?php echo set_url('classroom/registration') ?>" class="nav-link" parent-li="classroom-li">Add new Classroom</a></li>
										<li class="nav-item"><a href="#" class="nav-link" parent-li="classroom-li">Class Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li class="nav-item aside-li" id="subject-li">
								<a href="<?php echo set_url('subject/list') ?>" class="nav-link">Subjects</a>
								<button class="toggle-button" target="subject-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png'); ?>" width="20px" alt="">
								</button>

								<nav class="nav sub-nav no-collapsed" id="subject-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item">
											<a href="<?php echo set_url('subject/list') ?>" class="nav-link" parent-li="subject-li">Subjects list</a></li>
										<li class="nav-item">
											<a href="<?php echo set_url('subject/registration') ?>" class="nav-link" parent-li="subject-li">Add a Subject</a></li>
										<li class="nav-item">
											<a href="#" class="nav-link" parent-li="subject-li">Subjects Complaints</a></li>
									</ul>
								</nav>
							</li>
							<li id="interview-li" class="nav-item aside-li">
								<a href="<?php echo set_url('interviewpanel/list') ?>" class="nav-link">Interviews</a>
								<button class="toggle-button" target="interview-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px">
								</button>
								<nav id="interview-nav" class="no-collapsed nav sub-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('interviewpanel/list') ?>" class="nav-link"  parent-li="interview-li">All panels</a></li>
										<li class="nav-item"><a href="<?php echo set_url('interviewpanel/registration') ?>" class="nav-link" parent-li="interview-li">Add new Panel</a></li>
										<li class="nav-item">
											<a href="<?php echo set_url('interview/list') ?>"  class="nav-link" parent-li="interview-li">Interview List</a>
										</li>
									</ul>
									
								</nav>
							</li>
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('userrole/permission') ?>" class="nav-link">User Roles</a>

							</li>
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('parent/list') ?>" class="nav-link" class="nav-link">Parents</a>
							</li>
							<li id="settings-li" class="nav-item aside-li">
								<a href="<?php echo set_url('settings/school') ?>" class="nav-link">All Settings</a>
								<button class="toggle-button" target="settings-nav">
									<img src="<?php echo set_url('public/assets/img/close-menu.png') ?>" width="20px">
								</button>
								<nav id="settings-nav" class="no-collapsed nav sub-nav">
									<ul class="d-flex flex-col">
										<li class="nav-item"><a href="<?php echo set_url('settings/school') ?>" class="nav-link"  parent-li="settings-li">School settings</a></li>
									</ul>
									
								</nav>
							</li>
						</ul>
					</nav>
				</div>
			</aside>