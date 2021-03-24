<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($error)){
			echo "<p class='bg-red fg-white w-75 text-center p-2'>";
			echo $error."<br/>";
			echo "</p>";
		}
		if(isset($info)){
			echo "<p class='bg-green fg-white w-75 text-center p-2'>";
			echo $info."<br/>";
			echo "</p>";
		}

	 ?>
	<div class="p-5 mt-3 w-75 d-flex flex-col align-items-center">
		<?php 
		if($_SESSION['role'] == "student"){ 
			echo "<h2>My Subject List</h2>";
		}
		else{
			echo "<h2>Student Subject List</h2>";
		}
		?>
		<hr class="topic-hr w-100">
	</div>
	<hr class="w-100">
	<div class="p-5 col-12 col-md-8 text-center">
		<div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
			<?php 
				$table = "<table class='table-strip-dark'>";
				$table .= "<thead>
								<tr>
									<th>Subject Name</th>
									<th>Code</th>
									<th>Teacher Name</th>
								</tr>
							</thead>
							<tbody>";
				echo $table;
				if(isset($table_data) && !empty($table_data)){
					for($i=0; $i < count($table_data);$i++) {
						$row ="<tr>";
						$row .= "<td>".$table_data[$i]['name']."</td>";
						$row .= "<td>".$table_data[$i]['code']."</td>";
						$row .= "<td>".$table_data[$i]['teacher_name']."</td>";
						echo $row;
					}
					$_SESSION['back'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				}else{
					echo "<tr><td colspan=9 class='text-center bg-red'>Subjects Not Found...</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			 ?>
		</div>
	</div>
</div>