<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<div class="admissions-header mt-5">
		<h2 class="fs-30">Interview Managment</h2>
	</div> <!-- .admission-header -->
	<div id="all-admission-table"  class="admissions-table">
		<hr>
		<div class="d-flex justify-content-center align-items-center">
			<form action="<?php echo set_url('pages/interview_panels_all.php'); ?>" method="get" class="d-flex align-items-center">

				<div class="d-flex align-items-center">
					<label for="" class="mr-3 d-normal">Grade : </label>
					<select name="interview-panel-grade" id="interview-panel-grade" style="width: 100px">
						<option value="all" <?php if(isset($_GET['interview-panel-grade'])){if($_GET['interview-panel-grade'] == "all"){echo 'selected="selected"';}}else{echo 'selected="selected"';} ?>>All</option>
						<option value="1" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "1")){echo 'selected="selected"';} ?> >1</option>
						<option value="2" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "2")){echo 'selected="selected"';} ?> >2</option>
						<option value="3" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "3")){echo 'selected="selected"';} ?> >3</option>
						<option value="4" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "4")){echo 'selected="selected"';} ?> >4</option>
						<option value="5" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "5")){echo 'selected="selected"';} ?> >5</option>
						<option value="6" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "6")){echo 'selected="selected"';} ?> >6</option>
						<option value="7" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "7")){echo 'selected="selected"';} ?> >7</option>
						<option value="8" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "8")){echo 'selected="selected"';} ?> >8</option>
						<option value="9" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "9")){echo 'selected="selected"';} ?> >9</option>
						<option value="10" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "10")){echo 'selected="selected"';} ?> >10</option>
						<option value="11" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "11")){echo 'selected="selected"';} ?> >11</option>
						<option value="12" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "12")){echo 'selected="selected"';} ?> >12</option>
						<option value="13" <?php if(isset($_GET['interview-panel-grade']) && ($_GET['interview-panel-grade'] == "13")){echo 'selected="selected"';} ?> >13</option>
					</select>
				</div>
				<input type="submit" class="btn btn-blue ml-3" value="Show">
			</form>
		</div>
		<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
			
			<?php 
				$table = "<table class=\"table-strip-dark\">";
				$table .= "<caption class=\"p-5\">";
				if(isset($_GET['interview-panel-grade'])){
					 $table .= "Grade ".ucfirst($_GET['interview-panel-grade']);
				} 
				$table .= "interview panels</caption>";

				$table .= "<thead>
							<tr>
								<th>Panel ID</th>
								<th>Panel Name</th>
								<th>Grade</th>
								<th>View</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>";

				echo $table;
				if($result_set){
					foreach ($result_set as $result) {
						$row ="<tr>";
						$row .= "<td class='text-center'>".$result['id']."</td>";
						$row .= "<td class='text-center'>".$result['name']."</td>";
						$row .= "<td class='text-center'>".$result['grade']."</td>";

						$row .= "<td class='text-center'><a class='btn btn-blue t-d-none p-1' href=\"interview_panel_view.php?interview-panel-id=".$result['id']."&back=". "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']."\">view</a></td>";

						$row .= "<td class='text-center'><a class='btn btn-lightred t-d-none p-1' href=". set_url('interviewpanel/delete/').$result['id'].">delete</a>";
						$row .= "</tr>";
						echo $row;
					}
				}else{
					echo "<tr><td colspan=5 class='text-center bg-red'>Students not found...</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			?>
		</div>
	</div>
</div>