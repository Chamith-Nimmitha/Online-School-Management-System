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
						<i class="fas fa-user-graduate"></i>Students List
					</a>
				</li>
				<li id="settings-li" class="nav-item aside-li">
					<a href="<?php echo set_url('settings/website') ?>" class="nav-link">
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