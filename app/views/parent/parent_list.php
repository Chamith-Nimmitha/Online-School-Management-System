<?php require_once( realpath(dirname(__FILE__)). "/../php/common.php" ); ?>
<?php require_once( realpath(dirname(__FILE__)). "/../php/database.php" ); ?>
<?php 

	$restul_set = $con->select("parent");
	if($restul_set){
		$restul_set = $restul_set->fetchAll();
	}


 ?>

<?php require_once( realpath(dirname(__FILE__)). "/../templates/header.php" ); ?>
<?php require_once( realpath(dirname(__FILE__)). "/../templates/aside.php" ); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="mt-5">
		<h2 class="fs-30">Parent List</h2>
	</div>
	<hr class="w-100">
	<div class="col-12 d-flex justify-content-center">
		<div class="d-flex justify-content-center mb-5 align-items-center">
			<form action="<?php echo set_url('pages/teacher-all.php'); ?>" method="get" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="parent-id">Parent ID/Name</label>
						<input type="text" name="parent-id" id="parent-id" placeholder="ID, Name" value="<?php if(isset($_GET['parent-id'])){echo $_GET['parent-id'];} ?>">
					</div>
					<div class="ml-5">
						<label for="occupation">Occupation</label>
						<input type="text" name="occupation" id="occupation" placeholder="ID, Name" value="<?php if(isset($_GET['occupation'])){echo $_GET['occupation'];} ?>">
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>
		<div class="d-flex justify-content-center col-12" style="overflow-x: scroll;overflow-y: hidden;">
			<table class="table-strip-dark">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Type</th>
						<th>Occupation</th>
						<th>Email</th>
						<th>Contact Number</th>
						<th>Profile</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
				<?php if($restul_set && !empty($restul_set)){
					foreach ($restul_set as $restul) { ?>
						<tr>
							<td><?php echo $restul['id']; ?></td>
							<td><?php echo $restul['name']; ?></td>
							<td><?php echo $restul['type']; ?></td>
							<td><?php echo $restul['occupation']; ?></td>
							<td><?php echo $restul['email']; ?></td>
							<td><?php echo $restul['contact_number']; ?></td>
							<td>
								<div>
									<a href="<?php echo set_url('pages/parent_profile.php',array('parent_id'=>$restul['id'])); ?>" class="btn btn-blue t-d-none">profile</a>
								</div>
							</td>
							<td>
								<div>
									<a href="" class="btn btn-lightred t-d-none">delete</a>
								</div>
							</td>
						</tr>		

				<?php }
				}else{
					echo "<tr><td colspan=8 class='text-center bg-red'>Parent not found...</td></tr>";
				} ?>
				</tbody>
			</table>
		</div>

	</div>
</div>
<?php require_once( realpath(dirname(__FILE__)). "/../templates/footer.php" ); ?>
