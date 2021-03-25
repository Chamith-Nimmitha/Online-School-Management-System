<script>
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
</script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<!-- For unread, read, accepted applications -->
	<div id="useful-all-admission-table"  class=" col-11 admissions-table bg-white d-flex flex-col align-items-center section-wrapper">
		<div class="mt-5 w-75 d-flex flex-col align-items-center">
			<h2 class="fs-30">Student Admissions</h2>
			<hr class="topic-hr w-100">
		</div>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('admission/list'); ?>" id="admission_form1" method="post" class="d-flex align-items-center">
				<input type="reset" value="Reset" onclick="reset_form('admission_form1','admission_search')" class="btn btn1 mt-5 mr-2">
				<div class="w-50">
					<label for="admission-search">Search : </label>
					<input class="form-control" type="text" name="admission-search" id="admission-search" oninput="admission_search()" value="<?php if(isset($admission_search) && $admission_search !== NULL){echo $admission_search;} ?>" placeholder="Id, Grade, Name">
				</div>
				<div  class="d-flex flex-col  ml-5 align-items-center">
					<label for="admission-state" class="mr-3 d-normal">Type : </label>
					<select name="admission-state" onchange="admission_search()" id="admission-state" style="width: 110px">
						<option value="all">All</option>
						<option value="Unread">Unread</option>
						<option value="Read">Read</option>
						<option value="Accepted">Accepted</option>
					</select>
				</div>
			</form>
		</div>
		<div class="col-11 mt-5 flex-col" style=" position:relative;overflow-x: scroll;overflow-y: hidden;" id="admission_list_useful">
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
					$table = "<table class='table-strip-dark'>";
					$table .= "<thead>
									<tr>
										<th>Adm. ID</th>
										<th>Name</th>
										<th>Grade</th>
										<th>Address</th>
										<th>State</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody id='tbody'>";
					echo $table;
					if($result_set && !empty($result_set)){
						foreach ($result_set as $result) {
							$row ="<tr>";
							$row .= "<td>".$result['id']."</td>";
							$row .= "<td>".stripslashes($result['name_with_initials'])."</td>";
							$row .= "<td>".$result['grade']."</td>";
							$row .= "<td>".stripslashes($result['address'])."</td>";
							if($result['state'] == 'Accepted'){
								$row .= "<td class='text-center' style='background:#009922'>".$result['state']."</td>";
							}else if($result['state'] == 'Read'){
								$row .= "<td class='text-center' style='background:#ffffff'>".$result['state']."</td>";
							}else if($result['state'] == 'Unread'){
								$row .= "<td class='text-center' style='background:#00ffff'>".$result['state']."</td>";
							}else{
								$row .= "<td class='text-center' style='background:#333333;color:white;'>".$result['state']."</td>";
							}

							$row .= "<td class='text-center'><a class='btn p-1 pr-2 pl-2' href=". set_url('admission/view/').$result['id']."><i title='view' class='view-button far fa-eye'></i></a>";
							$row .= "</tr>";
							echo $row;
						}
							echo "</tbody>";
							echo "</table>";
					}else{
						echo "<tr><td colspan=7 class='text-center bg-red'>Admissions not found...</td></tr>";
							echo "</tbody>";
							echo "</table>";
					}
				 ?>
		</div>
		<div id="pagination" class="col-12">
			<span>Number of Results Found : <span id="row_count"><?php echo $recent_count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($recent_count,$page,$per_page, "admission/list","admission_search"); ?>
			</div>
		</div>
	</div>

	<!-- For rejected, NotInterviewed, Registered admissions  -->
	<div id="unuseful-all-admission-table"  class="col-11 d-flex align-items-center admissions-table section-wrapper">
		<div class="mt-5  w-75 d-flex flex-col align-items-center">
			<h2 class="fs-30">Already Viewed Admissions</h2>
			<hr class="topic-hr w-100">
		</div>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('admission/list'); ?>" id="admission_form2" method="post" class="d-flex align-items-center">
				<input type="reset" value="Reset" onclick="reset_form('admission_form2','admission_search_unuseful')" class="btn btn-blue mt-5 mr-2">
				<div class="w-50">
					<label for="u-admission-search">Search : </label>
					<input class="form-control" type="text" name="u-admission-search" id="u-admission-search" oninput="admission_search_unuseful()" value="" placeholder="Id, Grade, Name">
				</div>
				<div  class="d-flex flex-col  ml-5 align-items-center">
					<label for="u-admission-state" class="mr-3 d-normal">Type : </label>
					<select name="u-admission-state" onchange="admission_search_unuseful()" id="u-admission-state" style="width: 110px">
						<option value="all">All</option>
						<option value="Rejected">Rejected</option>
						<option value="Not Interviewed">Not Interviewed</option>
						<option value="Registered">Registered</option>
					</select>
				</div>
			</form>
		</div>
		<div class="col-11 mt-5 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;" id="admission_list_unuseful">
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
					$table = "<table class='table-strip-dark'>";
					$table .= "<thead>
									<tr>
										<th>Adm. ID</th>
										<th>Name</th>
										<th>Grade</th>
										<th>Address</th>
										<th>State</th>
										<th>View</th>
									</tr>
								</thead>
								<tbody id='u-tbody'>";
					echo $table;
					if($u_result_set && !empty($u_result_set)){
						foreach ($u_result_set as $result) {
							$row ="<tr>";
							$row .= "<td>".$result['id']."</td>";
							$row .= "<td>".stripslashes($result['name_with_initials'])."</td>";
							$row .= "<td>".$result['grade']."</td>";
							$row .= "<td>".stripslashes($result['address'])."</td>";
							if($result['state'] == 'Registered'){
								$row .= "<td class='text-center' style='background:#ff5555'>".$result['state']."</td>";
							}else if($result['state'] == 'Rejected'){
								$row .= "<td class='text-center' style='background:#ffffff'>".$result['state']."</td>";
							}else if($result['state'] == 'Not Interviewed'){
								$row .= "<td class='text-center' style='background:#00ffff'>".$result['state']."</td>";
							}else{
								$row .= "<td class='text-center' style='background:#333333;color:white;'>".$result['state']."</td>";
							}

							$row .= "<td class='text-center'><a class='btn p-1 pr-2 pl-2' href=". set_url('admission/view/').$result['id']."><i title='view' class='view-button far fa-eye'></i></a>";
							$row .= "</tr>";
							echo $row;
						}
							echo "</tbody>";
							echo "</table>";
					}else{
						echo "<tr><td colspan=7 class='text-center bg-red'>Admissions not found...</td></tr>";
							echo "</tbody>";
							echo "</table>";
					}
				 ?>
		</div>
		<div id="u_pagination" class="col-12">
			<span>Number of results found : <span id="u_row_count"><?php echo $viewed_count; ?></span></span>
			<div id="u_pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($viewed_count,$page,$per_page, "admission/list","admission_search_unuseful"); ?>
			</div>
		</div>
	</div>

</div>
