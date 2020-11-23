<?php include_once("session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 

	$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
	$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];

	if(isset($_GET['student_id'])){
		$user_id = $_GET['student_id'];
	}else{
		$user_id = $_SESSION['user_id'];
	}

	$con->get(array("classroom_id","grade"));
	$student_info = $con->select("student",array("id"=>$user_id));
	if($student_info && $student_info->rowCount() ==1 ){
		$data = $student_info->fetch();
		$classroom_id = $data['classroom_id'];
		$student_grade = $data['grade'];
	}

	$con->get(array("id"));
	$timetable = $con->select("normal_timetable",array("user_id"=>$classroom_id, "type"=>"classroom"));

	if($timetable && $timetable->rowCount() == 1){
		$timetable_id = $timetable->fetch()['id'];
		$con->get(array("day","period","task"));
		$con->orderBy("period");
		$con->limit(40);
		$time = $con->select("normal_day",array("timetable_id"=>$timetable_id));

		if($time && $time->rowCount() >0){
			$timetable_day = $time->fetchAll();
		}else{
			echo "Error";
		}
		$timetable_data = array("mon"=>array(), "tue"=>array(), "wed"=>array(), "thu"=>array(), "fri"=>array());
		foreach ($timetable_day as $index => $data) {
			$timetable_data[$data['day']][$data['period']] = $data['task'];
		}
	}else{
		$error = "Not found student classroom.";
		$classroom_id="";
	}


 ?>

<?php require_once("../templates/header.php"); ?>
<?php require_once("../templates/aside.php"); ?>

<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">

	<?php 
		if(isset($error)){
			echo "<p class='bg-red p-3 w-75 text-center fg-white'>";
			echo $error;
			echo "</p>";
		}

	 ?>

	<div class="mt-5">
		<h2>Timetable Create</h2>
	</div>
	<div class="col-12 d-flex flex-col mt-5">
		<hr class="w-100">
		<div class="p-5">
			<form action="">
				<table class="w-100 table-strip-dark">
					<thead>
						<tr>
							<th style="width: 20%;">Time\Day</th>
							<th style="width: 15%;">Mon</th>
							<th style="width: 15%;">Tue</th>
							<th style="width: 15%;">Wed</th>
							<th style="width: 15%;">Thu</th>
							<th style="width: 15%;">Fri</th>
						</tr>
					</thead>
					<tbody>
						

				<?php 

					if(isset($timetable_data) && !empty($timetable_data)){
						for ($i=1; $i <= 9; $i++) { 

							if($i == 5){
								echo "<tr><th colspan='6' class='text-center bg-gray fg-white'>Interval</th></tr>";
								continue;
							}
							$period = $i > 5 ? $i-1 : $i;

							$row = "<tr>";
							$row .= "<th>".$time_map[$period]."</th>";
							for ($j=1; $j <=5 ; $j++) { 
								$row .= "<td class='text-center'>";
								if( $timetable_data[$day_map[$j]][$period] != "FREE"){
									$row .=  substr($timetable_data[$day_map[$j]][$period], strlen($student_grade));
								}else{
									$row .= $timetable_data[$day_map[$j]][$period];
								}
								$row .= "</td>";
							}
						$row .= "</tr>";
						echo $row;
						}
					}else{
						echo "<tr><td colspan=7 class='text-center bg-red'>Students not found...</td></tr>";
						echo "</tbody>";
						echo "</table>";
					}
				 ?>
					</tbody>
				</table>
			</form>
		</div>
		
	</div>
</div>


<?php require_once("../templates/footer.php"); ?>