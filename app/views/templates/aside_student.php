
			<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start" >
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
								<a href="<?php echo set_url('classroom/student/list') ?>" class="nav-link">
									<i class="fas fa-store-alt"></i>My Classroom
								</a>
							</li>
							<li class="nav-item aside-li" id="subject-li">
								<a href="<?php echo set_url('student/subject/list') ?>" class="nav-link">
									<i class="fas fa-book"></i>My Subjects
								</a>
							</li>
							
							<li class="nav-item aside-li">
								<a href="<?php echo set_url('student/view/parent/'.$parent_id); ?>" class="nav-link">
									<i class="fas fa-user-shield"></i>Parent Info
								</a>
							</li>
							<li class="nav-item aside-li" id="exam-result-li">
								<a href="<?php echo set_url('student/exam'); ?>" class="nav-link">
									<i class="fas fa-poll"></i>Exam Result
									<!-- <i class="fas fa-book-dead"></i>Exam Result -->
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</aside>