<?php require_once("./session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 
	$result_set = $con->select("user_role");
	if($result_set){
		$result_set = $result_set->fetchAll();
	}

 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="mt-5">
		<h2 class="fs-30">User Roles</h2>
	</div>
	<hr class="col-12 mt-5 mb-5">
	<div class="col-12 d-flex flex-col align-items-center">
		<div style="background: lightblue;width: 300px;" class="d-flex flex-col mb-5">
			<p class="w-90" style="color: red;">Permission Points :</p>
			<div class="d-flex flex-wrap m-0 p-0mb-5">
				<div class="d-flex flex-col" style="width:100px;color: darkblue;">
					<p> 0 : Denied</p>
					<p> 1-3: Read</p>
				</div>
				<div class="d-flex flex-col" style="width:180px;color: darkblue;">
					<p> 4-6: Write</p>
					<p> 7-10: Read and Write</p>
				</div>
			</div>
		</div>
		<form action="user_role_all.php" method="POST" class="d-flex flex-col col-12">
			<div class="d-flex flex-col col-12" style="overflow-x: scroll;overflow-y: hidden;">
				<table class='table-strip-dark  text-center'>
					<thead>
						<tr>
							<th>Role</th>
							<th>Admission</th>
							<th>Attendance</th>
							<th>Student</th>
							<th>Teacher</th>
							<th>Parent</th>
							<th>Subject</th>
							<th>Classroom</th>
							<th>Timetable</th>
							<th>Exam</th>
							<th>Interview</th>
							<th>Interview Panel</th>
							<th>User Role</th>
							<th>All Setting</th>
						</tr>
					</thead>
					<tbody>
					<?php if(isset($result_set ) && !empty($result_set)){
						foreach ($result_set as $result) {?>
							<tr>
							 	<td><?php echo $result['role_name']; ?></td>
							 	<?php for ($i=1; $i < count($result) ; $i++) { ?>
							 		<td>
								 		<select name="<?php echo $result[$i]; ?>">
								 			<?php for ($j=0; $j < 11 ; $j++) { ?>
								 				<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
								 			<?php } ?>
								 		</select>
								 	</td>
							 	<?php } ?>
							</tr>
					<?php 
					 	}
					}
					?>
					</tbody>
				</table>
			</div>
			<div class="mt-3 d-flex w-90 justify-content-end">
				<input type="submit" value="Submit" name="submit" class="btn btn-blue">
			</div>
		</form>
	</div>
</div>
<?php require_once("../templates/footer.php"); ?>