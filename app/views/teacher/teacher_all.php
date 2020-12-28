<script>
	if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	}
</script>
<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('teacher/list'); ?>" method="post" class="d-flex align-items-center col-12" enctype="multipart/form-data">
				<div class="d-flex col-12 align-items-center justify-content-center">
					<div class="ml-5">
						<label for="teacher-id">Teacher ID/Name</label>
						<input type="text" name="teacher-id" id="teacher-id" placeholder="ID, Name" oninput="teacher_search()"  value="<?php if(isset($teacher_id) && $teacher_id !== NULL){echo $teacher_id;} ?>" >
					</div>
					<input type="submit" class="btn btn-blue ml-3 mt-5" value="Show">
				</div>
			</form>
		</div>

		<div class="col-12 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
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
						<th>NAME</th>
						<th>EMAIL</th>
						<th>CONTACT NUMBER</th>
					    <th>NIC</th>
					    <th>Subjects</th>
					   <?php
					   	if($_SESSION['role']==='admin'){
					   		echo '
						    <th>UPDATE</th>
						    <th>DELETE</th>';
						  }

					    ?>

				    </tr>
			    </thead>
			    
                <tbody id="tbody">

				<?php 
		if($result_set){
			//$row = "";
			foreach ($result_set as $result) {
				$row ="<tr>";
				$row .= "<td>".$result['id']."</td>";
				$row .= "<td>".stripslashes($result['name_with_initials'])."</td>";
				$row .= "<td>".$result['email']."</td>";
				$row .= "<td>".$result['contact_number']."</td>";
				$row .= "<td>".$result['nic']."</td>";

				$row .= "<td><a href=". set_url('teacher/list/').$result['id'].">List</a>";
				$row .= "<td><a href=". set_url('teacher/update/').$result['id'].">Update</a>";
				$row .= "<td><a href=". set_url('teacher/delete/').$result['id']." onclick=\"return confirm('Are you sure to delete?')\">Delete</a>";
				$row .= "</tr>";
				echo $row;
			}
				echo "</tbody>";
				echo "</table>";
			
		}else{
			$row =  "<tr><td colspan=8 class='text-center bg-red'>Teacher not found...</td></tr>";
				echo "</tbody>";
				echo "</table>";
		}
                ?>

				
		</div>  
        <br>
		<div>
            <a class="btn btn-blue" onClick="window.print()">Download as a PDF</a>
		</div>

		<div id="pagination" class="col-12">
			<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
			<div id="pagination_data" class="col-12">
				<?php require_once(INCLUDES."pagination.php"); ?>
				<?php display_pagination($count,$page,$per_page, "teacher/list","teacher_search"); ?>
			</div>
		</div>

</div>

