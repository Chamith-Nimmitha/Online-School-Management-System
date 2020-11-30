<?php 
	
	class Interview extends Controller{

		public function __construct() {
			parent::__construct();
		}

		// set or update interview
		public function set($admission_id){
			$con = new Database();
			$errors = [];
			//when submit
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
				$result = $con->select('interview',array("admission_id"=>$admission_id));
				if($result->rowCount() != 0){
					$result = $result->fetch();
					$_POST['interview-panel'] = $result["interview_panel_id"];
					$_POST['interview-date'] = ($result["date"])."#".strtolower(date("D",strtotime($result["date"])));
					$_POST['interview-time'] = $result["period"];
				}
			}

			if(isset($admission_id)){
				$con->update('admission',array("state"=>"accepted"),array("id"=>$admission_id));
				$con->where(array("id"=>$admission_id));
				$result = $con->select("admission")->fetch();
			}else{
				header("Location:". set_url("admission/list"));
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
			$data['timetables'] = $timetables;
			$data['result'] = $result;
			$data['valid_panels'] = $valid_panels;
			$this->view_header_and_aside();
			$this->load->view("admission/admission_set_interview",$data);
			$this->load->view("templates/footer");
		}
	}


 ?>