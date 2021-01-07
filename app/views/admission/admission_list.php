<script>
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
</script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($msg) && $msg != NULL){
			echo "<script trpe='text/javasript'>
				show_snackbar('{$msg}');
			</script>";
		}
	 ?>
	<div class="mt-5">
		<h2 class="fs-30">Admissions Managment</h2>
	</div>

	<!-- For unread, read, accepted applications -->
	<div id="useful-all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('admission/list'); ?>" method="post" class="d-flex align-items-center">
				<input type="reset" value="Reset" class="btn btn-blue mt-5 mr-2">
				<div class="w-50">
					<label for="admission-search">Search : </label>
					<input class="form-control" type="text" name="admission-search" id="admission-search" oninput="admission_search()" value="<?php if(isset($admission_search) && $admission_search !== NULL){echo $admission_search;} ?>" placeholder="Id, Grade, Name">
				</div>
				<div  class="d-flex flex-col  ml-5 align-items-center">
					<label for="admission-state" class="mr-3 d-normal">Type : </label>
					<select name="admission-state" id="admission-state" style="width: 110px">
						<option value="all">All</option>
						<option value="Unread">Unread</option>
						<option value="Read">Read</option>
						<option value="Accepted">Accepted</option>
					</select>
				</div>
				<button onclick="admission_search()" style="width:100px;" class="btn btn-blue ml-3 mt-5 d-felx"><i class="fas fa-search pr-2"></i>Filter</button>
			</form>
		</div>
		<div class="col-12 mt-5 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;" id="admission_list_useful">
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
										<th>grade</th>
										<th>Address</th>
										<th>state</th>
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

							$row .= "<td class='text-center'><a class='btn btn-blue p-1 pr-2 pl-2' href=". set_url('admission/view/').$result['id'].">View</a>";
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
			<span>Number of Results Found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "admission/list","admission_search"); ?>
			</div>
		</div>
	</div>

	<!-- For rejected, NotInterviewed, Registered admissions  -->
	<div class="mt-5">
		<h2 class="fs-30">Already Viewed Admissions</h2>
	</div>
	<div id="unuseful-all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('admission/list'); ?>" method="post" class="d-flex align-items-center">
				<input type="reset" value="Reset" class="btn btn-blue mt-5 mr-2">
				<div class="w-50">
					<label for="u-admission-search">Search : </label>
					<input class="form-control" type="text" name="u-admission-search" id="u-admission-search" oninput="admission_search_unuseful()" value="" placeholder="Id, Grade, Name">
				</div>
				<div  class="d-flex flex-col  ml-5 align-items-center">
					<label for="u-admission-state" class="mr-3 d-normal">Type : </label>
					<select name="u-admission-state" id="u-admission-state" style="width: 110px">
						<option value="all">All</option>
						<option value="Rejected">Rejected</option>
						<option value="Not Interviewed">Not Interviewed</option>
						<option value="Registered">Registered</option>
					</select>
				</div>
				<button onclick="admission_search_unuseful()" style="width:100px;" class="btn btn-blue ml-3 mt-5 d-felx"><i class="fas fa-search pr-2"></i>Filter</button>
			</form>
		</div>
		<div class="col-12 mt-5 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;" id="admission_list_unuseful">
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
										<th>grade</th>
										<th>Address</th>
										<th>state</th>
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

							$row .= "<td class='text-center'><a class='btn btn-blue p-1 pr-2 pl-2' href=". set_url('admission/view/').$result['id'].">View</a>";
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
			<span>Number of results found : <span id="u_row_count"><?php echo $count; ?></span></span>
			<div id="u_pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "admission/list","admission_search_unuseful"); ?>
			</div>
		</div>
	</div>

</div>
