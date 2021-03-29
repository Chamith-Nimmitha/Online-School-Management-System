<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
        if(isset($info) && !empty($info)){
            echo "<p class='w-75 bg-green p-2 text-center'>";
            echo $info;
            echo "</p>";
        }
        if(isset($error) && !empty($error)){
            echo "<p class='w-75 bg-red p-2 text-center'>";
            echo $error;
            echo "</p>";
        }
		if(isset($msg) && !empty($msg)){
			echo "<script>show_snackbar('${msg}')</script>";
		}
    ?>
    <div class="student-header mt-3  w-75 d-flex flex-col align-items-center">
		<h2 class="fs-30">Subject List</h2>
		<hr class="topic-hr w-100">
	</div>
   

	

	<div class="d-flex justify-content-center align-items-center">
		<form action="<?php echo set_url('subject/list'); ?>" method="post" class="d-flex align-items-center col-12" id="subject_search_form">
			<div class="d-flex col-12 align-items-center justify-content-center">
				<div class="mt-5">
					<input type="Reset" class="btn btn-blue" onclick="reset_form('subject_search_form','subject_search')" value="Reset">
				</div>
				<div class="ml-5">
					<label for="subject-id">Subject ID/Name/Code</label>
					<input type="text" name="subject-id" id="subject-id" placeholder="Subject ID/Name/Code" value="<?php if(isset($subject_id)){echo $subject_id;} ?>" oninput="subject_search()">
				</div>
				<div  class="  ml-5 align-items-center">
					<label for="grade" class="mr-3 d-normal">Grade : </label>
					<select name="grade" id="grade" style="width: 100px" onchange="subject_search()">
						<option value="all">All</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
					</select>
				</div>
				<div  class="  ml-5 align-items-center">
					<label for="medium" class="mr-3 d-normal">Medium:</label>
					<select name="medium" id="medium" onchange="subject_search()">
						<option value="all" >All</option>
						<option value="Sinhala">Sinhala</option>
						<option value="English">English</option>
						<option value="Tamil">Tamil</option>
					</select>				
				</div>
			</div>
		</form>
	</div>

	<div class="col-11 mt-5 flex-col" style="position:relative;overflow-x: scroll;overflow-y: hidden;">
		<div class="loader hide-loader">
		 	<div class="col-12">
				<div id="one"><div></div></div>
				<div id="two"><div></div></div>
				<div id="three"><div></div></div>
				<div id="four"><div></div></div>
				<div id="five"></div>
		 	</div>
		</div>
	    <table class="table-strip-dark text-center">
		    <thead>
			    <tr>
					<th>SUBJECT ID</th>
					<th>GRADE</th>
					<th>MEDIUM</th>
					<th>SUBJECT NAME</th>
				    <th>SUBJECT CODE</th>
				    <th>SUBJECT TYPE</th>
				    <?php if($_SESSION['role'] =='admin'){ 
					    echo "<th>UPDATE</th>";
					    echo "<th>DELETE</th>";
				    }?>
			    </tr>
		    </thead>
		    
            <tbody id="tbody">

			<?php 
			if(isset($result_set) && !empty($result_set)){
				$grade = 0;
				foreach ($result_set as $result) {
					if($result['grade'] != $grade){
						if($grade != 0 ){
							echo '<tr><td colspan="8" class="text-center bg-gray p-0"></td></tr>';
							echo '<tr><td colspan="8" class="text-center bg-gray"></td></tr>';
						}
						$grade = $result['grade'];
					}
            ?>
				<tr>
					<td><?php echo $result['id']; ?></td>
					<td><?php echo $result['grade']; ?></td>
					<td><?php echo $result['medium']; ?></td>
					<td><?php echo $result['name']; ?></td>
					<td><?php echo $result['code']; ?></td>
					<td><?php if($result['type']=='General'){echo "Mandatory";}else{echo $result['type'];} ?></td>
					
					
					<?php if($_SESSION['role'] =='admin'){ ?>
						<td>
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
								<a class="btn " href="<?php echo set_url('subject/update/').$result['id']; ?>">
									<i  title="edit" class="far fa-edit edit-button"></i>
									 </a>
		    				</div>
						</td>
						<td>
							<div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
								<a class="btn" href="<?php echo set_url('subject/delete/').$result['id']; ?>" onclick="show_dialog(this,'Delete message','Are you sure to delete?')"><i class='fas fa-trash delete-button'></i></a>
		    				</div>
						</td>
					<?php } ?>
				</tr>
			<?php
				}
			}else{
				echo "<tr><td colspan=8 class='text-center bg-red'>Subjects Not Found...</td></tr>";
			}
            ?>
             
            </tbody>
		</table>
	</div>
	<div id="pagination" class="col-12">
		<span>Number of results found : <span id="row_count"><?php echo $count; ?></span></span>
		<div id="pagination_data" class="col-12">
			<?php require_once(INCLUDES."pagination.php"); ?>
			<?php display_pagination($count,$page,$per_page, "subject/list","subject_search"); ?>
		</div>
	</div>
    <div class="login_buttons col-12 col-md-12 justify-content-end pr-5 d-flex align-items-center">
	   <a class="btn btn-blue" href="<?php echo set_url('subject/registration'); ?> ">Add Subject</a>
    </div>
</div>