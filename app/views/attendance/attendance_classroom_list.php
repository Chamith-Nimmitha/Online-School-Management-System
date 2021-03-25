<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

		<div class="section-wrapper mt-5 mb-5">
				<h2 class="pt-3 pb-3">
					Classroom List
				</h2>
				<hr class="topic-hr w-100">
			<div class="d-flex justify-content-center align-items-center">
				<form action="<?php echo set_url('pages/attendance_classroom_list.php'); ?>" method="post" id="classroom_filter" class="d-flex align-items-center col-12">
					<div class="d-flex col-12 align-items-center justify-content-center">
						<div class="mt-5">
							<input type="reset" class="btn btn-blue" onclick="reset_form('classroom_filter','attendance_classroom_search')" value="Reset">
						</div>
						<div class="ml-5">
							<label for="classroom-id">Classroom ID</label>
							<input type="text" name="classroom-id" id="classroom-id" placeholder="classroom ID" value="<?php if(isset($_POST['classroom-id'])){echo $_POST['classroom-id'];} ?>" oninput="attendance_classroom_search()">
						</div>
						<div  class="  ml-5 align-items-center">
							<label for="grade" class="mr-3 d-normal">Grade : </label>
							<select name="grade" id="grade" style="width: 100px" onchange="attendance_classroom_search()">
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
							<select name="class" id="class" onchange="attendance_classroom_search()">
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
					</div>
				</form>
			</div>

			<div class="col-10 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
				<div class="loader hide-loader">
				 	<div class="col-12">
						<div id="one"><div></div></div>
						<div id="two"><div></div></div>
						<div id="three"><div></div></div>
						<div id="four"><div></div></div>
						<div id="five"></div>
				 	</div>
				</div>

			    <table class="table-strip-dark">
				    <thead>
					    <tr>
	                        <th>Classroom ID</th>
	                        <th>Grade</th>
	                        <th>Class</th>
	                        <th>Class Teacher</th>
	                        <th>Attendance</th>
					    </tr>
				    </thead>
				    
	                <tbody id="tbody">

					<?php
					if(isset($result_set) && !empty($result_set)){
						$grade = 0;
						foreach ($result_set as $result) {
							if($grade !== 0 && $grade != $result['grade']){
	                			echo "<tr><td colspan=8 class='text-center p-0 bg-gray'></td></tr>";
	                			echo "<tr><td colspan=8 class='text-center bg-gray'></td></tr>";
	                		}
		                ?>

							<tr>
		                        <td class='text-center'><?php echo $result['id']; ?></td>
		                        <td class="text-center"><?php echo $result['grade']; ?></td>
		                        <td class="text-center"><?php echo $result['class']; ?></td>
		                        <td class="text-center"><?php if(!empty($result['class_teacher_id'])){echo $result['class_teacher_id'];}else{echo 'Not Asign';} ?></td>
								<td class="text-center">
									<div>
		                				<a class="btn" href="<?php echo set_url('attendance/classroom/view/'.$result['id']); ?>"><i title="view" class="view-button far fa-eye"></i></a>
				    				</div>
								</td>
							</tr>

						<?php
						$grade = $result['grade'];
						}
					}else{
						echo "<tr><td colspan=8 class='text-center bg-red'>Classrooms not found...</td></tr>";
					}
	                ?>
	                 
	                </tbody>
	        
	            </table>
			</div>  
			<div id="pagination" class="col-12">
				<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
				<div id="pagination_data" class="col-12">
					<?php require_once(INCLUDES."pagination.php"); ?>
					<?php display_pagination($count,$page,$per_page, "attendance/classroom/list","attendance_classroom_search"); ?>
				</div>
			</div>  
		</div>

		<div class="col-12 justify-content-center" >
			<h2 class="text-center p-5">Classroom Attendance Charts</h2>
			<hr class="topic-hr w-100">
			<div class="col-12 d-flex justify-content-center">
				<form id="classroom_attendance_comparission" class="col-11 d-flex mb-3 align-items-center justify-content-start">
					<button type="reset" class="btn btn-blue mr-2 mt-5 p-2" onclick="setTimeout( ()=>{show_classroom_filter_option_class('compare_grade');show_classroom_filter_option_date('compare_class');},100);">Reset</button>
					<div class="mr-2">
						<label for="grade">Grade</label>
						<select name="grade" id="compare_grade" onchange="show_classroom_filter_option_class('compare_grade')">
							<option value="None">Select Grade</option>
							<?php if(isset($sections) && !empty($sections)){
								foreach ($sections as $section) { ?>
									<option value="<?php echo $section['grade']; ?>"> <?php echo $section['grade']; ?></option>
								<?php }
								} ?>
						</select>
					</div>
					<div id="classroom_filter_option_class" class="mr-2 d-none flex-col align-items-start">
						<label for="class">Classroom</label>
						<select name="class" id="compare_class" onchange="show_classroom_filter_option_date('compare_class')">
							<option value="None">Select Class</option>
						</select>
					</div>
					<div class="d-flex flex-col align-items-start" id="full_date">
						<label for="date">Date</label>
						<input type="date" name="date" value="<?php if(isset($date)){ echo $date;}else{echo date('Y-m-d');} ?>" id="date" class="p-1">
					</div>
					<div id="classroom_filter_option_date" class="d-none">
						<div id="classroom_filter_option_year" class="mr-2 d-flex flex-col align-items-start">
							<label for="year">Year</label>
							<select name="year" id="year">
								<option value="<?php echo date('Y'); ?>">This Year</option>
								<option value="2021">2021</option>
								<option value="2020">2020</option>
							</select>
						</div>
						<div  class="mr-2 d-flex flex-col align-items-start">
							<label for="month">Month</label>
							<select name="month" id="month">
								<option value="<?php echo date('m'); ?>">This Month</option>
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
					</div>
					<button type="button" onclick="classroom_attendance_comparission_bar()" class="btn btn-blue ml-2 mt-5 p-2">Filter</button>
				</form>
			</div>
			<div class="col-8 bg-white" style="position: relative;">
				<div class="loader" id="classroom_attendance_bar">
				 	<div class="col-12">
						<div id="one"><div></div></div>
						<div id="two"><div></div></div>
						<div id="three"><div></div></div>
						<div id="four"><div></div></div>
						<div id="five"></div>
				 	</div>
				</div>
				<canvas id="classroom_attendance_comparission_bar" width="100" height="80"></canvas>
			</div>
		</div>
</div>