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
						</ul>
					</nav>
				</div>
			</aside>