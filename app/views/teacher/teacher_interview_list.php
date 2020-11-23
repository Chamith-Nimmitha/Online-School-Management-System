<?php include_once("session.php"); ?>
<?php require_once("../php/database.php"); ?>
<?php require_once("../php/pagination.php"); ?>

<?php 

	$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];


	$start = 0;
	$per_page = 1;
	if(isset($_GET['per_page'])){
		$per_page=$_GET['per_page'];
	}
	if(isset($_GET['page'])){
		$start = (($_GET['page'] -1) * $per_page );
	}else{
		$_GET['page'] =1;
	}
	if(isset($_GET['interview_panel_id']) && !empty($_GET['interview_panel_id'])){
		$limit = "$start, $per_page";
		$query = "SELECT * FROM `interview` WHERE `interview_panel_id`={$_GET['interview_panel_id']} ORDER BY `date` ASC LIMIT ".$limit;
		$result_set = $con->pure_query($query);
		$query = "SELECT COUNT(*) AS count FROM `interview`";
		$count = $con->pure_query($query);
		if($count){
			$count = $count->fetch()['count'];
		}
	}
 ?>



<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

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
					if($result_set){
						echo $table;
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
								$row .= "<td style='background:#333333'>".$result['state']."</td>";
							}

							$row .= "<td><a href=\"interview_admission_view.php?admission-id=".$result['admission_id']."&back=". "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']."\">view</a></td>";
							echo $row;
						}
						echo "</tbody>";
						echo "</table>";
					}else{
						echo "<tr><td colspan=9 class='text-center bg-red'>Students not found...</td></tr>";
					}
				 ?>
		</div>
		<p class="mt-3 pl-5"><code><?php 	echo $count; ?> results found.</code> </p>	
		<div id="pagination-div">
			<?php display_pagination($count,$_GET['page'],$per_page); ?>
		</div>
	</div>
</div>


<?php require_once("../templates/footer.php"); ?>