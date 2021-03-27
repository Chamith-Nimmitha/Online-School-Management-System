
<div id="content" class="col-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($errors) && !empty($errors)){
			echo "<p class='float-left w-75 bg-red p-2'>";
			echo "Error While Updating<br></p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='float-left w-75 bg-green p-2'>";
				echo $info['data'] . "<br>";
			echo "</p>";
		}

	 ?>
	<form action="<?php echo set_url("settings/school");?>" method="post" enctype="multipart/form-data">
		
		<fieldset>	
			<legend>Site Header Settings</legend>
				<div class="form-group">
					<label for="school-name">School Name</label>
					<input type="text" name="school-name" id="school-name" oninput="validate_user_input(this,0,30,1)" value="<?php if(!empty($result)){echo $result['school_name'];} ?>">
					<?php 
						if(isset($field_errors['school-name'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-name"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-address">School Address</label>
					<input type="text" name="school-address" id="school-address" oninput="validate_user_input(this,0,30,1)" value="<?php if(!empty($result)){echo $result['school_address'];} ?>">
					<?php 
						if(isset($field_errors['school-address'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-address"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-contact-number">School Contact Number</label>
					<input type="text" name="school-contact-number" id="school-contact-number" oninput="validate_contact_number(this)" value="<?php if(!empty($result)){echo $result['school_contact_number'];} ?>">
					<?php 
						if(isset($field_errors['school-contact-number'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-contact-number"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-email">School Email</label>
					<input type="text" name="school-email" id="school-email" oninput="validate_email(this,0,100,1)" value="<?php if(!empty($result)){echo $result['school_email'];} ?>">
					<?php 
						if(isset($field_errors['school-email'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-email"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="bg-image">Background Image</label>
					<input type="file" name="bg-image" id="bg-image">
					<?php 
					if(isset($errors['bg-image']) && !empty($errors['bg-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['bg-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['bg-image']) && !empty($info['bg-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['bg-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="school-badge">School Badge</label>
					<input type="file" name="school-badge" id="school-badge">
					<?php 
					if(isset($errors['school-badge']) && !empty($errors['school-badge'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['school-badge'] . "<br>";
						echo "</p>";
					}
					if(isset($info['school-badge']) && !empty($info['school-badge'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['school-badge'] . "<br>";
						echo "</p>";
					}

					?>
				</div>

				<div class="form-group">
					<label for="school-flag">School Flag</label>
					<input type="file" name="school-flag" id="school-flag">
					<?php 
					if(isset($errors['school-flag']) && !empty($errors['school-flag'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['school-flag'] . "<br>";
						echo "</p>";
					}
					if(isset($info['school-flag']) && !empty($info['school-flag'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['school-flag'] . "<br>";
						echo "</p>";
					}

					?>

				</div>

				<div class="form-group">
					<label for="school-image">School Image</label>
					<input type="file" name="school-image" id="school-image">
					<?php 
					if(isset($errors['school-image']) && !empty($errors['school-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['school-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['school-image']) && !empty($info['school-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['school-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="school-map">School Map </label>
					<input type="file" name="school-map" id="school-map">
					<?php 
					if(isset($errors['school-map']) && !empty($errors['school-map'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['school-map'] . "<br>";
						echo "</p>";
					}
					if(isset($info['school-map']) && !empty($info['school-map'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['school-map'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="school-vision">School Vision</label>
					<textarea rows="6" cols="80" type="text" name="school-vision" id="school-vision" oninput="validate_user_input(this,0,50,1)" value=""><?php if(!empty($result)){echo $result['school_vision'];} ?></textarea>
					<?php 
						if(isset($field_errors['school-vision'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-vision"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-mission">School Mission</label>
					<textarea rows="6" cols="80" type="text" name="school-mission" id="school-mission" oninput="validate_user_input(this,0,150,1)" value=""><?php if(!empty($result)){echo $result['school_mission'];} ?></textarea>
					<?php 
						if(isset($field_errors['school-mission'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-mission"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-welcome-message">School Welcome Message</label>
					<textarea rows="10"  cols=" 150" type="text" name="school-welcome-message" id="school-welcome-message" oninput="validate_user_input(this,0,550,1)" value=""><?php if(!empty($result)){echo $result['school_welcome_message'];} ?></textarea>
					<?php 
						if(isset($field_errors['school-welcome-message'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-welcome-message"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-description">School Description</label>
					<textarea rows="10" cols="150" type="text" name="school-description" id="school-description" oninput="validate_user_input(this,0,1000,1)" value=""><?php if(!empty($result)){echo $result['school_description'];} ?></textarea>
					<?php 
						if(isset($field_errors['school-description'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-description"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-principal-message">School Principal's Message</label>
					<textarea rows="10" cols="150" type="text" name="school-principal-message" id="school-principal-message" oninput="validate_user_input(this,0,550,1)" value=""><?php if(!empty($result)){echo $result['school_principal_message'];} ?></textarea>
					<?php 
						if(isset($field_errors['school-principal-message'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-principal-message"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-brief-history">School Brief History</label>
					<textarea rows="18" cols="150" type="text" name="school-brief-history" id="school-brief-history" oninput="validate_user_input(this,0,2000,1)" value=""><?php if(!empty($result)){echo $result['school_brief_history'];} ?></textarea>
					<?php 
						if(isset($field_errors['school-brief-history'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-brief-history"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>


				<div class="form-group">
					<label for="school-website">School Website</label>
					<input type="text" name="school-website" id="school-website" oninput="validate_user_input(this,0,50,1)" value="<?php if(!empty($result)){echo $result['school_website'];} ?>">
					<?php 
						if(isset($field_errors['school-website'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-website"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-fb-id">School Facebook</label>
					<input type="text" name="school-fb-id" id="school-fb-id" oninput="validate_user_input(this,0,50,1)" value="<?php if(!empty($result)){echo $result['school_fb_id'];} ?>">
					<?php 
						if(isset($field_errors['school-fb-id'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-fb-id"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-twitter-id">School Twitter</label>
					<input type="text" name="school-twitter-id" id="school-twitter-id" oninput="validate_user_input(this,0,50,1)" value="<?php if(!empty($result)){echo $result['school_twitter_id'];} ?>">
					<?php 
						if(isset($field_errors['school-twitter-id'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-twitter-id"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-insta-id">School Instagram</label>
					<input type="text" name="school-insta-id" id="school-insta-id" oninput="validate_user_input(this,0,50,1)" value="<?php if(!empty($result)){echo $result['school_insta_id'];} ?>">
					<?php 
						if(isset($field_errors['school-insta-id'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-insta-id"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<label for="school-linkedin-id">School Linkedin</label>
					<input type="text" name="school-linkedin-id" id="school-linkedin-id" oninput="validate_user_input(this,0,50,1)" value="<?php if(!empty($result)){echo $result['school_linkedin_id'];} ?>">
					<?php 
						if(isset($field_errors['school-linkedin-id'])){
							echo '<p class="bg-red fg-white pl-5 p-2 d-inherit w-100">'.$field_errors["school-linkedin-id"].'</p>';
						}else{
								echo '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
						}
					?>
				</div>

				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-blue">Submit</button>
				</div>

		</fieldset>
	</form>

</div> <!-- #content -->


