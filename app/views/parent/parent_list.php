
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($delete_msg) && $delete_msg != NULL){
			echo "<script trpe='text/javasript'>
				show_snackbar('{$delete_msg}');
			</script>";
		}
	 ?>
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
						<input type="text" name="parent-id" id="parent-id" placeholder="ID, Name" value="<?php if(isset($_POST['parent-id'])){echo $_POST['parent-id'];} ?>" oninput="parent_search()">
					</div>
					<div class="ml-5">
						<label for="occupation">Occupation</label>
						<input type="text" name="occupation" id="occupation" placeholder="ID, Name" value="<?php if(isset($_POST['occupation'])){echo $_POST['occupation'];} ?>">
					</div>
					<button onclick="parent_search()" class="btn btn-blue ml-3 mt-5">Filter</button>
				</div>
			</form>
		</div>
		<div class="col-12 mt-5 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
			<div class="loader hide-loader">
			 	<div class="col-12">
					<div id="one"><div></div></div>
					<div id="two"><div></div></div>
					<div id="three"><div></div></div>
					<div id="four"><div></div></div>
					<div id="five"></div>
			 	</div>
			</div>
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
						<?php if($_SESSION['role'] =='admin'){ 
							echo "<th>Delete</th>";
						}?>
					</tr>
				</thead>
				<tbody id="tbody">
				<?php if($result_set && !empty($result_set)){
					foreach ($result_set as $result) { ?>
						<tr>
							<td><?php echo $result['id']; ?></td>
							<td><?php echo $result['name']; ?></td>
							<td><?php echo $result['type']; ?></td>
							<td><?php echo $result['occupation']; ?></td>
							<td><?php echo $result['email']; ?></td>
							<td class='text-center'><?php echo $result['contact_number']; ?></td>
							<td>
								<div>
									<a href="<?php echo set_url('profile/parent/'.$result['id']); ?>" class="btn btn-blue t-d-none">profile</a>
								</div>
							</td>
							<?php if($_SESSION['role'] =='admin'){ ?>
								<td class='text-center'>
									<a title='Delete' href="<?php echo set_url('parent/delete/'.$result['id']); ?>" class="btn t-d-none" onclick="show_dialog(this,'Delete message','Are you sure to delete?')"><i class='fas fa-trash delete-button'></i></a>
								</td>
							<?php 	} ?>
						</tr>		

				<?php }
				}else{
					echo "<tr><td colspan=8 class='text-center bg-red'>Parent not found...</td></tr>";
				} ?>
				</tbody>
			</table>
		</div>
		<div id="pagination" class="col-12">
			<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "parent/list","parent_search"); ?>
			</div>
		</div>

	</div>
</div>
