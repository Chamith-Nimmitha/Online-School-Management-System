<aside class="navbar col-1 col-md-4 col-lg-3 m-0 p-0 d-flex justify-content-start bg-blue" >
	<div class="d-md-flex flex-col d-none col-12 theme-sidebar" id="aside-nav-wrapper">
		<nav class="nav fs-18">
			<ul class="d-flex flex-col" id="aside_nav">
				<li class="nav-item aside-li">
					<a href="<?php echo set_url('dashboard'); ?>" class="nav-link active">
						<i class="fas fa-chart-line"></i>Dashbord
					</a>
				</li>
				<li class="nav-item aside-li">
					<a href="<?php echo set_url('parent/student/list'); ?>" class="nav-link">
						<i class="fas fa-user-graduate"></i>Children List
					</a>
				</li>
				<li id="settings-li" class="nav-item aside-li">
					<a href="<?php echo set_url('settings/website') ?>" class="nav-link">
						<i class="fas fa-sliders-h"></i>Website Settings</a>
				</li>
			</ul>
		</nav>
	</div>
</aside>

8.13