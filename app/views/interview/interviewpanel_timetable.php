
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($errors) && !empty($errors)){
			echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
			foreach ($errors as $error) {
				echo $error ."<br/>";
			}
			echo "</p>";
		}
		if(isset($info) && !empty($info)){
			echo "<p class='w-75 bg-green fg-white p-2 text-center'>";
			foreach ($info as $i) {
				echo $i ."<br/>";
			}
			echo "</p>";
		}

	 ?>
	<div class="d-flex flex-col align-items-center mt-5 col-12">
		<h2>Define Interview Timetable</h2>

		<div id="interview-timetable" class="mt-5 col-9">
			<form action="<?php  echo set_url('interviewpanel/timetable/').$panel_id;?>" class="col-12" method="post">
				<table class="w-100">
					<caption>Interview panel timetable</caption>
					<thead>
						<tr>
						<th >Time</th>
						<th>Monday</th>
						<th>Tuesday</th>
						<th>Wednesday</th>
						<th>Thursday</th>
						<th>Friday</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>7.50a.m -8.30 a.m</th>
							<td  class="<?php if(isset($mon) && $mon[1] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-1" value="<?php if(isset($mon)){echo $mon[1];}else{echo '0';} ?>" ></td>
							<td class="<?php if(isset($tue) && $tue[1] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-1" value="<?php if(isset($tue)){echo $tue[1];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[1] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-1" value="<?php if(isset($wed)){echo $wed[1];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[1] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-1" value="<?php if(isset($thu)){echo $thu[1];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[1] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-1" value="<?php if(isset($fri)){echo $fri[1];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<th>8.30a.m -9.10 a.m</th>
							<td class="<?php if(isset($mon) && $mon[2] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-2" value="<?php if(isset($mon)){echo $mon[2];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[2] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-2" value="<?php if(isset($tue)){echo $tue[2];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[2] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-2" value="<?php if(isset($wed)){echo $wed[2];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[2] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-2" value="<?php if(isset($thu)){echo $thu[2];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[2] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-2" value="<?php if(isset($fri)){echo $fri[2];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<th>9.10a.m -9.50 a.m</th>
							<td class="<?php if(isset($mon) && $mon[3] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-3" value="<?php if(isset($mon)){echo $mon[3];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[3] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-3" value="<?php if(isset($tue)){echo $tue[3];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[3] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-3" value="<?php if(isset($wed)){echo $wed[3];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[3] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-3" value="<?php if(isset($thu)){echo $thu[3];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[3] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-3" value="<?php if(isset($fri)){echo $fri[3];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<th>9.50a.m -10.30 a.m</th>
							<td class="<?php if(isset($mon) && $mon[4] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-4" value="<?php if(isset($mon)){echo $mon[4];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[4] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-4" value="<?php if(isset($tue)){echo $tue[4];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[4] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-4" value="<?php if(isset($wed)){echo $wed[4];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[4] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-4" value="<?php if(isset($thu)){echo $thu[4];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[4] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-4" value="<?php if(isset($fri)){echo $fri[4];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<td colspan=6 class="text-center" style="background: gray;color: white" >Interval</td>
						</tr>
						<tr>
							<th>10.50a.m -11.30 a.m</th>
							<td class="<?php if(isset($mon) && $mon[5] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-5" value="<?php if(isset($mon)){echo $mon[5];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[5] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-5" value="<?php if(isset($tue)){echo $tue[5];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[5] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-5" value="<?php if(isset($wed)){echo $wed[5];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[5] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-5" value="<?php if(isset($thu)){echo $thu[5];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[5] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-5" value="<?php if(isset($fri)){echo $fri[5];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<th>11.30a.m -12.10 p.m</th>
							<td class="<?php if(isset($mon) && $mon[6] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-6" value="<?php if(isset($mon)){echo $mon[6];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[6] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-6" value="<?php if(isset($tue)){echo $tue[6];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[6] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-6" value="<?php if(isset($wed)){echo $wed[6];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[6] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-6" value="<?php if(isset($thu)){echo $thu[6];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[6] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-6" value="<?php if(isset($fri)){echo $fri[6];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<th>12.10p.m -12.50 a.m</th>
							<td class="<?php if(isset($mon) && $mon[7] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-7" value="<?php if(isset($mon)){echo $mon[7];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[7] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-7" value="<?php if(isset($tue)){echo $tue[7];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[7] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-7" value="<?php if(isset($wed)){echo $wed[7];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[7] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-7" value="<?php if(isset($thu)){echo $thu[7];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[7] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-7" value="<?php if(isset($fri)){echo $fri[7];}else{echo '0';} ?>"  ></td>
						</tr>
						<tr>
							<th>12.50p.m -1.30 a.m</th>
							<td class="<?php if(isset($mon) && $mon[8] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="mon-8" value="<?php if(isset($mon)){echo $mon[8];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($tue) && $tue[8] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="tue-8" value="<?php if(isset($tue)){echo $tue[8];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($wed) && $wed[8] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="wed-8" value="<?php if(isset($wed)){echo $wed[8];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($thu) && $thu[8] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="thu-8" value="<?php if(isset($thu)){echo $thu[8];}else{echo '0';} ?>"  ></td>
							<td class="<?php if(isset($fri) && $fri[8] == '1'){echo 'timetable-select';}else{echo 'timetable-unselect';} ?>"><input type="hidden" name="fri-8" value="<?php if(isset($fri)){echo $fri[8];}else{echo '0';} ?>"  ></td>
						</tr>

					</tbody>
				</table>

				<div class="d-flex justify-content-end w-100 mt-5 pt-5">
					<input type="submit" value="save" name="submit" class="btn btn-blue p-3">
				</div>
			</form>
		</div>
		
	</div>
</div>