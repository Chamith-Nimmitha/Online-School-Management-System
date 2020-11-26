
<div id="content" class="col-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($errors) && !empty($errors)){
			echo "<p class='float-left w-75 bg-red p-2'>";
			foreach ($errors as $error) {
				echo $error . "<br>";
			}
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='float-left w-75 bg-green p-2'>";
			foreach ($info as $in) {
				echo $in . "<br>";
			}
			echo "</p>";
		}

	 ?>
	<form action="<?php echo set_url("settings_school");?>" method="post" enctype="multipart/form-data">
		
		<fieldset>	
			<legend>Site Header Settings</legend>
				<div class="form-group">
					<label for="school-name">School Name</label>
					<input type="text" name="school-name" id="school-name" value="<?php if(!empty($result)){echo $result['school_name'];} ?>">
					<?php echo $result['school_name'];?>
				</div>

				<div class="form-group">
					<label for="school-address">School Address</label>
					<input type="text" name="school-address" id="school-address" value="<?php if(!empty($result)){echo $result['school_address'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-contact-number">School Contact Number</label>
					<input type="text" name="school-contact-number" id="school-contact-number" value="<?php if(!empty($result)){echo $result['school_contact_number'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-email">School Email</label>
					<input type="text" name="school-email" id="school-email" value="<?php if(!empty($result)){echo $result['school_email'];} ?>">
				</div>

				<div class="form-group">
					<label for="bg-image">Background Image</label>
					<input type="file" name="bg-image" id="bg-image">
				</div>

				<div class="form-group">
					<label for="school-badge">School Badge</label>
					<input type="file" name="school-badge" id="school-badge">
				</div>

				<div class="form-group">
					<label for="school-flag">School Flag</label>
					<input type="file" name="school-flag" id="school-flag">
				</div>

				<div class="form-group">
					<label for="school-image">School Image</label>
					<input type="file" name="school-image" id="school-image">
				</div>

				<div class="form-group">
					<label for="school-map">School Map </label>
					<input type="file" name="school-map" id="school-map">
				</div>

				<div class="form-group">
					<label for="school-vision">School Vision</label>
					<input type="text" name="school-vision" id="school-vision" value="<?php if(!empty($result)){echo $result['school_vision'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-mission">School Mission</label>
					<input type="text" name="school-mission" id="school-mission" value="<?php if(!empty($result)){echo $result['school_mission'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-welcome-message">School Welcome Message</label>
					<input type="text" name="school-welcome-message" id="school-welcome-message" value="<?php if(!empty($result)){echo $result['school_welcome_message'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-description">School Description</label>
					<input type="text" name="school-description" id="school-description" value="<?php if(!empty($result)){echo $result['school_description'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-principal-message">School Principal's Message</label>
					<input type="text" name="school-principal-message" id="school-principal-message" value="<?php if(!empty($result)){echo $result['school_principal_message'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-brief-history">School Brief History</label>
					<input type="text" name="school-brief-history" id="school-brief-history" value="<?php if(!empty($result)){echo $result['school_brief_history'];} ?>">
				</div>


				<div class="form-group">
					<label for="school-website">School Website</label>
					<input type="text" name="school-website" id="school-website" value="<?php if(!empty($result)){echo $result['school_website'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-fb-id">School Facebook</label>
					<input type="text" name="school-fb-id" id="school-fb-id" value="<?php if(!empty($result)){echo $result['school_fb_id'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-twitter-id">School Twitter</label>
					<input type="text" name="school-twitter-id" id="school-twitter-id" value="<?php if(!empty($result)){echo $result['school_twitter_id'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-insta-id">School Instagram</label>
					<input type="text" name="school-insta-id" id="school-insta-id" value="<?php if(!empty($result)){echo $result['school_insta_id'];} ?>">
				</div>

				<div class="form-group">
					<label for="school-linkedin-id">School Linkedin</label>
					<input type="text" name="school-linkedin-id" id="school-linkedin-id" value="<?php if(!empty($result)){echo $result['school_linkedin_id'];} ?>">
				</div>

				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-blue">Submit</button>
				</div>

		</fieldset>
	</form>

</div> <!-- #content -->


