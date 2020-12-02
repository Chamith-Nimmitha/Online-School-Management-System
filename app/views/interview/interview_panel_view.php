
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 p-2 bg-red fg-white text-center'>";
			echo $error;
			echo "</p>";
		}
	 ?>

	<div>
		<h2>Create and Update Interview Panel</h2>
	</div>
	<form action="<?php echo set_url('interviewpanel/view/'.$interview_panel['id']); ?>" class="col-12" method="POST">
		<div class="col-12 col-lg-6 p-3">
			<fieldset>
				<legend>Basic Info</legend>
				<div class="form-group">
					<label for="panel-id">Panel ID</label>
					<input type="text" name="panel-id" id="panel-id" value="<?php if(isset($interview_panel['id'])){echo $interview_panel['id'];}?>" disabled="disabled">
				</div>

				<div class="form-group">
					<label for="panel-grade">Grade (<code title="required"> * </code>)</label>
					<select name="grade" id="grade" onchange="interview_panel_grade(this.value,'panel-name',<?php echo $_GET['interview-panel-id']; ?>)">
						<option value="0" <?php if(!isset($interview_panel['grade'])){echo "selected='selected'";} ?>>Select ...</option>
						<option value="1" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "1"){echo "selected='selected'";} ?>>grade 1</option>
						<option value="2" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "2"){echo "selected='selected'";} ?>>grade 2</option>
						<option value="3" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "3"){echo "selected='selected'";} ?>>grade 3</option>
						<option value="4" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "4"){echo "selected='selected'";} ?>>grade 4</option>
						<option value="5" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "5"){echo "selected='selected'";} ?>>grade 5</option>
						<option value="6" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "6"){echo "selected='selected'";} ?>>grade 6</option>
						<option value="7" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "7"){echo "selected='selected'";} ?>>grade 7</option>
						<option value="8" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "8"){echo "selected='selected'";} ?>>grade 8</option>
						<option value="9" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "9"){echo "selected='selected'";} ?>>grade 9</option>
						<option value="10" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "10"){echo "selected='selected'";} ?>>grade 10</option>
						<option value="11" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "11"){echo "selected='selected'";} ?>>grade 11</option>
						<option value="12" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "12"){echo "selected='selected'";} ?>>grade 12</option>
						<option value="13" <?php if(isset($interview_panel['grade']) && $interview_panel['grade'] == "13"){echo "selected='selected'";} ?>>grade 13</option>
					</select>
				</div>
				<div class="form-group">
					<label for="panel-name">Panel Name</label>
					<input type="text" name="panel-name" id="panel-name" value="<?php if(isset($interview_panel['name'])){echo $interview_panel['name'];} ?>">
				</div>

			</fieldset>
		</div>
		<div class="col-12 col-lg-6 p-3">
			<fieldset class="col-12 flex-col">
				<legend>Teachers Info</legend>
				<div id="interview-teachers">
					<?php 

						if(isset($interview_teachers) && !empty($interview_teachers)){
							$i =1;
							foreach ($interview_teachers as $id) {
								$row = '<div id="teacherid-'.$i.'" class="form-group interview-teacher-id">';
								$row .= "<label for='teacher-".$i."'> Teacher ID (<code title=\"required\"> * </code>)</label>";
								$row .= '<input type="text" name="teacher-'.$i.'" id="teacher-'.$i.'" required="required" value="';
								$row .= $id['id'].'" oninput="validate_user_input(this,7,7,1)">';
								// $row .= '<input type="hidden" name="hidden-teacher-'.$i.'" id="hidden-teacher-'.$i.'" required="required" value="';
								// $row .= $id['id'].'" >';
								$row .= '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
								if($i >3){
									$row .= '<button type="button" class="mt-2 float-right" onclick="removeElement(
										\'teacherid-'.$i.'\')" required="required">-remove teacher</button>';
								}
								$row .= '</div>';
								echo $row;
								$i+=1;
							}
						}else{
							echo '<div id="teacherid-1" class="form-group interview-teacher-id">
									<label for="teacher-1">Teacher ID (<code title="required"> * </code>)</label>
									<input type="text" name="teacher-1" id="teacher-1" required="required"  oninput="validate_user_input(this,7,7,1)">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>
								<div id="teacherid-2" class="form-group  interview-teacher-id">
									<label for="teacherid-2">Teacher ID (<code title="required"> * </code>)</label>
									<input type="text" name="teacher-2" id="teacher-2" required="required"  oninput="validate_user_input(this,7,7,1)">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>
								<div id="teacherid-3" class="form-group  interview-teacher-id">
									<label for="teacherid-3">Teacher ID (<code title="required"> * </code>)</label>
									<input type="text" name="teacher-3" id="teacher-3" required="required"  oninput="validate_user_input(this,7,7,1)">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>';
						}
					?>
				</div>

				<div class=" form-group d-flex justify-content-end">
					<button type="button" class="btn btn-blue" id="add-teacher"  onclick="interview_add_teacher(this,'interview-teachers')">+add a teacher</button>
				</div>
				<hr>
				<div class="d-flex justify-content-end">
					<?php 
						echo '<button type="submit" class="btn btn-blue" name="update" id="update">update</button>';
					?>
				</div>
			</fieldset>
		</div>
	</form>
</div>