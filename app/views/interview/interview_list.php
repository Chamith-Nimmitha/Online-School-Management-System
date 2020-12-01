
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="interview-header mt-5">
		<h2 class="fs-30">Interview List</h2>
	</div> <!-- .interview-header -->
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('pages/student_list.php'); ?>" method="get" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="admission-id">Admission ID</label>
						<input type="text" name="admission-id" id="admission-id" placeholder="admission ID" value="<?php if(isset($_GET['admission-id'])){echo $_GET['admission-id'];} ?>">
					</div>
					<div class="ml-5">
						<label for="panel-id">Panel ID</label>
						<input type="text" name="panel-id" id="panel-id" placeholder="panel ID" value="<?php if(isset($_GET['panel-id'])){echo $_GET['panel-id'];} ?>">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">State:</label>
						<select name="state" id="state">
							<option value="all" <?php if(isset($_GET['state']) && ($_GET['state'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="interviewed" <?php if(isset($_GET['state']) && ($_GET['state'] == "interviewed")){echo 'selected="selected"';} ?> >Interviewed</option>
							<option value="notInterviewed" <?php if(isset($_GET['state']) && ($_GET['state'] == "notInterviewed")){echo 'selected="selected"';} ?> >NotInterviewed</option>
						</select>				
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>
		<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
				<?php 
					$table = "<table class='table-strip-dark'>
								<caption class=\"p-5\">";
					 if(isset($_GET['admission-search'])){ 
					 	$table .= ucfirst($_GET['admission-search']);
					 }
					$table .= "Admissions</caption>";
					$table .= "<thead>
									<tr>
										<th>Interview ID</th>
										<th>Adm. ID</th>
										<th>date</th>
										<th>time</th>
										<th>Panel ID</th>
										<th>state</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody>";
					echo $table;
					if(isset($result_set) && !empty($result_set)){
						foreach ($result_set as $result) {
							$row ="<tr>";
							$row .= "<td>".$result['id']."</td>";
							$row .= "<td>".$result['admission_id']."</td>";
							$row .= "<td>".$result['date']."</td>";
							$row .= "<td>".$time_map[$result['period']]."</td>";
							$row .= "<td>".$result['interview_panel_id']."</td>";
							if($result['state'] == 'notInterviewed'){
								$row .= "<td style='background:#009922'>".$result['state']."</td>";
							}else{
								$row .= "<td style='background:#333333;color:white;' class='text-center'>".$result['state']."</td>";
							}

							$row .= "<td><a class='t-d-none btn btn-blue p-1' href='".set_url('interview/view/').$result['admission_id']."'>view</a></td>";
							echo $row;
						}
						echo "</tbody>";
						echo "</table>";
					}else{
						echo "<tr><td colspan=9 class='text-center bg-red'>Interviews not found...</td></tr>";
						echo "</tbody>";
						echo "</table>";
					}
				 ?>
		</div>
	</div>
</div>
