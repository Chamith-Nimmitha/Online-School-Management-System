
<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start bg-blue" >
	<div class="d-md-flex flex-col d-none col-12 theme-sidebar" id="aside-nav-wrapper">
		<nav class="nav fs-18">
			<ul class="d-flex flex-col" id="aside_nav">
				<li class="nav-item aside-li">
					<a href="<?php echo set_url('dashboard'); ?>" class="nav-link active">
						<i class="fas fa-chart-line"></i>Dashbord
					</a>
				</li>
				<li class="nav-item aside-li" id="attendance-li">
					<a href="<?php echo set_url('student/attendance'); ?>" class="nav-link">
						<i class="far fa-calendar-check"></i>Student Attendance
					</a>
					
				</li>
				<li class="nav-item aside-li" id="timetable-li">
					<a href="<?php echo set_url('student/timetable/view');?>" class="nav-link">
						<i class="fas fa-user-clock"></i>Student Timetable
					</a>
				</li>
				<li class="nav-item aside-li" id="classroom-li">
					<a href="<?php echo set_url('classroom/view') ?>" class="nav-link">
						<i class="fas fa-store-alt"></i>My Classroom
					</a>
				</li>
				<li class="nav-item aside-li" id="subject-li">
					<a href="<?php echo set_url('student/subject/list') ?>" class="nav-link">
						<i class="fas fa-book"></i>My Subjects
					</a>
				</li>
				
				<li class="nav-item aside-li">
					<a href="<?php echo set_url('profile/parent/'.$parent_id); ?>" class="nav-link">
						<i class="fas fa-user-shield"></i>Parent Info
					</a>
				</li>
							<li class="nav-item aside-li" id="exam-result-li">
								<a href="<?php echo set_url('marks/classroom/result/view/'.$_SESSION['user_id'].'/1'); ?>" class="nav-link"><i class="far fa-file"></i>Exam Result</a>
							</li>
				<li id="settings-li" class="nav-item aside-li">
					<a href="<?php echo set_url('settings/website') ?>" class="nav-link">
						<i class="fas fa-sliders-h"></i>All Settings</a>
					<button class="toggle-button" target="settings-nav">
						<img src="<?php echo set_url('public/assets/img/menu_arrow.png') ?>" width="20px">
					</button>
					<nav id="settings-nav" class="no-collapsed nav sub-nav">
						<ul class="d-flex flex-col">
							<li class="nav-item"><a href="<?php echo set_url('settings/website') ?>" class="nav-link"  parent-li="settings-li">Website Settings</a></li>
						</ul>
						
					</nav>
				</li>
			</ul>
		</nav>
	</div>
</aside>