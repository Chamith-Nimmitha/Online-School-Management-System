<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg) && !empty($msg)){
			echo "<p class='d-flex justify-content-center bg-lightgreen fb-green col-8 p-3'>";
			echo $msg;
			echo "</p>";
		} 
		if(isset($del_msg) && !empty($del_msg)){
			echo "<script>show_snackbar('{$del_msg}')</script>";
		}
	?>

	<div class="col-12 d-flex">
	<?php 
		if(isset($error)){
			echo "<p class='bg-red p-3 w-75 text-center fg-white'>";
			echo $error;
			echo "</p>";
		}
	 ?>
	 <div class="row p-3">
	<div class="col-6 d-flex flex-col mt-5 justify-content-center align-items-center">
			<div class="bg-navyblue1 fs-20 fs-white border b-rad align-items-center justify-content-center">
				Today Timetable
			</div>
		<div class="p-5 w-100">
			<form action="">
				<table class="w-100 table-strip-dark">
					<thead>
						<tr>
							<th class="w-50">Time\Day</th>
						<?php 
								echo '<th style="height:50px">'.$cur_day.'</th>';
						?>
						</tr>
					</thead>
					<tbody>
						

				<?php 

					if(isset($timetable_data) && !empty($timetable_data)){
						for ($i=1; $i <= 9; $i++) { 

							if($i == 5){
								echo "<tr><th colspan='6' class='text-center bg-gray fg-white'>Interval</th></tr>";
								continue;
							}
							$period = $i > 5 ? $i-1 : $i;

							$row = "<tr>";
							$row .= "<th>".$time_map[$period]."</th>";
							for ($j=1; $j <=5 ; $j++) { 
								if($day_map[$j]==strtolower($cur_day)){
								$row .= "<td class='text-center' style='height:48px' >";
								$row .= $timetable_data[$day_map[$j]][$period];
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
	
			</form>
			<br>
		</div>
	</div>
		<div class="col-6 border b-rad justify-content-center align-items-center p-3">
 			 	<div class="row justify-content-center align-items-center mb-1">
					<div class="bg-navyblue1 fs-20 fs-white border b-rad">
						Classroom Notice Board
					</div>
				</div>
		<?php if(isset($show_notice_board) && ($show_notice_board ===1)){ ?>
		<div>
			<!-- ADD A NEW NOTICE -->
			<div id="add_new_classroom_notice" class="d-none">
				<div id="noticeboard_title" class="w-100">
					<!-- <button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('add_new_classroom_notice','classroom_notice_board')">Back</button> -->
					<button type="button" class="btn btn-blue p-1 ml-5" onclick="location.reload()">Back</button>
					<h3>ADD NEW NOTICE</h3>
				</div>
				<div class="form-wrapper">
					<form method="POST" onSubmit="add_new_notice(this)" data-classroom="">
						<p class="text-center" id="form_state"></p>
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" placeholder="title">
						</div>
						<div class="form-group">
							<label for="img">Image</label>
							<input type="file" name="img" id="img" placeholder="Image">
						</div>
						<div class="form-group">
							<label for="description">Discription</label>
							<textarea name="description" id="description" class="w-100 p-2"  rows="2"></textarea>
						</div>
						<div class="form-group">
							<label for="expire_date">Expire Date</label>
							<input type="date" name="expire_date" id="expire_date" value="<?php echo date("Y-m-d"); ?>">
						</div>
						<div class="w-100 d-flex justify-content-end">
							<input type="submit" value="Save" class="btn btn-blue">
						</div>
					</form>
				</div>
			</div>
			<!-- ADD A NEW NOTICE -->

			<!-- UPDATE NOTICE -->
			<div id="update_classroom_notice" class="d-none">
				<div id="noticeboard_title" class="w-100">
					<!-- <button type="button" class="btn btn-blue p-1 ml-5" onclick="show_available_notice('update_classroom_notice','classroom_notice_board')">Back</button> -->
					<button type="button" class="btn btn-blue p-1 ml-5" onclick="location.reload()">Back</button>
					<h3>UPDATE NOTICE</h3>
					<a href="" class="btn btn-blue p-0 pr-2 pl-2 mr-2 mr-2" onclick="delete_notice(this,'Delete Message','Are you sure?')">Del</a>
				</div>
				<div class="form-wrapper">
					<form action="" method="POST" data-classroom="" data-notice="" onSubmit="update_notice(this)">
						<p class="text-center" id="form_state"></p>
						<div class="form-group p-0 pr-2 pl-2">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" placeholder="title">
						</div>
						<div class="form-group  p-0 pr-2 pl-2">
							<label for="img">Image</label>
							<input type="file" name="img" id="img" placeholder="Image">
						</div>
						<div class="form-group  p-0 pr-2 pl-2">
							<label for="description">Discription</label>
							<textarea name="description" id="description" class="w-100 p-2"  rows="2"></textarea>
						</div>
						<div class="form-group  p-0 pr-2 pl-2">
							<label for="expire_date">Image</label>
							<input type="date" name="expire_date" id="expire_date" value="">
						</div>
						<div class="w-100 d-flex justify-content-end">
							<input type="submit" value="Save" class="btn btn-blue">
						</div>
					</form>
				</div>
			</div>
			<!--END OF UPDATE NOTICE -->

			<!-- NOTICE BOARD -->
			<div class="col-12" id="classroom_notice_board">
				<!-- NOTICE 1 -->
				<input type="hidden" name="notice_classroom_id" id="notice_classroom_id" value="<?php if(isset($notice_classroom_id)){echo $notice_classroom_id;} ?>">
				<?php 
					if(isset($classroom_notices) && !empty($classroom_notices)){
						$j =0;
						foreach ($classroom_notices as $notice) {
							for($i=0; $i<count($notice['notices']);$i++,$j++) {
								if($j === 0){
									echo '<div data-index="'.($j).'" data-notice="'.$notice['notices'][$i]["id"].'" class="notice d-block col-12">';
								}else{
									echo '<div data-index="'.($j).'" data-notice="'.$notice['notices'][$i]["id"].'" class="notice col-12 d-none">';
								}
								$flag=1;
								?>
									<div id="noticeboard_title" class="w-100">
											<h3><?php if(isset($notice['grade']) && !empty($notice['grade'])){ echo "{$notice['grade']}-{$notice['class']}";} ?> Notice Board</h3>
										<?php if($is_classroom_teacher===1){ ?>
											<button type="button" class="btn btn-blue p-1 mr-2" onclick="add_new_form('classroom_notice_board','add_new_classroom_notice')">Add</button>
											<button type="button" class="btn btn-blue p-1 mr-2" onclick="update_form('classroom_notice_board','update_classroom_notice')">View</button>
										<?php } ?>
									</div>
									<p class="w-100 text-center mt-2" style="font-size: 17px; font-weight: 900;"><?php echo $notice['notices'][$i]['title']; ?></p>
									<div class="noticeboard_content_wrapper">
										<div id="noticeboard_content" class="col-12">
											<?php if(!empty($notice['notices'][$i]['image'])){ ?>
											<img src="<?php echo set_url("public/assets/img/classroom_notice/".$notice['notices'][$i]['image']); ?>" onClick="open_image_viewer(this);" alt="">
											<?php } ?>
											<div class="content">
												<?php echo $notice['notices'][$i]['description']; ?>
											</div>
										</div>
									</div>
								</div>
					<?php 	}
						}
					}else{?>
						<div data-index="0" class="notice d-block col-12 d-block">
							<div id="noticeboard_title" class="w-100">
							<?php 	if($_SESSION['role'] !== 'parent'){ ?>
								<h3><?php if(isset($grade) && !empty($grade)){ echo "{$grade}-{$class}";} ?> Notice Board</h3>
							<?php 	}else{ ?>
								<p class="w-100 text-center mt-2" style="font-size: 17px; font-weight: 900;">You haven't a Classroom</p>
							<?php 	} ?>
								<?php if($is_classroom_teacher===1){ ?>
									<button type="button" class="btn btn-blue p-1 mr-2" onclick="add_new_form('classroom_notice_board','add_new_classroom_notice')">Add</button>
								<?php } ?>
							</div>
							
							<div class="noticeboard_content_wrapper">
								<div id="noticeboard_content" class="col-12">
									<div class="content">
										<p>No any updates...</p>
									</div>
								</div>
							</div>
						</div>
				<?php } ?>	
				<div id="noticeboard_controls" class="col-12 d-flex justify-content-center align-items-center">
					<div id="pre_btn">
						<button>Pre</button>
					</div>
					<div id="indicators" class="controls d-flex">
						<?php 
						if(isset($classroom_notices) && !empty($classroom_notices)){
							$j = 0;
							foreach ($classroom_notices as $notice) {
								for($i=0; $i< count($notice['notices']); $i++,$j++) {
									if($j==0){
										echo '<button data-index="'.($j).'"  class="notice_active"></button>';
									}else{
										echo '<button data-index="'.($j).'"></button>';
									}
								}
						}
					}
						?>
					</div>
					<div id="next_btn">
						<button>Next</button>
					</div>
				</div>
			</div>
			</div>	
		</div>
			<!-- END OF NOTICE BOARD -->
 <div class="col-12 justify-content-center align-items-center border b-rad p-3 mt-3">
    <div class="mt-5  w-75 d-flex flex-col align-items-center">
        <h2 class="pt-3 pb-3">Student Attendance View</h2>
        <hr class="topic-hr w-100">
    </div>
	<div class="col-12 flex-col justify-content-center align-items-center">
    		<!-- <h2 class="text-center p-5">Attendance Report</h2> -->
        <!-- <div id="attendance-statistics" class="col-12  justify-content-center ">
    		<div class="statistics-flex justify-content-center">	
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1 text-center">Total Days</h3>
    				<span class="pt-1">100</span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1 text-center">Absent Days</h3>
    				<span class="pt-1">10</span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1  text-center">Present Days</h3>
    				<span class="pt-1">90</span>
    			</div> 
    			<div  class="d-flex flex-col s-item align-items-center bg-lightblue m-2 p-3">
    				<h3 class="bb pb-1  text-center">Presentage</h3>
    				<span class="pt-1">90%</span>
    			</div>
    			
    			
    		</div>
    	</div> -->
        <div class="col-12 justify-content-center align-items-center">
            <div class="d-flex justify-content-center align-items-center">
                <form id="student_attendance_filter" method="post" class="d-flex align-items-center col-12">
                    <input type="hidden" name="student_id" value="<?php if(isset($student_id)){echo $student_id;} ?>">
                    <div class="d-flex col-12 align-items-center justify-content-center">
                        <div class="mt-5">
                            <input type="reset" class="btn btn-blue" onclick="reset_form('student_attendance_filter')" value="reset">
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="year">Year</label>
                            <select name="year">
                                <option value="this">This Year</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                            </select>
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="month">Month</label>
                            <select name="month">
                                <option value="this">This Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">Semtember</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="ml-5 d-flex flex-col">
                            <label for="week">Week</label>
                            <select name="week">
                                <option value="this">This Week</option>
                                <option value="1">Week-01</option>
                                <option value="2">Week-02</option>
                                <option value="3">Week-03</option>
                                <option value="4">Week-04</option>
                                <option value="5">Week-05</option>
                                <option value="6">Week-06</option>
                            </select>
                        </div>
                        <button type="button" onclick="student_attendance_filter()" class="btn btn-blue ml-3 mt-5">Filter</button>

                        <!-- <a href="<?php echo set_url('student/attendance/report') ?>" class="btn btn-green-outline ml-2 mt-5 p-1" value="Show">View This year attendance</a> -->
                    </div>
                </form>
            </div>
            <div class="col-8 flex-col" style="position: relative; overflow-x: scroll;overflow-y: hidden;" id="attendance_table">
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
    			    <caption class="p-5"><b>Recent 10 Attendance</b></caption>
    			    <thead>
    				    <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>ATTENDANCE</th>
                            <th>NOTE</th>
    				    </tr>
    			    </thead>  
                    <tbody id="tbody">
                        <?php 
                            if(isset($result_set) && !empty($result_set)){
                                for ($i=0; $i < count($result_set); $i++) { 
                         ?>
                            <tr>
                                <td><?php echo $i+1; ?></td>
                                <td><?php echo $result_set[$i]['date']; ?></td>
                                <td><?php if($result_set[$i]['attendance'] == 1){echo 'Present';}else{echo "Absent";} ?></td>
                                <td><?php echo $result_set[$i]['note']; ?></td>
                            </tr>    
                        <?php 
                                }
                            }
                         ?>
                    </tbody>
                </table>
                <div class="w-100 p-1"></div>
    		</div>
        </div>

        <!-- student attendance overview-->
        <div class="col-10 mt-5 justify-content-center align-items-center">
            <div class="mt-5  w-75 d-flex flex-col align-items-center justify-content-center">
                <h3>Student Attendance Overview</h3>
                <hr class="topic-hr w-100">
            </div>
            <form id="student_attendance_overview" class="col-12">
                <input type="hidden" name="student_id_bar" value="<?php if(isset($student_id)){echo $student_id;} ?>">
                <div class="col-12 justify-content-center align-items-center mt-5">
                    <input type="reset" class="btn btn-blue mr-2 mt-5 p-2" onclick="reset_form('student_attendance_overview')" value="reset">
                    <div class="d-flex flex-col align-items-center pr-5" style="width: 150px;">
                        <label class="pr-2" for="year_bar">Year: </label>
                        <select name="year_bar" id="year_bar">
                            <option value="this">This Year</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                        </select>
                    </div>
                    <div class="d-flex flex-col align-items-center" style="width: 150px;">
                        <label class="pr-2" for="month_bar">Month: </label>
                        <select name="month_bar" id="month_bar">
                            <option value="0">None</option>
                            <option value="this">This Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">Semtember</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <button type="button" onclick="student_attendance_overview_bar()" class="btn btn-blue ml-2 mt-5 p-2">Filter</button>
                </div>
            </form>            
        </div>
        <div class="mt-5 col-12 d-flex justify-content-center align-items-center">
            <div class="bg-white p-5 justify-content-center align-items-center"  id="attendance_bar" style="position: relative;">
                <div class="loader hide-loader">
                    <div class="col-12">
                        <div id="one"><div></div></div>
                        <div id="two"><div></div></div>
                        <div id="three"><div></div></div>
                        <div id="four"><div></div></div>
                        <div id="five"></div>
                    </div>
                </div>
                <canvas id="student_attendance_overview_bar" width="800" height="500"></canvas>
            </div>
        </div>

        <div class="form-group d-flex flex-row w-90 justify-content-end">
	        <button type="button" name="submit" onclick="window.print()" class="btn btn-blue w-auto m-1">Download as pdf</button>
        </div>

    </div>
   </div>

		</div>
		<?php 	} ?>
	</div>


</div> <!-- #content