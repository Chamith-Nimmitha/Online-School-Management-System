<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start bg-blue" >	
	<div class="d-md-flex flex-col d-none col-12 theme-sidebar" id="aside-nav-wrapper">
		<nav class="nav fs-18">
			<ul class="d-flex flex-col" id="aside_nav">
				<li class="nav-item aside-li">
					<a href="<?php echo set_url('dashboard'); ?>" class="nav-link active">
						<i class="fas fa-chart-line"></i>Dashbord
					</a>
				</li>
				<li class="nav-item aside-li" id="admission-li">
					<a href="<?php echo set_url('admission/list'); ?>" class="nav-link">
						<i class="far fa-address-card"></i>Admissions
					</a>
				</li>
				<li class="nav-item aside-li" id="attendance-li">
					<a href="<?php echo set_url('teacher/attendance') ?>" class="nav-link">
						<i class="far fa-calendar-check"></i>Attendance
					</a>
					<button class="toggle-button" target="attendance-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px" alt="">
					</button>

					<nav class="nav sub-nav no-collapsed" id="attendance-nav">
						<ul class="d-flex flex-col">
							<li class="nav-item"><a href="<?php echo set_url('teacher/attendance') ?>" parent-li="attendance-li" class="nav-link">My Attendance</a></li>
							<?php if(isset($classroom_id) && $classroom_id != FALSE){ ?>
							<li class="nav-item"><a href="<?php echo set_url('teacher/classroom/attendance') ?>" parent-li="attendance-li" class="nav-link">Mark classroom Attendance</a></li>
							<?php } ?>
						</ul>
					</nav>
				</li>
				<li class="nav-item aside-li" id="student-li">
					<a href="<?php echo set_url('student/list'); ?>" class="nav-link">
						<i class="fas fa-user-graduate"></i>Students
					</a>
					<button class="toggle-button" target="student-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px" alt="">
					</button>

					<nav class="nav sub-nav no-collapsed" id="student-nav">
						<ul class="d-flex flex-col">
							<li class="nav-item"><a href="<?php echo set_url('student/list'); ?>" class="nav-link"  parent-li="student-li">Students list</a></li>
						</ul>
					</nav>
				</li>
				<li class="nav-item aside-li" id="teacher-li">
					<a href="<?php echo set_url('teacher/list'); ?>" class="nav-link">
						<i class="fas fa-user-tie"></i>Teachers
					</a>
					<button class="toggle-button" target="teacher-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px" alt="">
					</button>

					<nav class="nav sub-nav no-collapsed" id="teacher-nav">
						<ul class="d-flex flex-col">
							<li class="nav-item"><a href="<?php echo set_url('teacher/list'); ?>" class="nav-link" parent-li="teacher-li">Teachers List</a></li>
						</ul>
					</nav>
				</li>
				<li class="nav-item aside-li" id="classroom-li">
					<a href="<?php echo set_url('classroom/list') ?>" class="nav-link">
						<i class="fas fa-store-alt"></i>Class Rooms
					</a>
					<button class="toggle-button" target="classroom-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px" alt="">
					</button>

					<nav  id="classroom-nav" class="nav sub-nav no-collapsed">
						<ul class="d-flex flex-col">
							<li class="nav-item"><a href="<?php echo set_url('classroom/list') ?>" class="nav-link" parent-li="classroom-li">Classroom list</a></li>
						</ul>
					</nav>
				</li>
				<li class="nav-item aside-li" id="subject-li">
					<a href="<?php echo set_url('teacher/subject/list') ?>" class="nav-link">
						<i class="fas fa-book"></i>Subjects
					</a>
					<button class="toggle-button" target="subject-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px" alt="">
					</button>

					<nav class="nav sub-nav no-collapsed" id="subject-nav">
						<ul class="d-flex flex-col">
							<li class="nav-item">
								<a href="<?php echo set_url('teacher/subject/list',array('teacher_id'=>$_SESSION['user_id'])); ?>" class="nav-link" parent-li="subject-li">Subjects list</a></li>
						</ul>
					</nav>
				</li>
				<li class="nav-item aside-li" id="timetable-li">
					<a href="<?php echo set_url('teacher/timetable') ?>" class="nav-link">
						<i class="fas fa-user-clock"></i>Timetable
					</a>
				</li>
				<?php if(isset($interview_panel_id)){ ?>
				<li id="interview-li" class="nav-item aside-li">
					<a href="<?php echo set_url('teacher/interview/panel');?>" class="nav-link">
						<i class="fas fa-clock"></i>Interviews
					</a>
					<button class="toggle-button" target="interview-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px">
					</button>
						<div id="interview-nav" class="no-collapsed nav sub-nav">
							<ul class="d-flex flex-col">
								<li class="nav-item"><a href="<?php echo set_url('teacher/interview/panel');?>" class="nav-link"  parent-li="interview-li">My panel</a></li>
								<li class="nav-item">
									<a href="<?php echo set_url('teacher/interviews'); ?>"  class="nav-link" parent-li="interview-li">Interview List</a>
								</li>
							</ul>
						</div>
				</li>
				<?php } ?>
				<li id="settings-li" class="nav-item aside-li">
					<a href="<?php echo set_url('settings/school') ?>" class="nav-link">
						<i class="fas fa-sliders-h"></i>All Settings</a>
					<button class="toggle-button" target="settings-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px">
					</button>
					<nav id="settings-nav" class="no-collapsed nav sub-nav">
						<ul class="d-flex flex-col">
							<li class="nav-item"><a href="<?php echo set_url('settings/website') ?>" class="nav-link"  parent-li="settings-li">Website settings</a></li>
						</ul>
						
					</nav>
				</li>
			</ul>
		</nav>
	</div>
</aside>