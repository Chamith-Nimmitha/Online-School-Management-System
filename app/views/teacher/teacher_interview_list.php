
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="interview-header mt-5  w-75 d-flex flex-col align-items-center">
		<h2 class="fs-30">Interview List</h2>
		<hr class="topic-hr w-100">
	</div> <!-- .interview-header -->
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('interview/list'); ?>" method="post" class="d-flex align-items-center col-12" id="interview_search_form">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form('interview_search_form','interview_search')" value="Reset">
					</div>
					<div class="ml-5">
						<label for="admission-id">Admission ID</label>
						<input type="text" name="admission-id" id="admission-id" placeholder="admission ID" oninput="interview_search()" value="<?php if(isset($_POST['admission-id'])){echo $_POST['admission-id'];} ?>">
					</div>
					<input type="hidden" value="<?php echo $panel_id; ?>" id="panel-id">
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">State:</label>
						<select name="state" id="state" onchange="interview_search()">
							<option value="all" <?php if(isset($_POST['state']) && ($_POST['state'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="Interviewed" <?php if(isset($_POST['state']) && ($_POST['state'] == "Interviewed")){echo 'selected="selected"';} ?> >Interviewed</option>
							<option value="notInterviewed" <?php if(isset($_POST['state']) && ($_POST['state'] == "notInterviewed")){echo 'selected="selected"';} ?> >Not Interviewed</option>
						</select>				
					</div>
				</div>
			</form>
		</div>
		<div class="d-flex justify-content-center align-items-center">
			<!-- <form action="<?php echo set_url('teacher/interviews'); ?>" method="post" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="admission-id">Admission ID</label>
						<input type="text" name="admission-id" id="admission-id" placeholder="admission ID" value="<?php if(isset($_POST['admission-id'])){echo $_POST['admission-id'];} ?>">
					</div>
					<div class="ml-5">
						<label for="panel-id">Panel ID</label>
						<input type="text" name="panel-id" id="panel-id" placeholder="panel ID" value="<?php if(isset($_POST['panel-id'])){echo $_POST['panel-id'];} ?>">
					</div>
					<div  class="  ml-5 align-items-center">
						<label for="class" class="mr-3 d-normal">State:</label>
						<select name="state" id="state">
							<option value="all" <?php if(isset($_POST['state']) && ($_POST['state'] == "all")){echo 'selected="selected"';} ?> >All</option>
							<option value="Interviewed" <?php if(isset($_POST['state']) && ($_POST['state'] == "Interviewed")){echo 'selected="selected"';} ?> >Interviewed</option>
							<option value="Not Interviewed" <?php if(isset($_POST['state']) && ($_POST['state'] == "Not Interviewed")){echo 'selected="selected"';} ?> >Not Interviewed</option>
						</select>				
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" name="search" value="Show">
				</div>
			</form> -->
		</div>
		<div class="col-12 flex-col" style="position: relative; overflow-x: scroll;overflow-y: hidden;">
			<div class="loader hide-loader">
			 	<div class="col-12">
					<div id="one"><div></div></div>
					<div id="two"><div></div></div>
					<div id="three"><div></div></div>
					<div id="four"><div></div></div>
					<div id="five"></div>
			 	</div>
			</div>
			<?php 
				$table = "<table class='table-strip-dark text-center'>";
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
							<tbody id='tbody'>";
				echo $table;
				if($interviews && !empty($interviews)){
					foreach ($interviews as $result) {
						$row ="<tr>";
						$row .= "<td>".$result['id']."</td>";
						$row .= "<td>".$result['admission_id']."</td>";
						$row .= "<td>".$result['date']."</td>";
						$row .= "<td>".$time_map[$result['period']]."</td>";
						$row .= "<td>".$result['interview_panel_id']."</td>";
						if($result['state'] == 'notInterviewed'){
							$row .= "<td style='background:#009922'>To be Interview</td>";
						}else{
							$row .= "<td style='background:#333333;color:white;' class='text-center'>".$result['state']."</td>";
						}

						$row .= "<td><a href='".set_url('interview/view/'.$result['admission_id'])."' class='btn p-1'><i title='view' class='view-button far fa-eye'></i></a></td>";
						echo $row;
					}
				}else{
					echo "<tr><td colspan=9 class='text-center bg-red'>Interview Not Found...</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			?>
		</div>
		<div id="pagination" class="col-12">
			<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "interview/list","interview_search"); ?>
			</div>
		</div>
	</div>
</div>
