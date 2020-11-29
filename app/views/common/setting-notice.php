
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
	<form action="<?php echo set_url("settings/notice");?>" method="post" enctype="multipart/form-data">
		<fieldset>	
			<legend>Notice Settings</legend>
				<div class="form-group">
					<label for="no-notice">Number of Notices</label>
					<input type="text" name="no-notice" id="no-notice" value="<?php if(!empty($notice['1000_text'])){echo $notice['1000_text'];} ?>">
				</div>

				<br><br>

			<fieldset>
				<legend>Notice-1</legend>

				<div class="form-group">
					<label for="notice1-text">Notice Text</label>
					<input type="text" name="notice1-text" id="notice1-text" value="<?php if(!empty($notice['1_text'])){echo $notice['1_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice1-image">Insert Image</label>
					<input type="file" name="notice1-image" id="notice1-image">
					<?php 
					if(isset($errors['notice1-image']) && !empty($errors['notice1-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['notice1-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['notice1-image']) && !empty($info['notice1-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['notice1-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="notice1-ref">Notice Reference</label>
					<input type="text" name="notice1-ref" id="notice1-ref" value="<?php if(!empty($notice['1_reference'])){echo $notice['1_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-2</legend>

				<div class="form-group">
					<label for="notice2-text">Notice Text</label>
					<input type="text" name="notice2-text" id="notice2-text" value="<?php if(!empty($notice['2_text'])){echo $notice['2_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice2-image">Insert Image</label>
					<input type="file" name="notice2-image" id="notice2-image">
					<?php 
					if(isset($errors['notice2-image']) && !empty($errors['notice2-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['notice2-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['notice2-image']) && !empty($info['notice2-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['notice2-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="notice2-ref">Notice Reference</label>
					<input type="text" name="notice2-ref" id="notice2-ref" value="<?php if(!empty($notice['2_reference'])){echo $notice['2_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-3</legend>

				<div class="form-group">
					<label for="notice3-text">Notice Text</label>
					<input type="text" name="notice3-text" id="notice3-text" value="<?php if(!empty($notice['3_text'])){echo $notice['3_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice3-image">Insert Image</label>
					<input type="file" name="notice3-image" id="notice3-image">
					<?php 
					if(isset($errors['notice3-image']) && !empty($errors['notice3-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['notice3-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['notice3-image']) && !empty($info['notice3-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['notice3-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="notice3-ref">Notice Reference</label>
					<input type="text" name="notice3-ref" id="notice3-ref" value="<?php if(!empty($notice['3_reference'])){echo $notice['3_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-4</legend>

				<div class="form-group">
					<label for="notice4-text">Notice Text</label>
					<input type="text" name="notice4-text" id="notice4-text" value="<?php if(!empty($notice['4_text'])){echo $notice['4_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice4-image">Insert Image</label>
					<input type="file" name="notice4-image" id="notice4-image">
					<?php 
					if(isset($errors['notice4-image']) && !empty($errors['notice4-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['notice4-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['notice4-image']) && !empty($info['notice4-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['notice4-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="notice4-ref">Notice Reference</label>
					<input type="text" name="notice4-ref" id="notice4-ref" value="<?php if(!empty($notice['4_reference'])){echo $notice['4_reference'];} ?>">
				</div>

			</fieldset>

			<fieldset>
				<legend>Notice-5</legend>

				<div class="form-group">
					<label for="notice5-text">Notice Text</label>
					<input type="text" name="notice5-text" id="notice5-text" value="<?php if(!empty($notice['5_text'])){echo $notice['5_text'];} ?>">
				</div>

				<div class="form-group">
					<label for="notice5-image">Insert Image</label>
					<input type="file" name="notice5-image" id="notice5-image">
					<?php 
					if(isset($errors['notice5-image']) && !empty($errors['notice5-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-red p-2'>";
						echo $errors['notice5-image'] . "<br>";
						echo "</p>";
					}
					if(isset($info['notice5-image']) && !empty($info['notice5-image'])){
						echo "<br>";
						echo "<p class='float-left w-75 bg-green p-2'>";
						echo $info['notice5-image'] . "<br>";
						echo "</p>";
					}
					?>
				</div>

				<div class="form-group">
					<label for="notice5-ref">Notice Reference</label>
					<input type="text" name="notice5-ref" id="notice5-ref" value="<?php if(!empty($notice['5_reference'])){echo $notice['5_reference'];} ?>">
				</div>

			</fieldset>
<!--
			</fieldset>

			<fieldset>
				<legend>Notice-6</legend>

				<div class="form-group">
					<label for="notice6-text">Notice Text</label>
					<input type="text" name="notice6-text" id="notice6-text" value="<?php /*if(!empty($notice['6_text'])){echo $notice['6_text'];} */?>">
				</div>

				<div class="form-group">
					<label for="notice6-image">Insert Image</label>
					<input type="file" name="notice6-image" id="notice6-image">
				</div>

				<div class="form-group">
					<label for="notice6-ref">Notice Reference</label>
					<input type="text" name="notice6-ref" id="notice6-ref" value="<?php/* if(!empty($notice['5_reference'])){echo $notice['6_reference'];*/} ?>">
				</div>

			</fieldset>

-->

				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-blue">Submit</button>
				</div>

		</fieldset>
	</form>

</div> <!-- #content -->


