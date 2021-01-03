<?php 
	
	class ApiDrawChart extends Controller{
		public function __construct() {
			parent::__construct();
		}

		// for overview particular student attendance
		public function student_attendance_overview_bar(){

			if(!isset($_POST)){
				echo 'FALSE';
				return;
			}

			$student_id = $_POST['student_id_bar'];
			$year = $_POST['year_bar'];
			$month = $_POST['month_bar'];

			if(empty($student_id)){
				echo 'FALSE';
				return;
			}

			if($year === "this"){
				$year = date('Y');
			}
			if($month === "this"){
				$month = date('m');
			}else if($month == 0){
				$month = NULL;
			}

			$this->load->model('attendance');
			$present_result_set = $this->load->attendance->student_attendance_overview_bar($student_id,$year,$month,1);
			$absent_result_set = $this->load->attendance->student_attendance_overview_bar($student_id,$year,$month,0);
			$formatted_data = ["present"=>[],"absent"=>[]];
			$labels = [];
			if($present_result_set && $absent_result_set){
				$present_result_set = $present_result_set->fetchAll();
				$absent_result_set = $absent_result_set->fetchAll();
				if($month == NULL){
					$formatted_data['present'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$labels = [1,2,3,4,5,6,7,8,9,10,11,12];
					for ($i=0; $i < count($labels); $i++) {
						$labels[$i] = date("F", mktime(0,0,0,$labels[$i],1,$year));
					}
					foreach ($present_result_set as $result) {
						$formatted_data["present"][$result['month']-1] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						$formatted_data["absent"][$result['month']-1] = $result['count'];
					}
				}else{
					$formatted_data['present'] = [0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0];
					$labels = ["week-1","week-2","week-3","week-4","week-5","week-6"];
					foreach ($present_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["present"][$week_no] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["absent"][$week_no] = $result['count'];
					}
				}
				echo json_encode(["labels"=>$labels,"data"=>$formatted_data]);
			}else{
				echo "FALSE";
			}
		}

		// for dashboard student attendance
		public function dashboard_student_attendance_overview_doughnut(){
			$date = $_POST['date'];

			if(empty($date)){
				$date = date("Y-m-d");
			}
			$this->load->model('attendance');
			$present_result = $this->load->attendance->dashboard_student_attendance_overview_bar($date,1);
			$absent_result = $this->load->attendance->dashboard_student_attendance_overview_bar($date,0);

			if($present_result !== FALSE && $absent_result !== FALSE){
				echo json_encode(['present'=>$present_result,'absent'=>$absent_result]);
			}else{
				echo 'FALSE';
			}
		}

		// for overview particular teacher attendance
		public function teacher_attendance_overview_bar(){

			if(!isset($_POST)){
				echo 'FALSE';
				return;
			}

			$teacher_id = $_POST['teacher_id_bar'];
			$year = $_POST['year_bar'];
			$month = $_POST['month_bar'];

			if(empty($teacher_id)){
				echo 'FALSE';
				return;
			}

			if($year === "this"){
				$year = date('Y');
			}
			if($month === "this"){
				$month = date('m');
			}else if($month == 0){
				$month = NULL;
			}

			$this->load->model('attendance');
			$present_result_set = $this->load->attendance->teacher_attendance_overview_bar($teacher_id,$year,$month,1);
			$absent_result_set = $this->load->attendance->teacher_attendance_overview_bar($teacher_id,$year,$month,0);
			$formatted_data = ["present"=>[],"absent"=>[]];
			$labels = [];
			if($present_result_set && $absent_result_set){
				$present_result_set = $present_result_set->fetchAll();
				$absent_result_set = $absent_result_set->fetchAll();
				if($month == NULL){
					$formatted_data['present'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0,0,0,0,0,0,0];
					$labels = [1,2,3,4,5,6,7,8,9,10,11,12];
					for ($i=0; $i < count($labels); $i++) {
						$labels[$i] = date("F", mktime(0,0,0,$labels[$i],1,$year));
					}
					foreach ($present_result_set as $result) {
						$formatted_data["present"][$result['month']-1] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						$formatted_data["absent"][$result['month']-1] = $result['count'];
					}
				}else{
					$formatted_data['present'] = [0,0,0,0,0,0];
					$formatted_data['absent'] = [0,0,0,0,0,0];
					$labels = ["week-1","week-2","week-3","week-4","week-5","week-6"];
					foreach ($present_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["present"][$week_no] = $result['count'];
					}
					foreach ($absent_result_set as $result) {
						if( date('W', mktime(0,0,0,1,1,$year)) != 1 ){
							$week_no = ($result['week'] +1 - (date("W", mktime(0,0,0,$month,1,$year))+1)%53);
						}else{
							$week_no = ($result['week'] +1 - date("W", mktime(0,0,0,$month,1,$year)));
						}
						$formatted_data["absent"][$week_no] = $result['count'];
					}
				}
				echo json_encode(["labels"=>$labels,"data"=>$formatted_data]);
			}else{
				echo "FALSE";
			}
		}

		// for dashboard teacher attendance
		public function dashboard_teacher_attendance_overview_doughnut(){
			$date = $_POST['date'];

			if(empty($date)){
				$date = date("Y-m-d");
			}
			$this->load->model('attendance');
			$present_result = $this->load->attendance->dashboard_teacher_attendance_overview_bar($date,1);
			$absent_result = $this->load->attendance->dashboard_teacher_attendance_overview_bar($date,0);

			if($present_result !== FALSE && $absent_result !== FALSE){
				echo json_encode(['present'=>$present_result,'absent'=>$absent_result]);
			}else{
				echo 'FALSE';
			}
		}
	}

 ?>