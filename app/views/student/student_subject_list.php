<?php require_once("./session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 
	$result_set = $con->select("tea_sub_student",array("student_id"=>$_SESSION['user_id']));
	if($result_set){
		$result_set = $result_set->fetchAll();
		$table_data = array();
		for($i=0; $i < count($result_set); $i++) {
			$tea_sub = $con->select("teacher_subject", array("id"=>$result_set[$i]['teacher_subject_id']));
			if($tea_sub && $tea_sub->rowCount() === 1){
				$con->get(array("name_with_initials"));
				$teacher = $con->select("teacher", array("id"=>$tea_sub['teacher_id']));
				if($teacher && $teacher->rowCount()===1){
					$subject = $con->select("suject", array("id"=>$tea_sub['subject_id']));
					if($subject && $subject->rowCount() === 1){
						$teacher = $teacher->fetch();
						$subject = $subject->fetch();
						$table_data[$i] = array("name"=>$subject['name'],"code"=>$subject['code'],"teacher_name"=>$teacher['name_with_initials']);
					}
				}
			}
		}
	}
	$table_data[0] = array("name"=>"Maths","code"=>"12MAT","teacher_name"=>"R.P.Kumara");
	$table_data[1] = array("name"=>"Chemistry","code"=>"12CHE","teacher_name"=>"C.W.Gamage");

 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>


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
	<div class="p-5">
		<h1>Student Subject List</h1>
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
					echo "<tr><td colspan=9 class='text-center bg-red'>Students not found...</td></tr>";
				}
				echo "</tbody>";
				echo "</table>";
			 ?>
		</div>
	</div>
</div>
<?php require_once("../templates/footer.php"); ?>