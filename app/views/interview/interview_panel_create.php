
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($info) && !empty($info)){
			 echo "<p class='w-75 bg-green p-2 text-center'>";
            echo $info;
            echo "</p>";
		}
		if(isset($error) && !empty($error)){
            echo "<p class='w-75 bg-red p-2 text-center'>";
            echo $error;
            echo "</p>";
        }
	 ?>
	<div>
		<h2>Create and Update Interview Panel</h2>
	</div>
	<form action="<?php if(isset($interview_panel['id'])){echo set_url('interviewpanel/view/'.$interview_panel['id']);} else{ echo set_url('interviewpanel/registration'); }; ?>" class="col-12" method="POST">
		<div class="col-12 col-lg-6 p-3">
			<fieldset>
				<legend>Basic Info</legend>
				<div class="form-group">
					<label for="panel-id">Panel ID</label>
					<input type="text" name="panel-id" id="panel-id" value="<?php if(isset($interview_panel['id'])){echo $interview_panel['id'];}else{ echo $next_id;} ?>" disabled="disabled">
				</div>

				<div class="form-group">
					<label for="panel-grade">Grade (<code title="required"> * </code>)</label>
					<select name="grade" id="grade" onchange="interview_panel_grade(this.value,'panel-name',<?php echo $next_id; ?>)">
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
								$row .= "<label for='teacher-".$i."'> Teacher ID</label>";
								$row .= '<input type="text" name="teacher-'.$i.'" placeholder="Teacher ID" id="teacher-'.$i.'" value="';
								$row .= $id['id'].'" required="required">';
								$row .= '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
								if($i >1){
									$row .= '<button type="button" class="mt-2 float-right" onclick="removeElement(
										\'teacherid-'.$i.'\')">-remove teacher</button>';
								}
								$row .= '</div>';
								echo $row;
								$i+=1;
							}
						}else{
							echo '<div id="teacherid-1" class="form-group interview-teacher-id">
									<label for="teacher-1">Teacher ID</label>
									<input type="text" name="teacher-1" placeholder="Teacher ID" id="teacher-1"  required="required">
									<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>
								</div>';
						}
					?>
				</div>

				<?php 	
					if(isset($interview_teachers) && !empty($interview_teachers)){
						echo '<div class=" form-group d-flex justify-content-end">
							<button type="button" class="btn btn-blue"  id="add-teacher"  onclick="interview_add_teacher(this,\'interview-teachers\','.count($interview_teachers).')">+add a teacher</button>
						</div>';
					}else{
						echo '<div class=" form-group d-flex justify-content-end">
							<button type="button" class="btn btn-blue" id="add-teacher"  onclick="interview_add_teacher(this,\'interview-teachers\',2)">+add a teacher</button>
						</div>';
					}
				 ?>

				<hr>
				<div class="d-flex justify-content-end">
					<?php 
						if(isset($interview_panel['id'])){
							echo '<button type="submit" class="btn btn-blue" name="update" id="update">update</button>';
						}else{
							echo '<button type="submit" class="btn btn-blue" name="create" id="create">Create</button>';
						}
					 ?>
				</div>
			</fieldset>
		</div>
	</form>
</div>
