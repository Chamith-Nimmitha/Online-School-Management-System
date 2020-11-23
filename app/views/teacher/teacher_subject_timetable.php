<?php include_once("session.php"); ?>
<?php require_once("../php/common.php"); ?>
<?php require_once("../php/database.php"); ?>

<?php 

	$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
	$day_map = ["1"=>"mon","2"=>"tue","3"=>"wed","4"=>"thu","5"=>"fri"];


	if(isset($_POST['submit'])){
		$con->get(array("subject_id"));
		$result = $con->select("teacher_subject",array("id"=>$_GET['id']));
		if($result && $result->rowCount()==1){
			$subject_id = $result->fetch()['subject_id'];
			$con->get(array("id"));
			$result = $con->select("normal_timetable", array("type"=>"subject", "user_id"=>$_GET['id']));
			if($result && $result->rowCount() == 1){
				try {
					$con->db->beginTransaction();
					$timetable_id = $result->fetch()['id'];
					foreach ($_POST as $key => $value) {
						$tmp = explode("-", $key);
						if(count($tmp) == 2){
							$where['timetable_id'] = $timetable_id;
							$where['day'] = $tmp[0];
							$where['period'] = $tmp[1];
							$result = $con->update("normal_day",array("task"=>$value), $where);
							if(!$result){
								throw new PDOException("Timetable data update fail.");
							}
						}
					}
					$info = "Update Successfull...";
					$con->db->commit();
				} catch (Exception $e) {
					$con->db->rollback();
					$error = $e->getMessage();
				}
				
			}else{
				try {
					$con->db->beginTransaction();
					$result = $con->insert("normal_timetable", array("type"=>"subject", "user_id"=>$_GET['id']));
					if($result && $result->rowCount() == 1){
						$con->get(array("id"));
						$result = $con->select("normal_timetable", array("type"=>"subject", "user_id"=>$_GET['id']));
						if($result && $result->rowCount() == 1){
							$timetable_id = $result->fetch()['id'];
							foreach ($_POST as $key => $value) {
								$tmp = explode("-", $key);
								if(count($tmp) == 2){
									$data['timetable_id'] = $timetable_id;
									$data['day'] = $tmp[0];
									$data['period'] = $tmp[1];
									$data['task'] = $value;
									$result = $con->insert("normal_day", $data);
									if(!$result || $result->rowCount()!=1){
										throw new PDOException("Timetable data insertion fail.");
									}
								}
							}
						}else{
							throw new PDOException("New timetable creation failed.",1);
						}
					}else{
						throw new PDOException("New timetable creation failed.",1);
					}
					$con->db->commit();
					$info = "Timetable creation successful.";
				} catch (Exception $e) {
					$error = $e->getMessage();
					$con->db->rollback();
				}
			}
		}
	}

	if(isset($_GET['id']) && !empty($_GET['id'])){
		$con->get(array("subject_id"));
		$result = $con->select("teacher_subject",array("id"=>$_GET['id']));
		if($result && $result->rowCount()==1){
			$subject_id = $result->fetch()['subject_id'];
			$query = "SELECT `se`.`id`,`se`.`grade` FROM `subject` AS `su` JOIN `section` AS `se` ON `su`.`grade`=`se`.`grade` WHERE `su`.`id` =". $subject_id;
			$result = $con->pure_query($query);
			if($result && $result->rowCount() == 1){
				$result = $result->fetch();
				$section_id = $result['id'] ;
				$grade = $result['grade'] ;

				$result_set = $con->select("classroom", array("section_id"=>$section_id));
				if($result_set && $result_set->rowCount() > 0){
					$classrooms = $result_set->fetchAll();
				}else{
					echo "No classrooms are there..";
				}
			}

			$con->get(array("id"));
			$result = $con->select("normal_timetable",array("type"=>"subject","user_id"=>$_GET['id']));
			if($result && $result->rowCount() == 1){
				$timetable_id = $result->fetch()['id'];
				$result_set = $con->select("normal_day", array("timetable_id"=>$timetable_id));
				if($result_set && $result_set->rowCount() > 0){
					$result_set = $result_set->fetchAll();
					$timetable_data = array();
					foreach ($result_set as $result) {
						$timetable_data[$result['day']][$result['period']] = $result['task'];
					}
				}
			}
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
		<h2>Subject Timetable</h2>
	</div>
	<div class="col-12 d-flex flex-col mt-5">
		<hr class="w-100">
		<div class="p-5">
			<form action="<?php echo set_url('pages/teacher_subject_timetable.php?id='.$_GET['id']); ?>" method="post">
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

					if(isset($classrooms) && !empty($classrooms)){
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
								$row .= '<select name="'.$day_map[$j].'-'.$period.'" id="">';
									$row .= '<option value="FREE">FREE</option>';
								foreach ($classrooms as $classroom) {
									$row .= '<option value="'.$classroom['id'].'"';
									if(isset($timetable_data) && $timetable_data[$day_map[$j]][$period] == $classroom['id']){
										$row .= " selected='selected'";
									}
									$row .= '>'.$grade."-".strtoupper($classroom['class']).'</option>';
								}
											
								$row .= "</select>";		
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
				<div class="mt-5 d-flex justify-content-end pr-5">
					<input type="submit" value="Submit" name="submit" class="btn btn-blue">
				</div>
			</form>
		</div>
		
	</div>
</div>


<?php require_once("../templates/footer.php"); ?>