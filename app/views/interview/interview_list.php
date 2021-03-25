
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="interview-header mt-5  w-75 d-flex flex-col align-items-center">
		<h2 class="fs-30">Interview List</h2>
		<hr class="topic-hr w-100">
	</div> <!-- .interview-header -->
	<div id="all-admission-table"  class="admissions-table">
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('interview/list'); ?>" method="post" class="d-flex align-items-center col-12" id="interview_search_form">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form('interview_search_form','interview_search')" value="Reset">
					</div>
					<div class="ml-5">
						<label for="admission-id">Admission ID</label>
						<input type="text" name="admission-id" id="admission-id" placeholder="admission ID" value="<?php if(isset($_POST['admission-id'])){echo $_POST['admission-id'];} ?>" oninput="interview_search()">
					</div>
					<div class="ml-5">
						<label for="panel-id">Panel ID</label>
						<input type="text" name="panel-id" id="panel-id" placeholder="panel ID" value="<?php if(isset($_POST['panel-id'])){echo $_POST['panel-id'];} ?>" oninput="interview_search()">
					</div>
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
		<div class="col-12 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
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
					$table = "<table class='table-strip-dark'>
								<caption class=\"p-5\">";
					 if(isset($_POST['admission-search'])){ 
					 	$table .= ucfirst($_POST['admission-search']);
					 }
					$table .= "Admissions</caption>";
					$table .= "<thead>
									<tr>
										<th>Interview ID</th>
										<th>Adm. ID</th>
										<th>Date</th>
										<th>Time</th>
										<th>Panel ID</th>
										<th>State</th>
										<th>View</th>";
									if($_SESSION['role'] == "admin"){
										$table .= "<th>Delete</th>";
									}

						$table .= "</tr>
								</thead>
								<tbody id='tbody'>";
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
								$row .= "<td style='background:#009922'>To be Interview</td>";
							}else{
								$row .= "<td style='background:#333333;color:white;' class='text-center'>".$result['state']."</td>";
							}

							$row .= "<td class='text-center'><a class='t-d-none btn p-1' href='".set_url('interview/view/').$result['admission_id']."'><i title='view' class='view-button far fa-eye'></i></a></td>";
							if($_SESSION['role'] == "admin"){
								$row .= "<td><a class='d-flex justify-content-center t-d-none btn p-1' href='".set_url('interview/delete/').$result['admission_id']."' onclick=\"show_dialog(this,'Delete message','Are you sure to delete?')\"><i class='fas fa-trash delete-button'></i></a></td>";
							}
							echo $row;
						}
						echo "</tbody>";
						echo "</table>";
					}else{
						echo "<tr><td colspan=9 class='text-center bg-red'>Interviews Not Found...</td></tr>";
						echo "</tbody>";
						echo "</table>";
					}
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
