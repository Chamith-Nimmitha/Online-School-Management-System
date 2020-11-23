<?php include_once("session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 
	$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
	$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];

	if(isset($_POST['submit'])){

		try {
			$con->db->beginTransaction();
			$data['type'] = "student";
			$data['user_id'] = $_SESSION['user_id'];
			//check if already exist timetable
			$con->get(array("id"));
			$result = $con->select("normal_timetable",$data);

			if($result){
				$timetable_id = $result->fetch()['id'];
				foreach ($_POST as $key => $value) {
					$tmp = explode("-", $key);
					if(count($tmp) == 2){
						$data = [];
						$data['day'] =  $tmp[0];
						$data['period'] =  $tmp[1];
						$data['task'] = $value;
						$result = $con->update("normal_day",$data,array("timetable_id"=>$timetable_id,"day"=>$tmp[0],"period"=>$tmp[1]));
						if(!$result){
							throw new PDOException("Timetable Update failed.",1);
						}
					}
				}
				$info = "Timetabel Update Successful.";
			}else{
				$result = $con->insert("normal_timetable",$data);
				if(!$result){
					throw new PDOException("Timetable create failed.",1);
				}
				$con->get(array("id"));
				$result = $con->select("normal_timetable",$data);

				if(!$result && $result->rowCount() != 1){
					throw new PDOException("Timetable create failed.",1);
				}
				$timetable_id = $result->fetch()['id'];
				foreach ($_POST as $key => $value) {
					$tmp = explode("-", $key);
					if(count($tmp) == 2){
						$data = [];
						$data['day'] =  $tmp[0];
						$data['period'] =  $tmp[1];
						$data['task'] = $value;
						$data['timetable_id'] = $timetable_id;
						$result = $con->insert("normal_day",$data);
						if(!$result){
							throw new PDOException("Timetable create failed.",1);
						}
					}
				}
				$info = "Timetable Create Successful.";
			}
			$con->db->commit();
		} catch (Exception $e) {
			$error = $e->getMessage();
			$con->db->rollback();
		}
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
		if(isset($info)){
			echo "<p class='bg-green p-3 w-75 text-center fg-white'>";
			echo $info;
			echo "</p>";
		}

	 ?>

	<div class="mt-5">
		<h2>Timetable Create</h2>
	</div>
	<div class="col-12 d-flex flex-col mt-5">
		<hr class="w-100">
		<div class="p-5">
			<form action="timetable_create.php" method="post">
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
					for ($i=1; $i <= 9; $i++) { 

						if($i == 5){
							echo "<tr><th colspan='6' class='text-center bg-gray fg-white'>Interval</th></tr>";
							continue;
						}
						$period = $i > 5 ? $i-1 : $i;

						$row = "<tr>";
						$row .= "<th>".$time_map[$period]."</th>";
						for ($j=1; $j <=5 ; $j++) { 
							$row .= "<td>";
							$row .= '<select name="'.$day_map[$j].'-'.$period.'" id="">
										<option value="SCI">Science</option>
										<option value="ENG">English</option>
										<option value="MAT">Maths</option>
										<option value="ICT">ICT</option>
										<option value="SIN">Sinhala</option>
									</select>';		
							$row .= "</td>";
						}
						$row .= "</tr>";
						echo $row;
					}
				 ?>
					</tbody>
				</table>
				<div class="d-flex justify-content-end p-5">
					<button type="submit" name="submit" class="btn btn-blue p-3">Submit</button>
				</div>
			</form>
		</div>
		
	</div>
</div>


<?php require_once("../templates/footer.php"); ?>