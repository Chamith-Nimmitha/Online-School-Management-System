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

	<div class="mt-5">
		<h2 style="font-size: 30px;">Classroom Timetable Create/Update</h2>
	</div>
	<div class="col-12 d-flex flex-col mt-5">
		<hr class="w-100">
		<div class="p-5">
			<form action="<?php echo set_url('classroom/timetable/'.$classroom_id); ?>" method="post">
				<table class="w-100 table-strip-dark">
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
								$row .= '<select name="'.$day_map[$j].'-'.$period.'" id="">';
									$row .= '<option value="FREE">FREE</option>';
								foreach ($subjects as $sub) {
									$row .= '<option value="'.$sub['code'].'"';
									if(!empty($timetable_data) && $timetable_data[$day_map[$j]][$period] == $sub['code']){
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
					<button type="submit" name="submit" class="btn btn-blue p-3" >Submit</button>
				</div>

				<!-- teachers for subjects is automatically choose by our system -->
				<div class="d-flex flex-col align-items-center justify-content-center col-12 mb-5">
					<div>
						<h3 style="font-size: 25px;">Classroom Subjects</h3>
					</div>
					<div class="col-8">
						<table class="table-strip-dark col-12">
							<thead class="col-12">
								<tr class="text-center col-12">
									<th class="col-1 justify-content-center">No.</th>
									<th class="col-3 justify-content-center">Subject Name</th>
									<th class="col-3 justify-content-center">No of Periods</th>
									<th class="col-5 justify-content-center">Teacher</th>
								</tr>
							</thead>
							<tbody class="col-12">
								<tr class="col-12 justify-content-center align-items-center">
									<td class="text-center justify-content-center col-1">1</td>
									<td class=" col-3">Sinhala</td>
									<td class="text-center col-3 justify-content-center">6</td>
									<td class=" col-5">
										<select name="classroom-subject-techer-1" id="classroom-subject-techer-1">
											<option value="None">None</option>
											<option value="100001" selected="selected">A.B.Nimal</option>
											<option value="100002">C.D.Kamal</option>
										</select>
									</td>
								</tr>

								<tr class="col-12 justify-content-center align-items-center">
									<td class="text-center justify-content-center col-1">2</td>
									<td class=" col-3">Maths</td>
									<td class="text-center col-3 justify-content-center">6</td>
									<td class=" col-5">
										<select name="classroom-subject-techer-1" id="classroom-subject-techer-1">
											<option value="None">None</option>
											<option value="100001">A.B.Nimal</option>
											<option value="100002" selected="selected">C.D.Kamal</option>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

                <center>
				    <div>
                        <a class="btn btn-blue" onClick="window.print()">Download as a PDF</a>
		            </div>
				</center>
			</form>
		</div>
		
	</div>
</div>
