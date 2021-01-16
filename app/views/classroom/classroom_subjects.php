
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

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
			<span class="mb-3">Insert optional subjects in <span style="color: red;">GENERAL FORMAT.</span></span>
			<div class="col-12" id="classroom-subject-wrapper">
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-1">Subject 1</label>
					<input class="col-6 mr-2" type="text" name="subject-1" id="subject-1" placeholder="Subject Name" value="" oninput="validate_user_input(this,0,20,1)">
					<input class="col-3" type="text" name="periods-1" id="periods-1" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-2">Subject 2</label>
					<input class="col-6 mr-2" type="text" name="subject-2" id="subject-2" placeholder="Subject Name" value="" oninput="validate_user_input(this,0,20,1)">
					<input class="col-3" type="text" name="periods-2" id="periods-2" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>
				<div class="d-flex col-12 align-items-center p-2 mb-3">
					<label class="col-2"  for="subject-3">Subject 3</label>
					<input class="col-6 mr-2" type="text" name="subject-3" id="subject-3" placeholder="Subject Name" value="" oninput="validate_user_input(this,0,20,1)">
					<input class="col-3" type="text" name="periods-3" id="periods-3" placeholder="No of Periods" value="" oninput="validate_user_input(this,0,20,1)">
					<p class="bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center"></p>
				</div>
			</div>
			<div class="w-100 d-flex justify-content-end" id="classroom-subject-buttons">
				<button type="button" id="add_classroom_subject" class="mr-3 p-2">+ Add Subject</button>
				<button type="button" id="remove_classroom_subject">+ Remove Subject</button>
			</div>
		</fieldset>
		<div class="w-100 d-flex justify-content-end">
			<input type="submit" name="submit" value="Submit" class="btn btn-blue">
		</div>
	</form>
</div>

</div>