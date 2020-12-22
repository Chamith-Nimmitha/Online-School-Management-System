<script>
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
</script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="mt-5">
		<h2 class="fs-30">Admissions Managment</h2>
	</div>
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('admission/list'); ?>" method="post" class="d-flex align-items-center">
				<div class="w-50">
					<label for="admission-search">Search : </label>
					<input class="form-control" type="text" name="admission-search" id="admission-search" oninput="admission_search()" value="<?php if(isset($admission_search) && $admission_search !== NULL){echo $admission_search;} ?>" placeholder="Id, Grade, Name">
				</div>
				<div  class="d-flex flex-col  ml-5 align-items-center">
					<label for="admission-type" class="mr-3 d-normal">Type : </label>
					<select name="admission-state" id="admission-state" style="width: 110px" onchange="set_aside_link_selector(this,'aside-link-selector')">
						<option value="all" <?php if(isset($admission_state) && $admission_state ){if($admission_state  && $admission_state == NULL){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
						<option value="unread" <?php if(isset($admission_state) && $admission_state  && ($admission_state  && $admission_state == "unread")){echo 'selected="selected"';} ?> >Unread</option>
						<option value="read" <?php if(isset($admission_state) && $admission_state  && ($admission_state  && $admission_state == "read")){echo 'selected="selected"';} ?> >Read</option>
						<option value="accepted" <?php if(isset($admission_state) && $admission_state  && ($admission_state  && $admission_state == "accepted")){echo 'selected="selected"';} ?> >Accepted</option>
						<option value="rejected" <?php if(isset($admission_state) && $admission_state  && ($admission_state  && $admission_state == "rejected")){echo 'selected="selected"';} ?> >Rejected</option>
						<option value="registered" <?php if(isset($admission_state) && $admission_state  && ($admission_state  && $admission_state == "registered")){echo 'selected="selected"';} ?> >Registered</option>
						<option value="deleted" <?php if(isset($admission_state) && $admission_state  && ($admission_state  && $admission_state == "deleted")){echo 'selected="selected"';} ?> >Deleted</option>
					</select>
				</div>
				<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
			</form>
		</div>
		<div class="col-12 mt-5 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
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
										<th>Delete</th>
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
							if($result['state'] == 'accepted'){
								$row .= "<td style='background:#009922'>".$result['state']."</td>";
							}else if($result['state'] == 'deleted'){
								$row .= "<td style='background:#ff5555'>".$result['state']."</td>";
							}else if($result['state'] == 'read'){
								$row .= "<td style='background:#ffffff'>".$result['state']."</td>";
							}else if($result['state'] == 'unread'){
								$row .= "<td style='background:#00ffff'>".$result['state']."</td>";
							}else{
								$row .= "<td style='background:#333333;color:white;'>".$result['state']."</td>";
							}

							$row .= "<td><a href=". set_url('admission/view/').$result['id'].">view</a>";
							$row .= "<td><a href=". set_url('admission/delete/').$result['id']." onclick=\"return confirm('Are you sure to delete?')\">delete</a>";
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
			<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "admission/list","admission_search"); ?>
			</div>
		</div>
	</div>
</div>
