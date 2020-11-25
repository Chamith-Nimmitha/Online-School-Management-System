<div id="content" class="col-12 flex-col align-items-center justify-content-start fs-14">
	<div class="row align-items-center justify-content-center">
		<div class="col-3 align-items-center justify-content-start">
			<?php
			
			if(isset($error)){
			 echo $error;
			}
			
			if(isset($msg)){
			 echo $msg ;
			}
 			?>

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
