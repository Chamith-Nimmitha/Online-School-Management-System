
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error)){
			echo "<p class='w-75 p-2 bg-red fg-white text-center'>";
			echo $error;
			echo "</p>";
		}
	 ?>

	<div class="mt-5  w-75 d-flex flex-col align-items-center">
		<h2>Your Interview Panel</h2>
		<hr class="topic-hr w-100">
	</div>
	<form action="<?php echo set_url('pages/interview_panel_view.php'); if(isset($_GET['interview-panel-id'])){echo '?interview-panel-id='.$_GET['interview-panel-id'];} ?>" class="col-12" method="POST">
		<div class="col-12 col-lg-6 p-3">
			<fieldset>
				<legend>Basic Info</legend>
				<div class="form-group">
					<label for="panel-id">Panel ID</label>
					<input type="text" name="panel-id" id="panel-id" value="<?php if(isset($interview_panel['id'])){echo $interview_panel['id'];}else{ echo $next_id;} ?>" disabled="disabled">
				</div>

				<div class="form-group">
					<label for="panel-grade">Grade (<code title="required"> * </code>)</label>
					<select name="grade" id="grade" onchange="interview_panel_grade(this.value,'panel-name',<?php echo $next_id; ?>)" disabled="disabled">
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
					<input type="text" name="panel-name" id="panel-name" value="<?php if(isset($interview_panel['name'])){echo $interview_panel['name'];} ?>" disabled="disabled">
				</div>

			</fieldset>
		</div>
		<div class="col-12 col-lg-6 p-3">
			<fieldset class="col-12 flex-col">
				<legend>Teachers Info</legend>
				<div id="interview-teachers">
					<?php 

						if(isset($interview_panel_teachers) && !empty($interview_panel_teachers)){
							$i =1;
							foreach ($interview_panel_teachers as $id) {
								$row = '<div id="teacherid-'.$i.'" class="form-group interview-teacher-id">';
								$row .= "<label for='teacher-".$i."'> Teacher ID (<code title=\"required\"> * </code>)</label>";
								$row .= '<input type="text" name="teacher-'.$i.'" id="teacher-'.$i.'" required="required" value="';
								$row .= $id['id'].'" oninput="validate_user_input(this,7,7,1)" disabled="disabled">';
								$row .= '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
								$row .= '</div>';
								echo $row;
								$i+=1;
							}
						}
					 ?>
				</div>
			</fieldset>
		</div>
	</form>
</div>
