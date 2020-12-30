<?php 
	
	class ApiDrawChart extends Controller{
		public function __construct() {
			parent::__construct();
		}

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
					foreach ($present_result_set as $result) {
						$m = date("F", mktime(0,0,0,$result['month'],1,$year));
						if( !in_array($m,$labels)){
							array_push($labels, $m);
						}
						array_push($formatted_data["present"], $result['count']);
					}
					foreach ($absent_result_set as $result) {
						$m = date("F", mktime(0,0,0,$result['month'],1,$year));
						if( !in_array($m,$labels)){
							array_push($labels, $m);
						}
						array_push($formatted_data["absent"], $result['count']);
					}
				}else{
					foreach ($present_result_set as $result) {
						$week_no = "week-".($result['week'] +2 - date("W", mktime(0,0,0,$month,1,$year)));

						if( !in_array($week_no,$labels)){
							array_push($labels, $week_no);
						}
						array_push($formatted_data["present"], $result['count']);
					}
					foreach ($absent_result_set as $result) {
						$week_no = "week-".($result['week'] +2 -date("W", mktime(0,0,0,$month,1,$year)));
						if( !in_array($week_no,$labels)){
							array_push($labels, $week_no);
						}
						array_push($formatted_data["absent"], $result['count']);
					}
				}
				echo json_encode(["labels"=>$labels,"data"=>$formatted_data]);
			}else{
				echo "FALSE";
			}
		}
	}

 ?>