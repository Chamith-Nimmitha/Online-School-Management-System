
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="mt-5">
		<h2 class="fs-30">Parent List</h2>
	</div>
	<hr class="w-100">
	<div class="col-12 d-flex justify-content-center">
		<div class="d-flex justify-content-center mb-5 align-items-center">
			<form action="<?php echo set_url("parent/list"); ?>" method="post" class="d-flex align-items-center col-12">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="mt-5">
						<input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
					</div>
					<div class="ml-5">
						<label for="parent-id">Parent ID/Name</label>
						<input type="text" name="parent-id" id="parent-id" placeholder="ID, Name" value="<?php if(isset($_POST['parent-id'])){echo $_POST['parent-id'];} ?>">
					</div>
					<div class="ml-5">
						<label for="occupation">Occupation</label>
						<input type="text" name="occupation" id="occupation" placeholder="ID, Name" value="<?php if(isset($_POST['occupation'])){echo $_POST['occupation'];} ?>">
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" name="search" value="Show">
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
				<?php if($result_set && !empty($result_set)){
					foreach ($result_set as $result) { ?>
						<tr>
							<td><?php echo $result['id']; ?></td>
							<td><?php echo $result['name']; ?></td>
							<td><?php echo $result['type']; ?></td>
							<td><?php echo $result['occupation']; ?></td>
							<td><?php echo $result['email']; ?></td>
							<td><?php echo $result['contact_number']; ?></td>
							<td>
								<div>
									<a href="<?php echo set_url('profile/parent/'.$result['id']); ?>" class="btn btn-blue t-d-none">profile</a>
								</div>
							</td>
							<td>
								<div>
									<a href="" class="btn btn-lightred t-d-none" onclick="return confirm('Are you sure to delete?')">delete</a>
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
