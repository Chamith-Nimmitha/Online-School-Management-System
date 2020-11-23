<?php include_once("session.php"); ?>
<?php require_once("../php/database.php"); ?>
<?php require_once("../php/pagination.php"); ?>
<?php 
	if(isset($_GET['delete'])){
		$con->update("admission",array("state"=>"deleted"),array("id"=>$_GET["delete"]));
		header("Location:". explode("&delete=","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0]);	
	}

	$con->get(array("id","name_with_initials","grade","address","state"));

	// $start = 0;
	// $per_page = 1;
	// if(isset($_GET['page'])){
	// 	$start = (($_GET['page'] -1) * $per_page );
	// }else{
	// 	$_GET['page'] =1;
	// }
	// $limit = "$start, $per_page";

	if(isset($_GET['aside-link-selector'])){
		if($_GET['aside-link-selector'] == "all"){
			// $con->limit($limit);
			$result_set = $con->select('admission');
			$query = "SELECT COUNT(*) AS count FROM `admission`";
			$count = $con->pure_query($query);
		}else{
			// $con->limit($limit);
			$con->where(array("state"=>$_GET['aside-link-selector']));
			$result_set = $con->select('admission');
			$query = "SELECT COUNT(*) AS count FROM `admission` WHERE `state`='".$_GET['aside-link-selector']."'";
			$count = $con->pure_query($query);
		}
	}else{
		// $con->limit($limit);
		$result_set = $con->select('admission');
		$query = "SELECT COUNT(*) AS count FROM `admission`";
			$count = $con->pure_query($query);
	}
	if($result_set)
		$result_set = $result_set->fetchAll();

 ?>
<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="mt-5">
		<h2 class="fs-30">Admissions Managment</h2>
	</div>
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<div class="w-25">
				<label for="admission-search">Search : </label>
				<input class="form-control" type="text" name="sadmission-search" oninput="admission_search(this)" placeholder="Id, Grade, Name">
			</div>
			<form action="<?php echo set_url('pages/admissions_all.php'); ?>" method="get" class="d-flex align-items-center">
				<input type="hidden" name="aside-link-selector" id="aside-link-selector" value="<?php if(isset($_GET['aside-link-selector'])){echo $_GET['aside-link-selector'];}else{echo 'all';} ?>">
				<div  class="d-flex flex-col  ml-5 align-items-center">
					<label for="admission-type" class="mr-3 d-normal">Type : </label>
					<select name="admission-type" id="admission-type" style="width: 110px" onchange="set_aside_link_selector(this,'aside-link-selector')">
						<option value="all" <?php if(isset($_GET['aside-link-selector'])){if($_GET['aside-link-selector'] == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
						<option value="unread" <?php if(isset($_GET['aside-link-selector']) && ($_GET['aside-link-selector'] == "unread")){echo 'selected="selected"';} ?> >Unread</option>
						<option value="read" <?php if(isset($_GET['aside-link-selector']) && ($_GET['aside-link-selector'] == "read")){echo 'selected="selected"';} ?> >Read</option>
						<option value="accepted" <?php if(isset($_GET['aside-link-selector']) && ($_GET['aside-link-selector'] == "accepted")){echo 'selected="selected"';} ?> >Accepted</option>
						<option value="rejected" <?php if(isset($_GET['aside-link-selector']) && ($_GET['aside-link-selector'] == "rejected")){echo 'selected="selected"';} ?> >Rejected</option>
						<option value="registered" <?php if(isset($_GET['aside-link-selector']) && ($_GET['aside-link-selector'] == "registered")){echo 'selected="selected"';} ?> >Registered</option>
						<option value="deleted" <?php if(isset($_GET['aside-link-selector']) && ($_GET['aside-link-selector'] == "deleted")){echo 'selected="selected"';} ?> >Deleted</option>
					</select>
				</div>
				<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
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

							$row .= "<td><a href='".set_url("pages/admission_view.php",array("admission-id"=>$result['id'],"back"=>"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']))."'>view</a></td>";
							$row .= "<td><a href=". set_url('pages/admissions_all.php').'?admission-search=';
							if(isset($_GET['admission-search'])){
								$row .= $_GET['admission-search'];
							}else{
								$row .= "all";
							}
							$row .='&delete='.$result['id'].">delete</a></td>";
							$row .= "</tr>";
							echo $row;
						}
							echo "</tbody>";
							echo "</table>";
					}else{
						echo "<tr><td colspan=7 class='text-center bg-red'>Students not found...</td></tr>";
							echo "</tbody>";
							echo "</table>";
					}
				 ?>
		</div>
	</div>
</div>

<?php require_once("../templates/footer.php"); ?>