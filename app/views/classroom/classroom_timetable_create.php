<?php 
	$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
	$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];
 ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error)){
			echo "<p class='bg-red p-3 w-75 text-center fg-white'>";
			echo $error;
			echo "</p>";
		}
		if(isset($info)){
			echo "<p class='bg-green p-3 w-75 text-center fg-white'>";
			echo $info;
			echo "</p>";
		}

	 ?>

	 <p id="ajax_update_state" class='bg-green p-3 w-75 text-center fg-white d-none'>
	 </p>

	<div class="mt-5 text-center">
		<h2 style="font-size: 30px;">Classroom Timetable Create/Update</h2>
		<span><?php echo $grade."-".$class; ?> Classroom</span>
		<input type="hidden" id="classroom_id" value="<?php echo $classroom_id; ?>">
		<input type="hidden" id="classroom_grade" value="<?php echo $grade; ?>">
		<input type="hidden" id="classroom_class" value="<?php echo $class; ?>">
	</div>
	<div class="col-12 d-flex flex-col mt-5">
		<hr class="w-100">
		<div class="p-5">
			<form action="<?php echo set_url('classroom/timetable/'.$classroom_id); ?>" method="post" id="timetable_form">
				<table class="w-100 table-strip-dark" id="classroom_timetable">
					<thead>
						<tr>
							<th style="width: 20%;">Time\Day</th>
							<th style="width: 15%;">Mon</th>
							<th style="width: 15%;">Tue</th>
							<th style="width: 15%;">Wed</th>
							<th style="width: 15%;">Thu</th>
							<th style="width: 15%;">Fri</th>
						</tr>
					</thead>
					<tbody>
						

				<?php 

					if(isset($subjects) && !empty($subjects)){
						for ($i=1; $i <= 9; $i++) { 

							if($i == 5){
								echo "<tr><th colspan='6' class='text-center bg-gray fg-white'>Interval</th></tr>";
								continue;
							}
							$period = $i > 5 ? $i-1 : $i;

							$row = "<tr>";
							$row .= "<th>".$time_map[$period]."</th>";
							for ($j=1; $j <=5 ; $j++) { 
								$row .= "<td>";
								$row .= '<select name="'.$day_map[$j].'-'.$period.'" id="'.$day_map[$j].'-'.$period.'">';
									$row .= '<option value="FREE">FREE</option>';
								// for general sunjects
								foreach ($subjects['general'] as $sub) {
									$row .= '<option value="G--'.$sub['id'].'"';
									if(!empty($timetable_data) && $timetable_data[$day_map[$j]][$period] == "G--".$sub['id']){
										$row .= " selected='selected'";
									}
									$row .= '>'.ucfirst($sub['name']).'</option>';
								}
								// for optional subjects
								foreach ($subjects['optional'] as $sub) {
									$row .= '<option value="OP--'.$sub['category'].'"';
									if(!empty($timetable_data) && $timetable_data[$day_map[$j]][$period] == "OP--".$sub['category']){
										$row .= " selected='selected'";
									}
									$row .= '>'.ucfirst($sub['category']).'</option>';
								}
								// for other subjects
								foreach ($subjects['other'] as $sub) {
									$row .= '<option value="OT--'.$sub['id'].'"';
									if(!empty($timetable_data) && $timetable_data[$day_map[$j]][$period] == "OT".$sub['id']){
										$row .= " selected='selected'";
									}
									$row .= '>'.ucfirst($sub['name']).'</option>';
								}

								$row .= "</select>";		
								$row .= "</td>";
							}
						$row .= "</tr>";
						echo $row;
						}
					}else{
						echo "<tr><td colspan=7 class='text-center bg-red'>Students not found...</td></tr>";
						echo "</tbody>";
						echo "</table>";
					}
				 ?>
					</tbody>
				</table>
				<div class="d-flex justify-content-end p-5">
					<button type="submit" name="timetable_submit" id="timetable_submit" class="btn btn-blue p-3" >Submit</button>
				</div>
			</form>

			<!-- teachers for subjects is automatically choose by our system -->
			<div class="d-flex flex-col align-items-center justify-content-center col-12 mb-5">
				<div>
					<h3 style="font-size: 25px;">Classroom Subjects</h3>
				</div>
				<div class="col-8">
					<form action="<?php echo set_url('classroom/subject/teacher/'.$classroom_id); ?>" class="col-12" method="POST" id="subject_form">
						<table class="table-strip-dark col-12" id="subject_table">
							<thead class="col-12">
								<tr class="text-center col-12">
									<th class="col-1 justify-content-center">No.</th>
									<th class="col-3 justify-content-center">Subject Name</th>
									<th class="col-3 justify-content-center">No of Periods</th>
									<th class="col-5 justify-content-center">Teacher</th>
								</tr>
							</thead>
							<tbody class="col-12">
							<!-- for general subjects -->
							<?php if((!isset($subjects['general']) || empty($subjects['general'])) && (!isset($subjects['optional']) || empty($subjects['optional'])) && (!isset($subjects['other']) || empty($subjects['other']))){
								echo "<tr class='col-12'><td colspan=4 class='bg-red w-100 text-center'>Subject Not Found...</td></tr>";
							}  ?>
							<?php if(isset($subjects['general']) && !empty($subjects['general'])){
									for($i=0; $i < count($subjects['general']); $i++) { ?>
										<tr class="col-12 justify-content-center align-items-center">
											<input type="hidden" name="<?php echo "G--".$subjects['general'][$i]['id']."--".$subjects['general'][$i]['periods']; ?>" id="<?php echo "G--".$subjects['general'][$i]['id']."--".$subjects['general'][$i]['periods']; ?>" value="<?php echo "G--".$subjects['general'][$i]['id']."--".$subjects['general'][$i]['periods']; ?>">
											<td class="text-center justify-content-center col-1"><?php echo ($i+1);?></td>
											<td class=" col-3"><?php echo ucfirst($subjects['general'][$i]['name']); ?></td>
											<td class="text-center col-3 justify-content-center"><?php echo $subjects['general'][$i]['periods'];?></td>
											<td class=" col-5">
												<select name="subject-teacher-<?php echo $subjects['general'][$i]['id']; ?>" id="subject-teacher-<?php echo $subjects['general'][$i]['id']; ?>">
													<option value="None">None</option>
													<?php foreach ($subject_teachers[$subjects['general'][$i]['id']] as $teacher): ?>
														<option value="<?php echo $teacher['id']; ?>" <?php if($subjects['general'][$i]['teacher_id']== $teacher['id']){echo "selected='selected'";} ?>><?php echo $teacher['name_with_initials']." - ".$teacher['id']; ?></option>
													<?php endforeach ?>
												</select>
											</td>
										</tr>
							<?php }
							} ?>
							<!-- for optional subjects -->
							<?php if(isset($subjects['optional']) && !empty($subjects['optional'])){
									for($i=0; $i < count($subjects['optional']); $i++) { ?>
										<tr class="col-12 justify-content-center align-items-center">
											<input type="hidden" name="<?php echo "OP--".$subjects['optional'][$i]['category']."--".$subjects['optional'][$i]['periods']; ?>" id="<?php echo "OP--".$subjects['optional'][$i]['category']."--".$subjects['optional'][$i]['periods']; ?>" value="<?php echo "OP--".$subjects['optional'][$i]['category']."--".$subjects['optional'][$i]['periods']; ?>">
											<td class="text-center justify-content-center col-1"><?php echo ($i+1);?></td>
											<td class=" col-3"><?php echo ucfirst($subjects['optional'][$i]['category']); ?></td>
											<td class="text-center col-3 justify-content-center"><?php echo $subjects['optional'][$i]['periods'];?></td>
											<td class=" col-5">
											</td>
										</tr>
							<?php }
							} ?>
							<!-- for other subjects -->
							<?php if(isset($subjects['other']) && !empty($subjects['other'])){
									for($i=0; $i < count($subjects['other']); $i++) { ?>
										<tr class="col-12 justify-content-center align-items-center">
											<input type="hidden" name="<?php echo "OT--".$subjects['other'][$i]['id']."--".$subjects['other'][$i]['periods']; ?>" id="<?php echo "OT--".$subjects['other'][$i]['id']."--".$subjects['other'][$i]['periods']; ?>" value="<?php echo "OT--".$subjects['other'][$i]['id']."--".$subjects['other'][$i]['periods']; ?>">
											<td class="text-center justify-content-center col-1"><?php echo ($i+1);?></td>
											<td class=" col-3"><?php echo ucfirst($subjects['other'][$i]['name']); ?></td>
											<td class="text-center col-3 justify-content-center"><?php echo $subjects['other'][$i]['periods'];?></td>
											<td class=" col-5">
											</td>
										</tr>
							<?php }
							} ?>
							</tbody>
						</table>
						<div class="d-flex justify-content-end col-12">
							<input type="submit" name="submit" id="submit" value="Update" class="btn btn-blue">
						</div>
					</form>
				</div>
			</div>

            <center>
			    <div>
                    <a class="btn btn-blue" onClick="window.print()">Download as a PDF</a>
	            </div>
			</center>
		</div>
		
	</div>
</div>
