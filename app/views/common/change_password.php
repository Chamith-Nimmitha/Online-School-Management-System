<div id="content" class="col-12 flex-col align-items-center justify-content-start fs-14">
	<?php
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
			echo $error ."<br/>";
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='w-75 bg-green fg-white p-2 text-center'>";
			echo $info ."<br/>";
			echo "</p>";
		}
		?>
	<div class="row align-items-center justify-content-center">
		<div class="col-3 align-items-center justify-content-start">

			<form action="" method="post" enctype="multipart/form-data" >
	
				<fieldset class="col-12 justify-content-center align-items-center">
					<legend>Change Password</legend>

					<div class="form-group">
						<label for="email">New Password</label>
						<input type="password" name="password" id="password" placeholder="password">
					</div>

					<div class="form-group">
						<label for="email">Confirm Password</label>
						<input type="password" name="cpassword" id="cpassword" placeholder="password">
					</div>

					<div class="form-group ">
						<div class="row justify-content-center align-items-center">
							<input type="submit" value="submit" name="submit" class="m-2 btn btn-blue" size="50">
						</div>
					</div>

				</fieldset>
	
			</form>

		</div>
	</div>
</div>
