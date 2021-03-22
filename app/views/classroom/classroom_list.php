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
		<div class="student-header mt-3  w-75 d-flex flex-col align-items-center">
			<h2 class="fs-30">Classroom List</h2>
			<hr class="topic-hr w-100">
		</div>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('classroom/list'); ?>" method="post" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="Reset">
					</div>
					<div class="ml-5">
						<label for="classroom-id">Classroom ID</label>
						<input type="text" name="classroom-id" id="classroom-id" placeholder="classroom ID" value="<?php if(isset($_POST['classroom-id'])){echo $_POST['classroom-id'];} ?>" oninput="classroom_search()">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="grade" class="mr-3 d-normal">Grade : </label>
						<select name="grade" id="grade" style="width: 100px">
							<option value="all" <?php if(isset($grade)){if($grade == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
							<option value="1" <?php if(isset($grade) && ($grade == "1")){echo 'selected="selected"';} ?> >1</option>
							<option value="2" <?php if(isset($grade) && ($grade == "2")){echo 'selected="selected"';} ?> >2</option>
							<option value="3" <?php if(isset($grade) && ($grade == "3")){echo 'selected="selected"';} ?> >3</option>
							<option value="4" <?php if(isset($grade) && ($grade == "4")){echo 'selected="selected"';} ?> >4</option>
							<option value="5" <?php if(isset($grade) && ($grade == "5")){echo 'selected="selected"';} ?> >5</option>
							<option value="6" <?php if(isset($grade) && ($grade == "6")){echo 'selected="selected"';} ?> >6</option>
							<option value="7" <?php if(isset($grade) && ($grade == "7")){echo 'selected="selected"';} ?> >7</option>
							<option value="8" <?php if(isset($grade) && ($grade == "8")){echo 'selected="selected"';} ?> >8</option>
							<option value="9" <?php if(isset($grade) && ($grade == "9")){echo 'selected="selected"';} ?> >9</option>
							<option value="10" <?php if(isset($grade) && ($grade == "10")){echo 'selected="selected"';} ?> >10</option>
							<option value="11" <?php if(isset($grade) && ($grade == "11")){echo 'selected="selected"';} ?> >11</option>
							<option value="12" <?php if(isset($grade) && ($grade == "12")){echo 'selected="selected"';} ?> >12</option>
							<option value="13" <?php if(isset($grade) && ($grade == "13")){echo 'selected="selected"';} ?> >13</option>
						</select>
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">Class:</label>
						<select name="class" id="class">
							<option value="all" <?php if(isset($class) && ($class == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="A" <?php if(isset($class) && ($class == "A")){echo 'selected="selected"';} ?> >A</option>
							<option value="B" <?php if(isset($class) && ($class == "B")){echo 'selected="selected"';} ?> >B</option>
							<option value="C" <?php if(isset($class) && ($class == "C")){echo 'selected="selected"';} ?> >C</option>
							<option value="D" <?php if(isset($class) && ($class == "D")){echo 'selected="selected"';} ?> >D</option>
							<option value="E" <?php if(isset($class) && ($class == "E")){echo 'selected="selected"';} ?> >E</option>
							<option value="F" <?php if(isset($class) && ($class == "F")){echo 'selected="selected"';} ?> >F</option>
							<option value="G" <?php if(isset($class) && ($class == "G")){echo 'selected="selected"';} ?> >G</option>
							<option value="H" <?php if(isset($class) && ($class == "H")){echo 'selected="selected"';} ?> >H</option>
						</select>				
					</div>
					<button onclick="classroom_search()" class="btn btn-blue ml-3 mt-5">Filter</button>
				</div>
			</form>
		</div>

		<div class="col-12 mt-5 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
			<div class="loader hide-loader">
			 	<div class="col-12">
					<div id="one"><div></div></div>
					<div id="two"><div></div></div>
					<div id="three"><div></div></div>
					<div id="four"><div></div></div>
					<div id="five"></div>
			 	</div>
			</div>
		    <table class="table-strip-dark text-center">
			    <thead>
				    <tr>
                        <th>Class ID</th>
                        <th>Grade</th>
                        <th>Class</th>
                        <th>Class Teacher</th>
                        <th>Students</th>
                        <th>Timetable</th>
                        <th>View</th>
                        <?php 
	                        if($_SESSION['role']==='admin'){
                         ?>
					    <th>Subjects</th>
					    <th>Update</th>
					    <th>Delete</th>
						<?php } ?>
				    </tr>
			    </thead> 
			    
                <tbody id="tbody">

				<?php 
				if(isset($result_set) && !empty($result_set)){
					$grade = 0;
					foreach ($result_set as $result) {
                ?>
                	<?php 
                		if($grade !== 0 && $grade != $result['grade']){
                			echo "<tr><td colspan=10 class='text-center bg-gray p-0'></td></tr>";
                			echo "<tr><td colspan=10 class='text-center bg-gray'></td></tr>";
                		}
                	 ?>
					<tr>
                        <td><?php echo $result['id']; ?></td>
                        <td class="text-center"><?php echo $result['grade']; ?></td>
                        <td class="text-center"><?php echo $result['class']; ?></td>
                        <td><?php if(isset($result['class_teacher_id']) && !empty($result['class_teacher_id'])) {echo $result['class_teacher_id'];}else{echo 'Not Asign';} ?></td>
                        <td>
							<div class="login_buttons col-12 col-md-12 justify-content-center d-flex align-items-center">
                				<a class="btn btn-blue p-1" href="<?php  echo set_url('classroom/student/list/'.$result['id']); ?> ">List</a>
                				<?php 
			                        if($_SESSION['role']==='admin'){
		                         ?>
                				<a class="btn btn-blue p-1 ml-3" href="<?php  echo set_url('classroom/student/add/'.$result['id']); ?>">Add</a>
	                			<?php } ?>
		    				</div>
						</td>
						<td class="text-center">
							<?php 
								 if($_SESSION['role']==='admin'){
							 ?>
            				<a class="btn btn-blue p-1" href="<?php  echo set_url('classroom/timetable/'.$result['id']); ?>">Timetable</a>
	            			<?php }else{ ?>
            				<a class="btn btn-blue p-1" href="<?php  echo set_url('classroom/timetable/view/'.$result['id']); ?>">Timetable</a>
	        				<?php } ?>
						</td>

						<td class="text-center">
							<a class="btn btn-blue p-1" href="<?php  echo set_url('classroom/view/'.$result['id']); ?>">View</a>
						</td>
						<?php 
	                        if($_SESSION['role']==='admin'){
                         ?>
                         	<td>
								<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
	                				<a class="btn btn-blue p-1" href="<?php echo set_url('classroom/subjects/'.$result['id']); ?> ">Subjects</a>
			    				</div>
							</td>
							<td>
								<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
	                				<a class="btn btn-blue p-1" href="<?php echo set_url('classroom/update/'.$result['id']); ?> ">Update</a>
			    				</div>
							</td>

							<td>
								<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
									<a class="btn p-1" title='Delete' href="<?php echo set_url('classroom/delete/').$result['id']; ?>" onclick="show_dialog(this,'Delete message','Are you sure to delete?')"><i class='fas fa-trash delete-button'></i></a>
			    				</div>
							</td>
						<?php } ?>
					</tr>

				<?php
				$grade = $result['grade'];
					}
				}else{
					echo "<tr><td colspan=10 class='text-center bg-red'>Classroom Not Found...</td></tr>";
				}
                ?>
                 
                </tbody>
        
            </table>
        

		</div>
		<div id="pagination" class="col-12">
			<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "classroom/list","classroom_search"); ?>
			</div>
		</div>  
        <div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
            <a class="btn btn-blue" href="<?php echo set_url('classroom/registration'); ?> ">Add Classes</a>
	    </div>

</div>

