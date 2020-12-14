<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('classroom/list'); ?>" method="post" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="classroom-id">Classroom ID</label>
						<input type="text" name="classroom-id" id="classroom-id" placeholder="classroom ID" value="<?php if(isset($_POST['classroom-id'])){echo $_POST['classroom-id'];} ?>">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="grade" class="mr-3 d-normal">Grade : </label>
						<select name="grade" id="grade" style="width: 100px">
							<option value="all" <?php if(isset($_POST['grade'])){if($_POST['grade'] == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
							<option value="1" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "1")){echo 'selected="selected"';} ?> >1</option>
							<option value="2" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "2")){echo 'selected="selected"';} ?> >2</option>
							<option value="3" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "3")){echo 'selected="selected"';} ?> >3</option>
							<option value="4" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "4")){echo 'selected="selected"';} ?> >4</option>
							<option value="5" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "5")){echo 'selected="selected"';} ?> >5</option>
							<option value="6" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "6")){echo 'selected="selected"';} ?> >6</option>
							<option value="7" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "7")){echo 'selected="selected"';} ?> >7</option>
							<option value="8" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "8")){echo 'selected="selected"';} ?> >8</option>
							<option value="9" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "9")){echo 'selected="selected"';} ?> >9</option>
							<option value="10" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "10")){echo 'selected="selected"';} ?> >10</option>
							<option value="11" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "11")){echo 'selected="selected"';} ?> >11</option>
							<option value="12" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "12")){echo 'selected="selected"';} ?> >12</option>
							<option value="13" <?php if(isset($_POST['grade']) && ($_POST['grade'] == "13")){echo 'selected="selected"';} ?> >13</option>
						</select>
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">Class:</label>
						<select name="class" id="class">
							<option value="all" <?php if(isset($_POST['class']) && ($_POST['class'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="A" <?php if(isset($_POST['class']) && ($_POST['class'] == "A")){echo 'selected="selected"';} ?> >A</option>
							<option value="B" <?php if(isset($_POST['class']) && ($_POST['class'] == "B")){echo 'selected="selected"';} ?> >B</option>
							<option value="C" <?php if(isset($_POST['class']) && ($_POST['class'] == "C")){echo 'selected="selected"';} ?> >C</option>
							<option value="D" <?php if(isset($_POST['class']) && ($_POST['class'] == "D")){echo 'selected="selected"';} ?> >D</option>
							<option value="E" <?php if(isset($_POST['class']) && ($_POST['class'] == "E")){echo 'selected="selected"';} ?> >E</option>
							<option value="F" <?php if(isset($_POST['class']) && ($_POST['class'] == "F")){echo 'selected="selected"';} ?> >F</option>
							<option value="G" <?php if(isset($_POST['class']) && ($_POST['class'] == "G")){echo 'selected="selected"';} ?> >G</option>
							<option value="H" <?php if(isset($_POST['class']) && ($_POST['class'] == "H")){echo 'selected="selected"';} ?> >H</option>
						</select>				
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" name="search" value="Show">
				</div>
			</form>
		</div>

		<div class="col-10 flex-col" style="overflow-x: scroll;overflow-y: hidden;">

		    <table class="table-strip-dark">
			    <caption class="p-5">Classrooms</caption>
			    <thead>
				    <tr>
                        <th>CLASS ID</th>
                        <th>GRADE</th>
                        <th>CLASS</th>
                        <th>CLASS TEACHER</th>
                        <th>STUDENTS</th>
                        <th>TIMETABLE</th>
					    <th>UPDATE</th>
					    <th>DELETE</th>
				    </tr>
			    </thead>
			    
                <tbody>

				<?php 
				if(isset($result_set) && !empty($result_set)){
					foreach ($result_set as $result) {
                ?>

					<tr>
                        <td><?php echo $result['id']; ?></td>
                        <td class="text-center"><?php echo $result['grade']; ?></td>
                        <td class="text-center"><?php echo $result['class']; ?></td>
                        <td><?php echo $result['class_teacher_id']; ?></td>
                        <td>
							<div class="login_buttons col-12 col-md-12 justify-content-end d-flex align-items-center">
                				<a class="btn btn-blue p-1" href="<?php  echo set_url('classroom/student/list/'.$result['id']); ?> ">List</a>
                				<a class="btn btn-blue p-1 ml-3" href="<?php  echo set_url('classroom/student/add/'.$result['id']); ?>">Add</a>
		    				</div>
						</td>
						<td>
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
                				<a class="btn btn-blue p-1" href="<?php  echo set_url('classroom/timetable/'.$result['id']); ?>">View</a>
		    				</div>
						</td>
						<td>
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
                				<a class="btn btn-blue p-1" href="<?php echo set_url('classroom/update/'.$result['id']); ?> ">Update</a>
		    				</div>
						</td>

						<td>
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
								<a class="btn btn-lightred p-1" href="classroomsnew-delete.php?id=<?php echo $result['id']; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>
		    				</div>
						</td>
					</tr>

				<?php
					}
				}else{
					echo "<tr><td colspan=8 class='text-center bg-red'>Classroom not found...</td></tr>";
				}
                ?>
                 
                </tbody>
        
            </table>
        

		</div>  
        <div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
            <a class="btn btn-blue" href="<?php echo set_url('classroom/registration'); ?> ">Add Classes</a>
	    </div>

</div>

