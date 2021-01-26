<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		 if(isset($error) && !empty($error)){
            echo "<p class='w-75 bg-red p-2 text-center'>";
            echo $error;
            echo "</p>";
        }
         if(isset($msg) && !empty($msg)){
            echo "<p class='w-75 bg-green p-2 text-center'>";
            echo $msg;
            echo "</p>";
        }
	 ?>

<div>
	<h2 style="font-size: 25px;">Classroom Subjects</h2>
</div>

<div class="col-12">
	<form action="" method="POST" class="col-12 d-flex justify-content-center">  
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Classroom Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Classroom ID</label>
				<input class="" type="text" name="id" placeholder="Classroom ID" value="<?php if(isset($classroom_info)){echo $classroom_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="grade">Grade</label>
				<input type="text" id="grade" name="grade" placeholder="Grade" value="<?php if(isset($classroom_info)){echo $classroom_info['grade'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="class">Class</label>
				<input type="text" name="class" value="<?php if(isset($classroom_info['class'])){echo $classroom_info['class'];} ?>" disabled="disabled">
			</div>
		</fieldset>
	</form>
</div>


<div class="col-8 mt-5">
	<div class="mb-5">
		<h3 style="font-size: 25px;">Assign Subjects For Classroom</h3>
	</div>
	<form action="" method="POST" class="col-12 d-flex justify-content-center p-2">
		<fieldset class="col-12 p-2 mb-2 justify-content-center">
			<!-- <span class="mb-3">Insert optional subjects in <span style="color: red;">GENERAL FORMAT.</span></span> -->
			<span>General Subjects</span>
			<div class="col-12" id="general-subject-wrapper">
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-general-1">Subject 1</label>
					<select class="col-6 mr-2" name="subject-general-1" id="subject-general-1">
						<option value="">Select Subject</option>
						<?php if(isset($general_subjects) && !empty($general_subjects)){
							   foreach ($general_subjects as $subject) { ?>
								<option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']." - ".$subject['medium'] ; ?></option>
						<?php }
						}?>	
					</select>	
					<input class="col-3" type="text" name="periods-general-1" id="periods-general-1" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>
				<!-- sub 2 -->
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-general-2">Subject 2</label>
					<select class="col-6 mr-2" name="subject-general-2" id="subject-general-2">
						<option value="">Select Subject</option>
						<?php if(isset($general_subjects) && !empty($general_subjects)){
							   foreach ($general_subjects as $subject) { ?>
								<option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']." - ".$subject['medium'] ; ?></option>
						<?php }
						}?>	
					</select>	
					<input class="col-3" type="text" name="periods-general-2" id="periods-general-2" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>
				<!-- sub 3 -->
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-general-3">Subject 3</label>
					<select class="col-6 mr-2" name="subject-general-3" id="subject-general-3">
						<option value="">Select Subject</option>
						<?php if(isset($general_subjects) && !empty($general_subjects)){
							   foreach ($general_subjects as $subject) { ?>
								<option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']." - ".$subject['medium'] ; ?></option>
						<?php }
						}?>	
					</select>	
					<input class="col-3" type="text" name="periods-general-3" id="periods-general-3" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>

			</div>
			<div class="w-100 d-flex justify-content-end" id="general-subject-buttons">
				<button type="button" id="add_general_subject" class="mr-3 p-2">+ Add Subject</button>
				<button type="button" id="remove_general_subject">+ Remove Subject</button>
			</div>
		</fieldset>
		<fieldset class="col-12 p-2 mb-2 justify-content-center">
			<span>Optional Subjects</span>
			<div class="col-12" id="optional-subject-wrapper">
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-optional-1">Subject 1</label>
					<select class="col-6 mr-2" name="subject-optional-1" id="subject-optional-1">
						<option value="">Select Subject</option>
						<?php if(isset($optional_subjects) && !empty($optional_subjects)){
							   foreach ($optional_subjects as $subject) { ?>
								<option value="<?php echo $subject['category']; ?>"><?php echo $subject['category']; ?></option>
						<?php }
						}?>	
					</select>	
					<input class="col-3" type="text" name="periods-optional-1" id="periods-optional-1" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>

			</div>
			<div class="w-100 d-flex justify-content-end" id="optional-subject-buttons">
				<button type="button" id="add_optional_subject" class="mr-3 p-2">+ Add Subject</button>
				<button type="button" id="remove_optional_subject">+ Remove Subject</button>
			</div>
		</fieldset>

		<fieldset class="col-12 p-2 mb-2 justify-content-center">
			<span>Other Subjects</span>
			<div class="col-12" id="optional-subject-wrapper">
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-other-1">Subject 1</label>
					<select class="col-6 mr-2" name="subject-other-1" id="subject-other-1">
						<option value="">Select Subject</option>
						<?php if(isset($other_subjects) && !empty($other_subjects)){
							   foreach ($other_subjects as $subject) { ?>
								<option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
						<?php }
						}?>	
					</select>	
					<input class="col-3" type="text" name="periods-other-1" id="periods-other-1" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>

			</div>
			<div class="w-100 d-flex justify-content-end" id="other-subject-buttons">
				<button type="button" id="add_other_subject" class="mr-3 p-2">+ Add Subject</button>
				<button type="button" id="remove_other_subject">+ Remove Subject</button>
			</div>
		</fieldset>
		<div class="w-100 d-flex justify-content-end">
			<input type="submit" name="submit" value="Submit" class="btn btn-blue">
		</div>
	</form>
</div>

</div>