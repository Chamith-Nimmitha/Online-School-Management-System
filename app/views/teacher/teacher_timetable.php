
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='bg-red p-3 w-75 text-center fg-white'>";
			echo $error;
			echo "</p>";
		}
		if(isset($info) && !empty($info)){
			echo "<p class='bg-green p-3 w-75 text-center fg-white'>";
			echo $info;
			echo "</p>";	
		}

	 ?>

	<div class="mt-5  w-75 d-flex flex-col align-items-center">
		<h2>Teacher Timetable</h2>
		<hr class="topic-hr w-100">
	</div>

	<form action="#" method="POST" class="col-12 d-flex flex-col align-items-center">
		<fieldset class="col-12 col-md-8 col-lg-6 p-3">
			<legend>Timetable Info</legend>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Teacher ID</label>
				<input class="" type="text" name="id" placeholder="Teacher ID" value="<?php if(isset($teacher_info)){echo $teacher_info['id'];} ?>" disabled="disabled">
			</div>
			<div class="d-flex w-100">
				<label class="col-4" for="id">Teacher Name</label>
				<input class="" type="text" name="name" placeholder="Teacher Name" value="<?php if(isset($teacher_info)){echo $teacher_info['name_with_initials'];} ?>" disabled="disabled">
			</div>
			
		</fieldset>
	</form>
	<div class="col-12 d-flex flex-col mt-5">
		<hr class="w-100">
		<div class="p-5">
			<table class="w-100 table-strip-dark text-center">
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
				if(isset($timetable) && !empty($timetable)){
					for ($i=1; $i <= 9; $i++) { 

						if($i == 5){
							echo "<tr><th colspan='6' class='text-center bg-gray fg-white'>Interval</th></tr>";
							continue;
						}
						$period = $i > 5 ? $i-1 : $i;

						$row = "<tr>";
						$row .= "<th>".$time_map[$period]."</th>";
						for ($j=1; $j <=5 ; $j++) { 
							$td = $timetable["{$day_map[$j]}"][$period];
							if($td=="FREE"){
								$row .= "<td>";
								$row .= "FREE";
								$row .= "</td>";
							}else{
								$row .= "<td>";
								$row .= "{$td[0]}({$td[2]})";
								$row .= "</td>";
							}
						}
						$row .= "</tr>";
						echo $row;
					}
				}else{
					echo "<tr><td colspan=7 class='text-center bg-red'>Timetable Not Found...</td></tr>";
					echo "</tbody>";
					echo "</table>";
				}
			 ?>
				</tbody>
			</table>
		</div>
		
	</div>
</div>