

<div id="content" style="height: 470px;" class="col-12 justify-content-center align-items-start">
	<form action="" method="post" class="col-12 col-md-8 mt-5 col-lg-4">
		<div class="message col-12">
			<?php 
				if( isset($message) && !empty($message)) {
					echo "<p class='bg-red p-2 w-100 text-center'>";
					echo $message;
					echo "</p>";
				}
				if( isset($info) && !empty($info)) {
					echo "<p class='bg-green p-2 w-100 text-center'>";
					echo $info;
					echo "</p>";
				}
			?>
		</div>
		<fieldset class="col-12">
			<legend>LOGIN</legend>
			<div class="form-group">
      			<!-- <label for="email">Email</label>
        		<input type="email" name="email" id="email" placeholder="email" oninput="validate_email(this,0,100,1)" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"];} ?> ">
        		<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p> -->
        		<div class="test-field-outer">
					<div class="test-field-inner col-12">
						<i class="fas fa-envelope"></i>
						<input type="email" name="email" id='email'  placeholder="email">
						<label for="email" id="label"><span class="label-span">Email Address</span></label>
					</div>
				</div>
     		</div>
     		 <div class="form-group">
      			<!-- <label for="password">Password (<a href="<?php echo set_url("forget_password");?> " class="d-inline-block t-d-none b-radius-10 pl-2 pr-2">Forget Password?</a>)</label>
        		<input type="password" name="password" id="password" placeholder="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"];} ?>" class="form-control"> -->
        		<div class="test-field-outer mb-0 pb-0">
					<div class="test-field-inner col-12">
						<i class="fas fa-key"></i>
						<input type="password" name="password" id='password'  placeholder="password" oninput="validate_password(this)">
						<label for="password" id="label"><span class="label-span">Password</span></label>
					</div>
					<p class="bg-red fg-white p-2 d-none"></p>
				</div>
				<div class="d-flex justify-content-end w-90">
					<a href="<?php echo set_url('forget_password'); ?>" class="btn btn-lightred p-1 fs-12">Forget Password</a>
				</div>

      		</div>
      		<div class="d-flex justify-content-end col-11">
	      		<div class="check justify-content-center align-items-center">
	          		<label for="remember-me">Remember me</label>
	            	<input type="checkbox" name="remember-me" class="form-control" id="remember"><br> 
	            </div>

	            <div class="justify-content-center align-items-center text-center">
	     			<input type="submit" name="submit" class="fs-16 btn btn-blue pl-5 pr-5"  value="Log In">
	 			</div>
      		</div>
      		<div class="col-12 d-flex justify-content-center align-items-center fg-white bg-blue b-radius-5">
      			Don't have account yet?<a href="./student_registration.php" class="btn btn-blue-outline p-1 ml-5">Register Now!</a>
      		</div>
		</fieldset>
	</form>
</div>