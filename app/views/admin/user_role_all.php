
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($info) && !empty($info)){
			echo "<p class='w-75 text-center bg-green fg-white p-2'>";
			echo $info;
			echo "</p>";
		}
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 text-center bg-red fg-white p-2'>";
			echo $error;
			echo "</p>";
		}

	 ?>

	<div class="mt-5">
		<h2 class="fs-30">User Roles</h2>
	</div>
	<hr class="col-12 mt-5 mb-5">
	<div class="col-12">
		<div class="d-flex justify-content-center col-12">
			<form action="<?php echo set_url('userrole/permission'); ?>" method="POST" class="d-flex col-10 align-items-center">
				<div class="form-group" style="width: 200px;">
					<label for="user-role-id">User Role</label>
					<select name="user-role-id" id="user-role-id">
						<?php foreach ($user_roles as $role) {?>
							<option value="<?php echo $role['id']; ?>"
								 <?php if($user_role_id == $role['id']){echo "selected='selected'";}?> ><?php echo $role['name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="d-flex mt-3">
					<button type="submit" class="btn btn-blue mt-5" name="submit" >Submit</button>
				</div>
				<div class="d-flex col-5 mt-3 justify-content-end">
					<button type="submit" class="btn btn-red mt-5 float-right" name="delete" onclick="return confirm('Are you sure to delete?')" >Remove UserRole</button>
				</div>
			</form>
		</div>

		<form action="<?php echo set_url('userrole/permission/update'); ?>" method="POST" class="d-flex flex-col col-12 align-items-center">
			<input type="hidden" name="user-role-id" value="<?php echo $user_role_id ?>">
			<div class="d-flex flex-col col-12" style="overflow-x: scroll;overflow-y: hidden;">
				<table class='table-strip-dark  text-center'>
					<thead>
						<tr>
							<th>Permissions</th>
							<th>Create</th>
							<th>View</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
					<?php if(isset($permissions ) && !empty($permissions)){
						foreach ($permissions as $permission) {?>
							<tr>
							 	<th><?php echo $permission['model_name']; ?></th>
							 	<td><input type="checkbox" name="create-<?php echo $permission['model_id'];?>" value="1" <?php if($permission['create'] == 1){echo "checked='checked'";	} ?>></td>
							 	<td><input type="checkbox" name="view-<?php echo $permission['model_id'];?>" value="1" <?php if($permission['view'] == 1){echo "checked='checked'";	} ?>></td>
							 	<td><input type="checkbox" name="update-<?php echo $permission['model_id'];?>" value="1" <?php if($permission['update'] == 1){echo "checked='checked'";	} ?>></td>
							 	<td><input type="checkbox" name="delete-<?php echo $permission['model_id'];?>" value="1" <?php if($permission['delete'] == 1){echo "checked='checked'";	} ?>></td>
							</tr>
				 	<?php }
				 	} ?>
					</tbody>
				</table>
			</div>
			<div class="mt-3 d-flex w-90 justify-content-end">
				<input type="submit" value="Update" name="submit" class="btn btn-blue">
			</div>
		</form>
	</div>
	<div class="col-12 d-flex justify-content-center">
		<div class="col-6 d-flex justify-content-center">
			<h3>Add New User Role</h3>
			<form action="<?php echo set_url('userrole/create'); ?>" method="POST" class="d-flex col-12 justify-content-center align-items-center">
				<div class="form-group col-6">
					<label for="user-role-name">User Role Name</label>
					<input type="text" name="user-role-name" id="user-role-name" placeholder="User Role Name">
				</div>
				<div class="d-flex mt-3">
					<button type="submit" class="btn btn-blue mt-5" name="create" >Create</button>
				</div>
			</form>
		</div>
		<div class="col-6 d-flex justify-content-center">
			<h3>Add New Model</h3>
			<form action="<?php echo set_url('userrole/model/create'); ?>" method="POST" class="d-flex col-12 justify-content-center align-items-center">
				<div class="form-group col-6">
					<label for="model-name">Model Name</label>
					<input type="text" name="model-name" id="model-name" placeholder="Model Name">
				</div>
				<div class="d-flex mt-3">
					<button type="submit" class="btn btn-blue mt-5" name="create" >Create</button>
				</div>
			</form>
		</div>
	</div>
</div>