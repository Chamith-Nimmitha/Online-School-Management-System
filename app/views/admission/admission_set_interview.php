<?php include_once("session.php"); ?>
<?php require_once('../php/common.php'); ?>
<?php require_once('../php/database.php'); ?>


<?php 	
	$errors = [];
	if(isset($_POST['submit'])){
		try{
			$con->db->beginTransaction();
			if($_POST['interview-panel'] === "0"){
				throw new PDOException("Please select a interview panel.", 1);
				
			}
			if($_POST['interview-date'] === "0"){
				throw new PDOException("Please select a interview date.", 1);
			}
			if($_POST['interview-time'] === "0"){
				throw new PDOException("Please select a interview time.", 1);
			}

			$data['admission_id'] = $_POST['admission-id'];
			$data['interview_panel_id'] = $_POST['interview-panel'];
			$data['date'] = explode("#",$_POST['interview-date'])[0];
			$data['period'] = $_POST['interview-time'];
			$result = $con->select("interview",array("admission_id"=>$_POST["admission-id"]));
			if($result->rowCount() === 0){
				$result = $con->insert('interview',$data);
				if(!$result || $result->rowCount() !== 1){
					throw new PDOException("Interview creation failed.", 1);
				}
			}else{
				$result = $con->update("interview",$data,array("admission_id"=>$_POST['admission-id']));
				if(!$result || $result->rowCount() !== 1){
					throw new PDOException("Interview Update failed.", 1);
				}
			}
			$info = "Set Interview successful..";
			$con->db->commit();
		}catch( PDOException $e){
			$con->db->rollBack();
			$error = $e->getMessage();
		}
	}else{
		$result = $con->select('interview',array("admission_id"=>$_GET['admission-id']));
		if($result->rowCount() != 0){
			$result = $result->fetch();
			$_POST['interview-panel'] = $result["interview_panel_id"];
			$_POST['interview-date'] = ($result["date"])."#".strtolower(date("D",strtotime($result["date"])));
			$_POST['interview-time'] = $result["period"];
		}

	}

	if(isset($_GET['admission-id'])){
		$con->update('admission',array("state"=>"accepted"),array("id"=>$_GET['admission-id']));
		$con->where(array("id"=>$_GET['admission-id']));
		$result = $con->select("admission")->fetch();
	}else{
		if(isset($_GET['back'])){
			header("Location:". $_GET['back'] );
		}else{
			header("Location:". set_url('pages/admissions-all.php'));
		}
	}

	$interview_panels = $con->select('interview_panel',array('grade'=>$result['grade']));
	$valid_panels = [];
	$timetables = [];

	$day_map = ["mon"=>"monday", "tue"=>"tuesday", "wed"=>"wednesday", "thu"=>"thursday", "fri"=>"friday"];

	$time_map = ["1"=>"7.50a.m - 8.30a.m", "2"=>"8.30a.m - 9.10a.m", "3"=>"9.10a.m - 9.50a.m", "4"=> "9.50a.m - 10.30a.m", "5"=> "10.50a.m - 11.30a.m", "6"=>"11.30a.m - 12.10p.m", "7"=> "12.10p.m - 12.50p.m", "8"=>"12.50p.m - 1.30p.m"];
	
	foreach ($interview_panels as $row) {
		$timetable_id = $con->select('normal_timetable',array('user_id'=>$row['id'],"type"=>"interview"))->fetch()['id'];
		$days = $con->select("normal_day",array("timetable_id"=>$timetable_id));

		foreach ($days as $day){
			if($day['task'] == "1"){
				if(isset($timetables[$row['id']])){
					if(isset($timetables[$row['id']][$day['day']])){
						array_push($timetables[$row['id']][$day['day']], $day['period']);
					}else{
						$timetables[$row['id']][$day['day']] = [$day['period']];
					}
				}else{
					$d = [];
					$d[$day['day']] = [$day['period']];
					$timetables[$row['id']] = $d;
					array_push($valid_panels, [$row['id'],$row['name']]);
				}
			}
		}
	}
 ?>

<?php require_once('../templates/header.php')?>
<?php require_once('../templates/aside.php') ?>


<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
	<?php 
		if(isset($error) && !empty($error)){
			echo "<p class='w-75 bg-red fg-white p-2 text-center'>";
			echo $error ."<br/>";
			echo "</p>";
		}

		if(isset($info) && !empty($info)){
			echo "<p class='w-75 bg-green fg-white p-2 text-center'>";
			echo $info ."<br/>";
			echo "</p>";
		}
	 ?>
	<form action="<?php echo set_url('/pages/admission_set_interview.php?admission-id='.$_GET['admission-id'].'&back='.$_GET['back']) ?>" method="post" class="col-12 col-md-8">
		<fieldset>
			<legend>Interview Info</legend>

			<div class="form-group">
				<label for="admission-id">Admission ID</label>
				<input type="text" name="admission-id" id="admission-id" placeholder="Admission ID" value="<?php if(isset($result['id'])){echo $result['id'];} ?>">
			</div>
			<div class="form-group">
				<label for="name-with-initials">Name with initials</label>
				<input type="text" name="name-with-initials" id="name-with-initials" placeholder="Name with Initials" value="<?php if(isset($result['name_with_initials'])){echo $result['name_with_initials'];} ?>">
			</div>
			<div class="form-group">
				<label for="grade">Grade</label>
				<input type="text" name="grade" id="grade" placeholder="Grade" value="<?php if(isset($result['grade'])){echo $result['grade'];} ?>">
			</div>
			<div class="form-group">
				<label for="interview-panel">Interview Panel</label>
				<select name="interview-panel" id="interview-panel" onchange="set_interview_date()">
					<option value="0">select panel</option>
					<?php foreach ($valid_panels as $row) {
						$option = "<option value='".$row[0]."' ";
						if(isset($_POST['interview-panel']) && $_POST['interview-panel'] == $row[0]){
							$option .= "selected='selected'";
						}
						$option .= ">";
						$option .= $row[1]."</option>";
						echo $option;
					} ?>
				</select>
			</div>
			<div class="form-group">
				<label for="interview-date">Interview Date</label>
				<select name="interview-date" id="interview-date" onchange="set_interview_time()">
					<option value="0">select</option>
					<?php foreach ($timetables as $interview_id => $days) {
						foreach ($days as $day => $periods) {
							$option = "<option op='{$interview_id}' class='";
							if(isset($_POST["interview-panel"]) && $_POST["interview-panel"] == $interview_id){
								$option .= "show";
							}else{
								$option .= "hide";
							}
							$option .= " ' value='";
							$option .= date("Y-m-d",strtotime('next '.$day_map[$day]))."#{$day}";
							$option .= "' ";
							if(isset($_POST['interview-date']) && $_POST['interview-date'] === date("Y-m-d",strtotime('next '.$day_map[$day]))."#{$day}"){
								// echo date("Y-m-d",strtotime('next '.$day_map[$day]))."#{$day}";
								$option .= "selected='selected'";
							}
							$option .= ">";
							$option .= date("Y-m-d",strtotime('next '.$day_map[$day]))." ".$day_map[$day];
							$option .= "</option>";
							echo $option;
						}
					} ?>
					<?php foreach ($timetables as $interview_id => $days) {
						foreach ($days as $day => $periods) {
							$option = "<option op='{$interview_id}' class='hide' value='";
							$option .= date("Y-m-d",strtotime('second '.$day_map[$day]))."#{$day}";
							$option .= "'";
							echo $_POST['interview-date'] ." ". date("Y-m-d",strtotime('second '.$day_map[$day]))."#{$day}";
							if(isset($_POST['interview-date']) && $_POST['interview-date'] == date("Y-m-d",strtotime('second '.$day_map[$day]))."#{$day}"){
								$option .= "selected='selected'";
							}
							$option .= ">";
							$option .= date("Y-m-d",strtotime('second '.$day_map[$day]))." ".$day_map[$day];
							$option .= "</option>";
							echo $option;
						}
					} ?>
				</select>
			</div>
			<div class="form-group">
				<label for="interview-time">Interview time</label>
				<select name="interview-time" id="interview-time">
					<option value="0">select</option>
					<?php 
					foreach ($timetables as $interview_id => $days) {
						foreach ($days as $day => $periods) {
							foreach ($periods as $period) {
								$option = "<option op='{$interview_id}-{$day}' class='hide' value='".$period."' ";
								if(isset($_POST['interview-time']) && $_POST['interview-time'] == $period){
									$option .= "selected='selected'";
								}
								$option .= ">";
								$option .= $time_map[$period]."</option>";
								echo $option;
							}
						}
					} 
					?>
				</select>
			</div>
			<div class="form-group d-flex justify-content-end">
				<a href="<?php echo $_GET['back']; ?>" class="btn btn-blue">back</a>
				<button type="submit" name="submit" id="submit" class="btn btn-blue p-2 ml-2">Arrange Interview</button>
			</div>
		</fieldset>
	</form>
	
</div>
<?php require_once("../templates/footer.php") ?>